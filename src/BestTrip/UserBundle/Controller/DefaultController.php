<?php

namespace BestTrip\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BestTripUserBundle:Default:index.html.twig', array('name' => $name));
    }
    public function ContactAction()
    {
        return $this->render('BestTripUserBundle::contact.html.twig');
    }
    
   public function usersAction() {
        //access user manager services 

         $userManager = $this->get('fos_user.user_manager');
          $users = $userManager->findUsers();

        return $this->render('BestTripUserBundle::users.html.twig', array('users' =>   $users));
    }
    public function  supprimerAction($username){
         $userManager = $this->get('fos_user.user_manager');
         $em=$this->getDoctrine()->getManager();
          $users = $userManager->findUserByUsername($username);
         
         $userManager->deleteUser($users);
             $em->flush();
                   
        return $this->redirect($this->generateUrl('users'));
         
    }
}
