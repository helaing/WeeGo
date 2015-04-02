<?php

namespace BestTrip\WeeGoBundle\Controller;
use BestTrip\WeeGoBundle\Entity\Experience;
use \Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ExperienceController extends Controller{
    
    public function ajouterAction(){          
        $e=new Experience();
        $e->setImage('');
        $e->setVideo('');
        $e->setDatePublication(new \Datetime());
        $ef=new \BestTrip\WeeGoBundle\Form\ExperienceForm();
        $form = $this->createForm($ef,$e);
        $request=$this->get('request');
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST'){
            $em=$this->getDoctrine()->getManager();
            $em->getRepository('BestTripWeeGoBundle:Experience');
            $em->persist($e);
            $em->flush();
            return $this->redirect($this->generateUrl('showExperience'));
        }
        return $this->render('BestTripWeeGoBundle:Experience:ajouter.html.twig', array('form' => $form->createView()));
     }     
     public function afficherAction()
     {
        $em=$this->getDoctrine()->getManager();
        $experience=$em->getRepository('BestTripWeeGoBundle:Experience')->findAll();
        return $this->render('BestTripWeeGoBundle:Experience:afficher.html.twig',array('experience'=>$experience));
     }
     
     public function showAction()
     {
        $em = $this->getDoctrine()->getManager();
        $experience = $em->getRepository('BestTripWeeGoBundle:Experience')->findAll();
        return $this->render('BestTripWeeGoBundle:Experience:show.html.twig', array('experience' => $experience));
     }
     public function supprimerAction($id) {
        $em = $this->getDoctrine()->getManager();
        $ex = $em->getRepository('BestTripWeeGoBundle:Experience')->findOneById($id);
        $em->remove($ex);
        $em->flush();
        return $this->redirect($this->generateUrl('afficherExperience'));
    }
    public function afAction($id){
        $em = $this->getDoctrine()->getManager();
        $experience = $em->getRepository('BestTripWeeGoBundle:Experience')->findById($id);
        return $this->render('BestTripWeeGoBundle:Experience:af.html.twig',array('experience'=>$experience));
    }

}



