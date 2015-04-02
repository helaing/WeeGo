<?php

namespace BestTrip\WeeGoBundle\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BestTrip\WeeGoBundle\Entity\RecommandationLieu;
use BestTrip\WeeGoBundle\Entity\Lieu;
use BestTrip\WeeGoBundle\Entity\Hotel;
use BestTrip\WeeGoBundle\Entity\Restaurant;
use BestTrip\WeeGoBundle\Form\HotelForm;
use BestTrip\WeeGoBundle\Form\RestaurantForm;
use Zend\Stdlib\DateTime;

class LieuController extends Controller {

    public function afficherAction() {
        $em = $this->getDoctrine()->getManager();
        $lieu = $em->getRepository('BestTripWeeGoBundle:Lieu')->findAll();
        return $this->render('BestTripWeeGoBundle:Lieu:afficherLieu.html.twig', array('lieu' => $lieu));
    }

    public function infoLieuAction($id, $statut) {


        $em = $this->getDoctrine()->getManager();
        if ($statut == "hotel") {
            $lieu = $em->getRepository('BestTripWeeGoBundle:Hotel')->findById($id);
         $lieu2=new Hotel();
            $lieu2 = $em->getRepository('BestTripWeeGoBundle:Hotel')->findOneById($id);
            $x=$lieu2->getAdresse();
        } else {
            $lieu = $em->getRepository('BestTripWeeGoBundle:Restaurant')->findById($id);
        }

        $recommandations = $em->getRepository('BestTripWeeGoBundle:RecommandationLieu')->findByIdLieu($id);

        $requete = $this->container->get('request');
        $idU = $requete->get('idU');
        $note = $requete->get('note');
        $texte = $requete->get('texteR');

        $recommandationL = new RecommandationLieu();
        $date = DateTime::createFromFormat('Y-m-d', date('Y-m-d'));


        $lieu1 = $em->getRepository('BestTripWeeGoBundle:Lieu')->findOneById($id);
        $utilisateur = $em->getRepository('BestTripWeeGoBundle:Utilisateur')->findOneById($idU);
        $recommandationL->setIdLieu($lieu1);
        $recommandationL->setNote($note);
        $recommandationL->setTexte($texte);
        $recommandationL->setUtilisateur($utilisateur);
        $recommandationL->setDateRecommandation($date);


        if ($note != "" && $texte != "" && $idU != "") {
            $em->getRepository('BestTripWeeGoBundle:RecommandationLieu');
            $em->persist($recommandationL);
            $em->flush();
            if ($statut == "hotel") {
                return $this->render('BestTripWeeGoBundle:Lieu:afficherHotel.html.twig', array('lieu' => $lieu, 'recommandations' => $recommandations,'x'=> $x));
            } else {
                return $this->render('BestTripWeeGoBundle:Lieu:afficherRestaurant.html.twig', array('lieu' => $lieu, 'recommandations' => $recommandations));
            }
        }
        //var_dump($recommandations);

        if ($statut == "hotel") {
                return $this->render('BestTripWeeGoBundle:Lieu:afficherHotel.html.twig', array('lieu' => $lieu, 'recommandations' => $recommandations,'x'=> $x));
            } else {
                return $this->render('BestTripWeeGoBundle:Lieu:afficherRestaurant.html.twig', array('lieu' => $lieu, 'recommandations' => $recommandations));
            }
    }
     public function afficherLAAction(){
          $em=$this->getDoctrine()->getManager();
        $lieu=$em->getRepository('BestTripWeeGoBundle:Lieu')->findAll();
        return $this->render('BestTripWeeGoBundle:Lieu:afficherLA.html.twig',array('lieu'=>$lieu));
  
        
      
        
        
        
        
    }
     public function supprimerLieuAction($id){
       
       
 
      $em=$this->getDoctrine()->getManager();
         $lieu=$em->getRepository('BestTripWeeGoBundle:Lieu')->findOneById($id);
          
       $em->remove($lieu); 
       
             $em->flush();
            return  $this->redirect($this->generateUrl('best_trip_wee_go_afficherLA'));
        
        
       
        
    }   
       public function ajoutHotelAction(){
          
           $h = new Hotel();
        $f = new HotelForm();
        $form = $this->createForm($f, $h);
        $h->setStatut("hotel");
     $request=$this->get('request');
        $form->handleRequest($request);
   
                           
          
                 
if ($request->getMethod() == 'POST'){
            
            $em=$this->getDoctrine()->getManager();
            $em->getRepository('BestTripWeeGoBundle:Hotel');
            $h->upload();
            $em->persist($h);
            $em->flush();
            
            return  $this->redirect($this->generateUrl('best_trip_wee_go_afficher'));
        }
 
        return $this->render('BestTripWeeGoBundle:Lieu:ajoutHotel.html.twig', array('form' => $form->createView()));
       
        
      
        
           }
    public function ajoutRestaurantAction(){
          
           $r = new Restaurant();
        $f = new RestaurantForm();
        $form = $this->createForm($f, $r);
        $r->setStatut("restaurant");
     $request=$this->get('request');
        $form->handleRequest($request);
   
                           
          
                 
if ($request->getMethod() == 'POST'){
            
            $em=$this->getDoctrine()->getManager();
            $em->getRepository('BestTripWeeGoBundle:Restaurant');
           
             $r->upload();
            $em->persist($r);
            $em->flush();
            
            return  $this->redirect($this->generateUrl('best_trip_wee_go_afficher'));
        }
 
        return $this->render('BestTripWeeGoBundle:Lieu:ajoutRestaurant.html.twig', array('form' => $form->createView()));
       
        
      
        
           }
        
        public function modifierAction($id,$statut)
    {
          if ($statut=="restaurant") {
              
         
          $em=$this->getDoctrine()->getManager();
        $restaurant = $em->getRepository('BestTripWeeGoBundle:Restaurant')->find($id);
        $f= new RestaurantForm();
        $form=$this->createForm($f,$restaurant);
           $request=$this->get('request');
                $form->handleRequest($request);
       if ($request->getMethod() == 'POST'){
            
            $em=$this->getDoctrine()->getManager();
            $em->getRepository('BestTripWeeGoBundle:Restaurant');
            $em->persist($restaurant);
            $em->flush();
            
            return  $this->redirect($this->generateUrl('best_trip_wee_go_afficherLA'));
        } return $this->render('BestTripWeeGoBundle:Lieu:modifierRestaurant.html.twig',array('form'=>$form->createView(),'restaurant'=>$restaurant)); 
         
          }
       $em=$this->getDoctrine()->getManager();
        $hotel = $em->getRepository('BestTripWeeGoBundle:Hotel')->find($id);
        $f= new HotelForm();
        $form=$this->createForm($f, $hotel);
           $request=$this->get('request');
                $form->handleRequest($request);
       if ($request->getMethod() == 'POST'){
            
            $em=$this->getDoctrine()->getManager();
            $em->getRepository('BestTripWeeGoBundle:Hotel');
            $em->persist($hotel);
            $em->flush();
            
            return  $this->redirect($this->generateUrl('best_trip_wee_go_afficherLA'));
        } return $this->render('BestTripWeeGoBundle:Lieu:modifierHotel.html.twig',array('form'=>$form->createView(),'hotel'=>$hotel)); 
         
       
    }
}
