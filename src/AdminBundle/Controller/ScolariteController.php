<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Annee;
use AdminBundle\Entity\Coefficient;
use AdminBundle\Entity\Eleve;
use AdminBundle\Entity\Matiere;
use AdminBundle\Form\CoefficientType;
use AdminBundle\Form\MatiereType;
use AdminBundle\Form\SalleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AdminBundle\Form\NiveauType;
use AdminBundle\Form\ClasseType;
use AdminBundle\Entity\Niveau;
use AdminBundle\Entity\Classe;
use AdminBundle\Repository\EleveRepository;
use Symfony\Component\HttpFoundation\Response;

class ScolariteController extends Controller
{
    //----------------------------------Gestion des niveau----------------------------------

    // liste des niveau avec l'ajout
    public function listeniveauAction(Request $request,$res)
    {
        $form=$this -> createForm(NiveauType::class);
        $em=$this->getDoctrine()->getManager();
        try{
        if ($request -> isMethod('Post')) // verifier si la method et Post
        {
            $form->handleRequest($request);
            if ($form -> isValid() && $form->isSubmitted())
            {
                $niveau= $form->getData();
                 $em->persist($niveau);
                $em->flush();
                $res=1;
            }
        }
        }catch (\Exception $e)
         { $res=2;}
        $niveau=$em->getRepository('AdminBundle:Niveau')->findAll(array('libelle'=>'DESC'));
        return $this->render('AdminBundle:Scolariter:listeNiveau.html.twig',array('form'=>$form->createView(),'niveaux'=>$niveau,'res'=>$res));
    }

    // Fonction pour supprimer un niveau
    public function deleteNiveauAction($id)
    {    try{
         $em= $this->getDoctrine()->getManager();
         $niveau = $em->getRepository('AdminBundle:Niveau')->find($id);
         $em->remove($niveau);
         $em->flush();
         }catch (\Exception $e)
         { $res=2;}
         return $this->redirect($this->generateUrl('admin_listeniveau'));
    }

    //modifier un niveau
    public function modifierNiveauAction(Request $request ,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $niveau = $em->getRepository('AdminBundle:Niveau')->find($id);
        $form=$this -> createForm(NiveauType::class, $niveau);
        try{
        if ($request -> isMethod('Post')) // verifier si la method et Post
        {

            $form->handleRequest($request);
            if ($form -> isValid() && $form->isSubmitted())
            {
                $niveau= $form->getData();
                $em= $this->getDoctrine()->getManager();
                $em->persist($niveau);
                $em->flush();
                $res=1;
                return $this->redirect($this->generateUrl('admin_listeniveau',array('res'=>$res)));
            }
        }
        }catch (\Exception $e)
        { $res=2;}
        return $this->render('AdminBundle:Scolariter:modifierNiveau.html.twig',array('formm'=>$form->createView(),'niveau'=>$niveau));
    }

