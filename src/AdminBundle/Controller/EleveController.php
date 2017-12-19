<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Entity\Eleve;
use AdminBundle\Form\EleveType;
use AdminBundle\Form\ExportType;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\ParameterBag;

class EleveController extends Controller
{
    //afficher la liste des éleve inscrit
    public function listeeleveAction(Request $request ,$res)
    {
        $form_ajout=$this -> createForm(EleveType::class);
        $form_export=$this->createForm(ExportType::class);

        if ($request -> isMethod('Post')) // verifier si la method et Post
        {   $res=2;
            $res=$this->verifAjoutEleve($request,$form_ajout);
        }
        $em=$this->getDoctrine()->getManager();
        $eleve= $em->getRepository('AdminBundle:Eleve')->findAll(array('nom'=>'DESC'));
        return $this->render('AdminBundle:Eleve:listeEleve.html.twig', array('form'=>$form_ajout->createView(),'formex'=>$form_export->createView(),'res'=>$res,'eleves'=>$eleve));
    }

    //consulter un eleve
    public function consultereleveAction ($id)
    {
        $em=$this->getDoctrine()->getManager();
        $eleve= $em->getRepository('AdminBundle:Eleve')->find($id);
        return $this->render('AdminBundle:Eleve:consulterEleve.html.twig',array('eleve'=>$eleve));
    }

    // la fonction pour ajouter un nouveau eleve
    public function modifierEleveAction(Request $request,$id)
{
    $em=$this->getDoctrine()->getManager();
    $eleve= $em->getRepository('AdminBundle:Eleve')->find($id);
    $form_ajout=$this -> createForm(EleveType::class,$eleve); // creation du formulaire
    if ($request -> isMethod('Post')) // verifier si la method et Post
    {
        $this->verifAjoutEleve($request,$form_ajout);
        $res=1;
        return $this->redirect($this->generateUrl('admin_listeeleve',array('res'=>$res)));
    }
    return $this->render('AdminBundle:Eleve:modifEleve.html.twig', array('form'=>$form_ajout->createView(),'eleve'=>$eleve));
}

// la fonction qui executer l'ajout
    public function verifAjoutEleve(Request $request, $form)
    {
        $form->handleRequest($request);
        if ($form -> isValid())
        {
            $eleve= $form->getData();
            $eleve->setDateentre(new \DateTime('now'));
            $em= $this->getDoctrine()->getManager();
            $em->persist($eleve);
            $em->flush();
            return 1;
        }
    }

   // fonction de suppresion d'un eleve
    public function deleteEleveAction($id)
    {
        $em= $this->getDoctrine()->getManager();
        $eleve = $em->getRepository('AdminBundle:Eleve')->find($id);
        $em->remove($eleve);
        $em->flush();
        $res=1;
        return $this->redirect($this->generateUrl('admin_listeeleve',array('res'=>$res)));
    }

    //Telecharger modele
    public function telechahergerAction() {
        $container = $this->getDoctrine();
        $response = new StreamedResponse(function() use($container) {

            $handle = fopen('php://output', 'r+');
            fputcsv($handle, array('Nom',
                'prenom',
                'date Naissance',
                'lieu naissance',
                'sexe',
                'adresse',
                'code postal',
                'ville',
                'telephone',
                'ecole precedente',
                'niveau precedent',
                'date entrer',
                'nom pere',
                'fonction pere',
                'telephone pere',
                'nom mere',
                'fonction mere',
                'telephone mere',
                'adresse parent',
            ),';');
            fclose($handle);
        });
       // $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename="eleve.csv"');
        return $response;
    }

   // Exportation des eleve dans fichier csv
    public function exportEleveAction() {
        $container = $this->getDoctrine();
        $response = new StreamedResponse(function() use($container) {
            $em = $container->getManager();
            $results =$em->getRepository('AdminBundle:Eleve')->findAll();
            $handle = fopen('php://output', 'r+');
            fputcsv($handle, array('Nom',
                'prenom',
                'date Naissance',
                'lieu naissance',
                'sexe',
                'adresse',
                'code postal',
                'ville',
                'telephone',
                'ecole precedente',
                'niveau precedent',
                'date entrer',
                'nom pere',
                'fonction pere',
                'telephone pere',
                'nom mere',
                'fonction mere',
                'telephone mere',
                'adresse parent',
            ),';');

            foreach ($results as $eleve) {

                fputcsv($handle,array(
                    $eleve->getNom(),
                    $eleve->getPrenom(),
                    date_format($eleve->getDateNais(), 'd/m/Y'),
                    $eleve->getLieuNaisance(),
                    $eleve->getSexe(),
                    $eleve->getAdress(),
                    $eleve->getCodePostal(),
                    $eleve->getVille(),
                    $eleve->getTel(),
                    $eleve->getArrivede(),
                    $eleve->getNivPrec(),
                    date_format($eleve->getDateentre(), 'd/m/Y'),
                    $eleve->getNomPere(),
                    $eleve->getFonctionPere(),
                    $eleve->getTelParent1() ,
                    $eleve->getNomMere(),
                    $eleve->getFonctionMere(),
                    $eleve->getTelParent2(),
                    $eleve->getAdressParent(),
                    ),";" );
            }
            fclose($handle);
        });
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Type', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename="eleve.csv"');
        return $response;
    }

    // Imporataion des eleves d'un fichier csv
    public function importEleveAction(Request $request)
    {
        if ($request -> isMethod('Post')) // verifier si la method et Post
        {
            $em = $this->getDoctrine()->getManager();
            $chemin=$this->get('kernel')->getRootDir().'/../web';
            $destination=$_FILES["file"]['name'];
            move_uploaded_file($_FILES["file"]['tmp_name'], $destination);
            $webPath = $chemin.'/'.$destination;
            $handle = fopen($webPath, "r+");
            $fileop = fgetcsv($handle,1000, ";");
            while(($fileop = fgetcsv($handle,1000, ";")) !== false){
                $eleve = new Eleve();
                $eleve->setNom($fileop[0]);
                $eleve->setPrenom($fileop[1]);
               // $date =  date("Y-m-d", strtotime($fileop[2]));
                $eleve->setDateNais(new \DateTime($fileop[2]));
                $eleve->setLieuNaisance($fileop[3]);
                $eleve->setSexe($fileop[4]);
                $eleve->setAdress($fileop[5]);
                $eleve->setCodePostal($fileop[6]);
                $eleve->setVille($fileop[7]);
                $eleve->setTel($fileop[8]);
                $eleve->setArrivede($fileop[9]);
                $eleve->setNivPrec($fileop[10]);
                $eleve->setNomPere($fileop[12]);
                $eleve->setFonctionPere($fileop[13]);
                $eleve->setTelParent1($fileop[14]);
                $eleve->setNomMere($fileop[15]);
                $eleve->setFonctionMere($fileop[16]);
                $eleve->setTelParent2($fileop[17]);
                $eleve->setAdressParent($fileop[18]);
                $eleve->setDateentre(new \DateTime('now'));
                $em->persist($eleve);
                $em->flush();
            }

            $request->getSession()->getFlashBag()->add('success', 'Liste enregistrée.');
            $res=1;
            return $this->redirect($this->generateUrl('admin_listeeleve',array('res'=>$res)));
        }
        $res=2;
        return $this->redirect($this->generateUrl('admin_listeeleve',array('res'=>$res)));
    }
}
