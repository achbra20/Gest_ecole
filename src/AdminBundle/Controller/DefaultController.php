<?php

namespace AdminBundle\Controller;

use AdminBundle\Entity\Eleve;
use AdminBundle\Entity\paiement;
use AdminBundle\Entity\Payer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
     public function PrincipalAction ()
     {
         $em=$this->getDoctrine()->getManager();
         $eleveann= $this->EleveSansClasse(); //les eleve non jamais effectuer a une classe
         $eleve = $em->getRepository('AdminBundle:Eleve')->findEleveSansClass();
         $eleveNonPayer= $this->EleveNonpayer();
         return $this->render('AdminBundle:Principal:principal.html.twig',array('eleves'=>$eleve,'elevesnon'=>$eleveNonPayer,'eleveanns'=>$eleveann));

     }
     // trouver les eleves non payer
     public function EleveNonpayer()
     {
         $em=$this->getDoctrine()->getManager();
         $eleves = $em->getRepository('AdminBundle:Eleve')->findAll();
         $payers= $em->getRepository('AdminBundle:Payer')->findAll();
         $result= new \Doctrine\Common\Collections\ArrayCollection();
         foreach ($eleves as $eleve)
         {
             $result[]=$eleve;
             foreach ($payers as $payer )
             {
                 if($eleve == $payer->getEleve())
                 {
                     $result->removeElement($eleve);
                 }

             }
         }
       return $result;
     }
     // les eleves sans classe cette annee
     public function EleveSansClasse()
     {
         $em = $this->getDoctrine()->getManager();
         $annees = $em->getRepository('AdminBundle:Annee')->findAnneeActuelle();
         $eleveann = $em->getRepository('AdminBundle:Eleve')->findEleveSansClassCetteAnnee($annees[0]->getID());
         $eleveall = $em->getRepository('AdminBundle:Eleve')->findAll();
         $result = new \Doctrine\Common\Collections\ArrayCollection();
         foreach ($eleveall as $eleve) {
             if (count($eleve->getClasse())>0) {
                 $result[] = $eleve;
                 foreach ($eleveann as $elevean) {
                     if ($eleve == $elevean) {
                         $result->removeElement($eleve);
                     }

                 }
             }
         }
         return $result;

     }

     public function nombreMoisPayer()
     {
         $em=$this->getDoctrine()->getManager();
         $paiement = new paiement();
         $paiement=$em->getRepository('AdminBundle:paiement')->find(5);
         $datedeb=$paiement->getDateDeb();
         $datefin=$paiement->getDateFin();
         $date= $datedeb->diff($datefin)->m;
         var_dump($date);
     }
}