    //Compter Les nombre de classe par niveau
    public function calNiveauparClasseAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $niveau = $em->getRepository('AdminBundle:Niveau')->find($id);
        $classe = $em->getRepository('AdminBundle:Classe')->findBy(array('Niveau'=>$niveau));
        $nb= count($classe);
        return  new Response($nb);
    }

    //---------------------------------------- Gestion des Classe----------------------------

     //Liste des CLasse avec l'ajout
    public function listeclasseAction(Request $request ,$res)
    {
        $form=$this -> createForm(ClasseType::class);
        $em=$this->getDoctrine()->getManager();

        try {
            if ($request->isMethod('Post')) // verifier si la method et Post
            {
                $form->handleRequest($request);
                if ($form->isValid() && $form->isSubmitted()) {
                    $annee=$em->getRepository('AdminBundle:Annee')->findAnneeActuelle();
                    $classe = $form->getData();
                    $classe->setAnnee($annee[0]);
                    $em->persist($classe);
                    $em->flush();
                    $res = 1;
                }
            }
        }catch (\Exception $e)
        { $res=2;}
        $classe=$em->getRepository('AdminBundle:Classe')->findAll(array('libelle'=>'DESC'));
        return $this->render('AdminBundle:Scolariter:listeClasse.html.twig',array('form'=>$form->createView(),'classes'=>$classe,'res'=>$res));
    }

    // Fonction pour supprimer un niveau
    public function deleteClasseAction($id)
    {   try{
        $em= $this->getDoctrine()->getManager();
        $classe = $em->getRepository('AdminBundle:Classe')->find($id);
        $em->remove($classe);
        $em->flush();
        $res=1;
        }catch (\Exception $e)
         { $res=2;}
        return $this->redirect($this->generateUrl('admin_liste_classe',array('res'=>$res)));
    }

    //modifier classe
    public function modifierClasseAction(Request $request ,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $classe = $em->getRepository('AdminBundle:Classe')->find($id);
        $form=$this -> createForm(ClasseType::class, $classe);
        try{
        if ($request -> isMethod('Post')) // verifier si la method et Post
        {
            $form->handleRequest($request);
            if ($form -> isValid() && $form->isSubmitted())
            {
                $classe= $form->getData();
                $em= $this->getDoctrine()->getManager();
                $em->persist($classe);
                $em->flush();
                $res=1;
                return $this->redirect($this->generateUrl('admin_liste_classe',array('res'=>$res)));
            }
        }
        }catch (\Exception $e)
        { $res=2;}
        return $this->render('AdminBundle:Scolariter:modifierClasse.html.twig',array('formm'=>$form->createView(),'classe'=>$classe));
    }

    //Liste des Eleve par CLasse
    public function listeEleveClasseAction($id,$res)
    {
        $em= $this->getDoctrine()->getManager();
        $classe= $em->getRepository('AdminBundle:Classe')->find($id);
        return $this->render('AdminBundle:Scolariter:ListeEleveClasse.html.twig',array('classe'=>$classe,'res'=>$res));
    }

    //Liste des Eleve ajouter dans un classe
    public function listeAjouterEleveClasseAction(Request $request,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $classe= $em->getRepository('AdminBundle:Classe')->find($id);
        try{
            if ($request -> isMethod('Post')) // verifier si la method et Post
            {
                $ide=$_POST['eleve'];
                foreach($ide as $value) {
                     $eleve = $em->getRepository("AdminBundle:Eleve")->find($value);
                     $this->VerifEleveClasse($eleve);
                     $eleve->addClasse($classe);
                }
                $em->persist($classe);
                $em->flush();
                $res=1;
                return $this->redirect($this->generateUrl('admin_liste_classe_eleve',array('id'=>$id,'res'=>$res)));
            }
        }catch (\Exception $e)
        { $res=2;}
       $eleve= $em->getRepository('AdminBundle:Eleve')->findAll();
       return $this->render('AdminBundle:Scolariter:ListeAjouterEleveClasse.html.twig',array('eleves'=>$eleve,'classe'=>$classe));
    }

    //Verfier L'eleve dans annee apratiant a une seul classe
    public function VerifEleveClasse($Eleve)
    {
        $em= $this->getDoctrine()->getManager();
        $annees=$em->getRepository('AdminBundle:Annee')->findAnneeActuelle();
        $annee=$annees[0];
        $classes=$em->getRepository('AdminBundle:Classe')->findClasseAnneeActuelle($annee->getId());
        $calEs = $Eleve->getClasse();
        foreach ($classes as $classe)
        {
            foreach ($calEs as $calE)
            {
                if ($calE->getId()==$classe->getId())
                {
                    $Eleve->removeClasse($classe);
                    $em->persist($Eleve);
                    return 1;
                }
            }
        }
        return 0;
    }

    // supprimer un eleve d'une classe
    public function supprimerEleveClasseAction($id,$idclasse)
    {
        try{
        $em= $this->getDoctrine()->getManager();
        $eleve = $em->getRepository("AdminBundle:Eleve")->find($id);
        $classe= $em->getRepository('AdminBundle:Classe')->find($idclasse);
        $eleve->removeClasse($classe);
        $em->persist($eleve);
        $em->flush();
        $res=1;
        }catch (\Exception $e)
       { $res=2;}
        return $this->redirect($this->generateUrl('admin_liste_classe_eleve',array('id'=>$idclasse,'res'=>$res)));
    }

    //-----------------------------------------Gestion des salles-----------------------------------

    // Liste des salle avec le formaulaire d'ajout
    public function listeSalleAction(Request $request ,$res)
    {
        $form=$this -> createForm(SalleType::class);
        $em=$this->getDoctrine()->getManager();

        try {
            if ($request->isMethod('Post')) // verifier si la method et Post
            {
                $form->handleRequest($request);
                if ($form->isValid() && $form->isSubmitted()) {

                    $salle = $form->getData();
                    $em->persist($salle);
                    $em->flush();
                    $res = 1;
                }
            }
        }catch (\Exception $e)
        { $res=2;}
        $salle=$em->getRepository('AdminBundle:Salle')->findAll(array('libelle'=>'DESC'));
        return $this->render('AdminBundle:Ressource:listeSalle.html.twig',array('form'=>$form->createView(),'salles'=>$salle,'res'=>$res));
    }

    //Modifier Salle
    public function modifierSalleAction(Request $request ,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $salle = $em->getRepository('AdminBundle:Salle')->find($id);
        $form=$this -> createForm(SalleType::class, $salle);
        try{
            if ($request -> isMethod('Post')) // verifier si la method et Post
            {
                $form->handleRequest($request);
                if ($form -> isValid() && $form->isSubmitted())
                {
                    $salle= $form->getData();
                    $em= $this->getDoctrine()->getManager();
                    $em->persist($salle);
                    $em->flush();
                    $res=1;
                    return $this->redirect($this->generateUrl('admin_liste_salle',array('res'=>$res)));
                }
            }
        }catch (\Exception $e)
        { $res=2;}
        return $this->render('AdminBundle:Ressource:formModifierSalle.html.twig',array('formm'=>$form->createView(),'salle'=>$salle));
    }

     //Supprimer une salle
    public function supprimerSalleAction($id)
    {
        try{
            $em= $this->getDoctrine()->getManager();
            $salle = $em->getRepository("AdminBundle:Salle")->find($id);
            $em->remove($salle);
            $em->flush();
            $res=1;
        }catch (\Exception $e)
        { $res=2;}
        return $this->redirect($this->generateUrl('admin_liste_salle',array('res'=>$res)));
    }

    //-------------------------------------------Gestion des Matiere------------------------------------
    // Liste des matiere avec le formaulaire d'ajout
    public function listeMatiereAction(Request $request ,$res)
    {
        $form=$this -> createForm(MatiereType::class);
        $em=$this->getDoctrine()->getManager();

        try {
            if ($request->isMethod('Post')) // verifier si la method et Post
            {
                $form->handleRequest($request);
                if ($form->isValid() && $form->isSubmitted()) {

                    $matiere= $form->getData();
                    $em->persist($matiere);
                    $em->flush();
                    $res = 1;
                }
            }
        }catch (\Exception $e)
        { $res=2;}
        $matiere=$em->getRepository('AdminBundle:Matiere')->findAll(array('libelle'=>'DESC'));
        return $this->render('AdminBundle:Scolariter:ListeMatiere.html.twig',array('form'=>$form->createView(),'matieres'=>$matiere,'res'=>$res));
    }

    //Supprimer une Matiere
    public function supprimerMatiereAction($id)
    {
        try{
            $em= $this->getDoctrine()->getManager();
            $matiere = $em->getRepository("AdminBundle:Matiere")->find($id);
            $em->remove($matiere);
            $em->flush();
            $res=1;
        }catch (\Exception $e)
        { $res=2;}
        return $this->redirect($this->generateUrl('admin_liste_matiere',array('res'=>$res)));
    }

    //Modifier Matiere
    public function modifierMatiereAction(Request $request ,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $matiere = $em->getRepository('AdminBundle:Matiere')->find($id);
        $form=$this -> createForm(MatiereType::class, $matiere);
        try{
            if ($request -> isMethod('Post')) // verifier si la method et Post
            {
                $form->handleRequest($request);
                if ($form -> isValid() && $form->isSubmitted())
                {
                    $matiere= $form->getData();
                    $em= $this->getDoctrine()->getManager();
                    $em->persist($matiere);
                    $em->flush();
                    $res=1;
                    return $this->redirect($this->generateUrl('admin_liste_matiere',array('res'=>$res)));
                }
            }
        }catch (\Exception $e)
        { $res=2;}
        return $this->render('AdminBundle:Scolariter:modfierMatiere.html.twig',array('formm'=>$form->createView(),'matiere'=>$matiere));
    }

    //-------------------------------------------Affectation des matiere  pour un niveau-------------------

    // Liste des matiere par niveau
    public function listeMatiereNiveauAction(Request $request ,$res,$id)
    {
        $form=$this -> createForm(CoefficientType::class);
        $em=$this->getDoctrine()->getManager();
        $niveau= $em->getRepository('AdminBundle:Niveau')->find($id);
        try {
            if ($request->isMethod('Post')) // verifier si la method et Post
            {
                $form->handleRequest($request);
                if ($form->isValid() && $form->isSubmitted()) {

                    $coeff= $form->getData();
                    $coeff->setNiveau($niveau);
                    $em->persist($coeff);
                    $em->flush();
                    $res = 1;
                }
            }
        }catch (\Exception $e)
        { $res=2;}
        $coeff=$em->getRepository('AdminBundle:Coefficient')->findBy(array('niveau' => $niveau));
        return $this->render('AdminBundle:Scolariter:ListeMatiereNiveau.html.twig',array('form'=>$form->createView(),'coeffs'=>$coeff,'res'=>$res,'niveau'=>$niveau));
    }

    //Modifier Niveau Matiere
    public function modifierNiveauMatiereAction(Request $request ,$id)
    {
        $em= $this->getDoctrine()->getManager();
        $ceo= $em->getRepository('AdminBundle:Coefficient')->find($id);
        $form=$this -> createForm(CoefficientType::class, $ceo);
        try{
            if ($request -> isMethod('Post')) // verifier si la method et Post
            {
                $form->handleRequest($request);
                if ($form -> isValid() && $form->isSubmitted())
                {
                    $ceo= $form->getData();
                    $em= $this->getDoctrine()->getManager();
                    $em->persist($ceo);
                    $em->flush();
                    $res=1;
                    return $this->redirect($this->generateUrl('admin_liste_niveau_matiere',array('res'=>$res,'id'=>$ceo->getNiveau()->getId())));
                }
            }
        }catch (\Exception $e)
        { $res=2;}
        return $this->render('AdminBundle:Scolariter:modifieNiveauMatiere.html.twig',array('formm'=>$form->createView(),'ceo'=>$ceo));
    }

    //Supprimer matiere niveau
    public function supprimerMatiereniveauAction($id)
    {
        try{
            $em= $this->getDoctrine()->getManager();
            $ceo = $em->getRepository("AdminBundle:Coefficient")->find($id);
            $niveau= $ceo->getNiveau();
            $matiere= $ceo->getMatiere();
            $niveau->removeCoefficient($ceo);
            $matiere->removeCoefficient($ceo);
            $em->remove($ceo);
            $em->flush();
            $res=1;
        }catch (\Exception $e)
        { $res=2;}
        return $this->redirect($this->generateUrl('admin_liste_niveau_matiere',array('res'=>$res,'id'=>$ceo->getNiveau()->getId())));
    }
}
