<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Annee;
use AdminBundle\Entity\Eleve;
use AdminBundle\Entity\Niveau;
use AdminBundle\Entity\paiement;
use AdminBundle\Entity\Payer;
use AdminBundle\Entity\Service;
use AdminBundle\Form\AnneeType;
use AdminBundle\Form\paiementType;
use AdminBundle\Form\PayerType;
use AdminBundle\Form\ServiceType;
use AdminBundle\Form\PaimentNiveauType;
use AdminBundle\Form\PrixNiveauType;
use AdminBundle\Repository\PayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class PaiementController extends Controller
{
    //liste des Eleves
    public function listeElevesAction($res)
    {
        $em= $this->getDoctrine()->getManager();
        $eleve= $em->getRepository('AdminBundle:Eleve')->findAll();
        $annees = $em->getRepository('AdminBundle:Annee')->findAnneeActuelle();
        $payer=$em->getRepository('AdminBundle:Payer')->findPaiementdeAnnee($annees[0]->getId());
        return $this->render('AdminBundle:Payer:ListeEleve.html.twig',array('eleves'=>$eleve,'payers'=>$payer,'res'=>$res,'annee'=>$annees[0]));

    }

    //liste des paiements pour un eleve
    public function paiementEleveAction(Request $request,$id,$res)
    {
        $em= $this->getDoctrine()->getManager();
        $eleve= $em->getRepository('AdminBundle:Eleve')->find($id);
        $niveau=$this->FindNiveauDeEleve($eleve);
        try{
            if ($request -> isMethod('Post')) // verifier si la method et Post
            {
                $ide=$_POST['tranche'];
                $paiement = $em->getRepository("AdminBundle:paiement")->find($ide);
                $annee=$em->getRepository('AdminBundle:Annee')->findAnneeActuelle();
                $payer=new Payer();
                $payer->setEleve($eleve);
                $payer->setDatePayer(new \DateTime('now'));
                $payer->setPaiment($paiement);
                $payer->setAnnee($annee[0]);
                $montant= ($paiement->getNbmois())*($niveau->getPrixmois())-($paiement->getNbmois())*($niveau->getPrixmois())*$paiement->getRemise();
                $payer->setMontant($montant);
                $em->persist($payer);
                $em->flush();
                $res=1;
            }
        }catch (\Exception $e)
        { $res=2;}
        $payer= $em->getRepository('AdminBundle:Payer')->findPaiementByEleve($id);
        return $this->render('AdminBundle:Payer:Paimentliste.html.twig',array('payers'=>$payer,'niveau'=>$niveau,'eleve'=>$eleve,'res'=>$res));
    }

    // trouve le niveau d'eleve pour l'annee scolaire en cour
    public function FindNiveauDeEleve($Eleve)
    {
        $em= $this->getDoctrine()->getManager();
        $annees=$em->getRepository('AdminBundle:Annee')->findAnneeActuelle();
        $annee=$annees[0];
        $classes=$em->getRepository('AdminBundle:Classe')->findClasseAnneeActuelle($annee->getId());
        $calEs = $Eleve->getClasse();
        foreach ($classes as $classe)
        {foreach ($calEs as $calE)
            { if ($calE->getId()==$classe->getId())
                {
                    return $classe->getNiveau();
                }
            }
        }
        return 0;
    }

    //-----------------------------------------------Configuration des tranche------------------------------------
    // liste et l'ajout des tranche
    public function confTrancheAction (Request $request,$res)
    {
        $paiement= new paiement();
        $em= $this->getDoctrine()->getManager();
        $form_ajout=$this -> createForm(paiementType::class, $paiement );
        try{
        if ($request -> isMethod('Post')) // verifier si la method et Post
        {
            $form_ajout->handleRequest($request);
            if ($form_ajout -> isValid())
            {
                $paiement= $form_ajout->getData();
                $nb= 1+$paiement->getDateDeb()->diff($paiement->getDateFin())->m;
                $paiement->setNbmois($nb);
                $em->persist($paiement);
                $em->flush();
                $res=1;
            }
        }
        }catch (\Exception $e)
        { $res=2;}
        $paiement= $em->getRepository('AdminBundle:paiement')->findAll();
        return $this->render('AdminBundle:Configuration:confTranche.html.twig',array('form'=>$form_ajout->createView(),'paiements'=>$paiement,'res'=>$res ));
    }

    // ajouter les niveau qui sont compatile avec cette tranche
    public function ajoutNiveauAction(Request $request ,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $paiement = $em->getRepository('AdminBundle:paiement')->find($id);
        $form=$this -> createForm(PaimentNiveauType::class);
        if ($request -> isMethod('Post')) // verifier si la method et Post
        {

            $form->handleRequest($request);
            if ($form -> isValid() && $form->isSubmitted())
            {
              try{
                $retour= $form->getData();
                $niveau= $em->getRepository('AdminBundle:Niveau')->find($retour['Niveau']);
                $paiement->addNiveau($niveau);
                $niveau->addPaiement($paiement);
                $em->persist($paiement);
                $em->flush();
                $res=1;
              }catch (\Exception $e)
              { $res=2;}
                return $this->redirect($this->generateUrl('admin_conf_tranche',array('res'=>$res)));
           }
        }
        return $this->render('AdminBundle:Configuration:formAjoutNivTranch.html.twig',array('formm'=>$form->createView(),'paiement'=>$paiement));
    }

    //Supprimer un type de tranche
    public function supprimerTrancheAction($id)
    {
        try{
            $em= $this->getDoctrine()->getManager();
            $paiment = $em->getRepository('AdminBundle:paiement')->find($id);
            $em->remove($paiment);
            $em->flush();
            $res=1;
        }catch (\Exception $e)
        { $res=2;}
        return $this->redirect($this->generateUrl('admin_conf_tranche',array('res'=>$res)));
    }

    // Supprimer  Niveau de tranche
    public function SuppNiveauAction($id ,$niveau)
    {
        try{
           $em= $this->getDoctrine()->getManager();
           $paiement = $em->getRepository('AdminBundle:paiement')->find($id);
           $niveaus = $em->getRepository('AdminBundle:niveau')->find($niveau);
           $paiement->removeNiveau($niveaus);
            $em->persist($paiement);
            $em->flush();

           $res=1;
        }catch (\Exception $e)
        { $res=2;}
        return $this->redirect($this->generateUrl('admin_conf_tranche',array('res'=>$res)));
    }

    //Modifier Tranche
    public function modifierTrancheAction(Request $request ,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $paiement = $em->getRepository('AdminBundle:paiement')->find($id);
        $form=$this -> createForm(paiementType::class, $paiement);
        try{
        if ($request -> isMethod('Post')) // verifier si la method et Post
        {
            $form->handleRequest($request);
            if ($form -> isValid() && $form->isSubmitted())
            {
                    $paiement= $form->getData();
                    $nb= 1+$paiement->getDateDeb()->diff($paiement->getDateFin())->m;
                    $paiement->setNbmois($nb);
                    $em->persist($paiement);
                    $em->flush();
                    $res=1;
                   return $this->redirect($this->generateUrl('admin_conf_tranche',array('res'=>$res)));
            }
        }
        }catch (\Exception $e)
         { $res=2;
           return $this->redirect($this->generateUrl('admin_conf_tranche',array('res'=>$res)));
         }
        return $this->render('AdminBundle:Configuration:formModifTranche.html.twig',array('form'=>$form->createView(),'paiement'=>$paiement));
    }
    //-----------------------------------------------------Gestion des annee scolaire---------------------------------------

    //liste des annee scolaire avec l'ajout
    public function listeanneeAction(Request $request,$res)
    {
        $annee = new Annee();
        $form=$this -> createForm(AnneeType::class,$annee);
        $em= $this->getDoctrine()->getManager();
        try{
            if ($request -> isMethod('Post')) // verifier si la method et Post
            {
                $form->handleRequest($request);
                if ($form -> isValid() && $form->isSubmitted())
                {
                    $em->persist($annee);
                    $em->flush();
                    $res=1;
                    return $this->redirect($this->generateUrl('admin_conf_annee',array('res'=>$res)));
                }
            }
        }catch (\Exception $e)
        { $res=2;
            return $this->redirect($this->generateUrl('admin_conf_annee',array('res'=>$res)));
        }
        $annee= $em->getRepository('AdminBundle:Annee')->findAll();
        return $this->render('AdminBundle:Configuration:AnneeScolaire.html.twig',array('form'=>$form->createView(),'res'=>$res,'annees'=>$annee));
    }

    //Suppresion des annee scolaire
    public function SuppanneeAction($id)
    {
        try{
            $em= $this->getDoctrine()->getManager();
            $annee = $em->getRepository('AdminBundle:Annee')->find($id);
            $em->remove($annee);
            $em->flush();

            $res=1;
        }catch (\Exception $e)
        { $res=2;}
        return $this->redirect($this->generateUrl('admin_conf_annee',array('res'=>$res)));
    }
    //-----------------------------------------------------Configuration des prix des niveaux--------------------------------

    // préciser la prix de niveau par mois
    public function prixNiveauAction (Request $request,$res)
    {
        $em=$this->getDoctrine()->getManager();
        $niveau=$em->getRepository('AdminBundle:Niveau')->findAll();
        return $this->render('AdminBundle:Configuration:prixNiveau.html.twig',array('niveaux'=>$niveau,'res'=>$res));

    }

    //Modifier la prix de niveau
    public function modifierPrixNiveauAction (Request $request,$id)
    {
        $em= $this->getDoctrine()->getManager();

        $niveau=$em->getRepository('AdminBundle:Niveau')->find($id);
        $form=$this -> createForm(PrixNiveauType::class, $niveau);
        try{
            if ($request -> isMethod('Post')) // verifier si la method et Post
            {
                $form->handleRequest($request);
                if ($form -> isValid() && $form->isSubmitted())
                {
                    $em->persist($niveau);
                    $em->flush();
                    $res=1;
                    return $this->redirect($this->generateUrl('admin_prix_niveau',array('res'=>$res)));
                }
            }
        }catch (\Exception $e)
        { $res=2;
          return $this->redirect($this->generateUrl('admin_prix_niveau',array('res'=>$res)));
        }
        return $this->render('AdminBundle:Configuration:formModifPrixNiveau.html.twig',array('form'=>$form->createView(),'niveau'=>$niveau));

    }

    //Annee Scolaire
    public function modifierAnneeAction (Request $request,$id)
    {
        $em= $this->getDoctrine()->getManager();

        $annee=$em->getRepository('AdminBundle:Annee')->find($id);
        $form=$this -> createForm(AnneeType::class, $annee);
        try{
            if ($request -> isMethod('Post')) // verifier si la method et Post
            {
                $form->handleRequest($request);
                if ($form -> isValid() && $form->isSubmitted())
                {
                    $em->persist($annee);
                    $em->flush();
                    $res=1;
                    return $this->redirect($this->generateUrl('admin_conf_annee',array('res'=>$res)));
                }
            }
        }catch (\Exception $e)
        { $res=2;
            return $this->redirect($this->generateUrl('admin_conf_annee',array('res'=>$res)));
        }
        return $this->render('AdminBundle:Configuration:formModifierAnnee.html.twig',array('form'=>$form->createView(),'annee'=>$annee));

    }

    //-------------------------------------------------Configuration des Service----------------------------------------------

    //lister les service
    public function listeserviceAction (Request $request,$res)
    {
        $service= new Service();
        $em= $this->getDoctrine()->getManager();
        $form_ajout=$this -> createForm(ServiceType::class);
        try{
            if ($request -> isMethod('Post')) // verifier si la method et Post
            {
                $form_ajout->handleRequest($request);
                if ($form_ajout -> isValid())
                {

                    $service= $form_ajout->getData();
                    $em->persist($service);
                    $em->flush();
                    $res=1;
                }
            }
        }catch (\Exception $e)
        { $res=2;}
        $service= $em->getRepository('AdminBundle:Service')->findAll();
        return $this->render('AdminBundle:Configuration:listeService.html.twig',array('form'=>$form_ajout->createView(),'res'=>$res,'services'=>$service ));

    }

    // Supprimer service
    public function SuppserviceAction($id)
    {
        try{
            $em= $this->getDoctrine()->getManager();
            $service = $em->getRepository('AdminBundle:Service')->find($id);
            $em->remove($service);
            $em->flush();

            $res=1;
        }catch (\Exception $e)
        { $res=2;}
        return $this->redirect($this->generateUrl('admin_liste_service',array('res'=>$res)));
    }

    //Modifier service
    public function modifierServiceAction (Request $request,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $service=$em->getRepository('AdminBundle:Service')->find($id);
        $form=$this -> createForm(ServiceType::class, $service);
        try{
            if ($request -> isMethod('Post')) // verifier si la method et Post
            {
                $form->handleRequest($request);
                if ($form -> isValid() && $form->isSubmitted())
                {
                    $em->persist($service);
                    $em->flush();
                    $res=1;
                    return $this->redirect($this->generateUrl('admin_liste_service',array('res'=>$res)));
                }
            }
        }catch (\Exception $e)
        { $res=2;
            return $this->redirect($this->generateUrl('admin_liste_service',array('res'=>$res)));
        }
        return $this->render('AdminBundle:Configuration:formModifierService.html.twig',array('form'=>$form->createView(),'service'=>$service));

    }

    //--------------------------------------------------Procedure de paiment----------------------------------

}
