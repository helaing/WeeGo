<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MailController
 *
 * @author Aminovski
 */

namespace BestTrip\MailBundle\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \BestTrip\MailBundle\Form\MailType;
use \BestTrip\MailBundle\Entity\Mail;

class MailController extends Controller {

    public function indexAction() {

        return $this->render('BestTripMailBundle:Default:mail.html.twig', array());
    }

    public function sendMailAction(\Symfony\Component\HttpFoundation\Request $request) {

        
        $to = "weego003@gmail.com";

        $mail = new Mail();

        $form = $this->container->get('form.factory')->create(new MailType(), $mail);
       

        if ($request->getMethod() == 'POST') {

            if ($form->isValid()) {

                $message = Swift_Message::newInstance()
                        ->setSubject($mail->getNom())
                        ->setFrom($mail->getFrom())
                        ->setTo($to)
                        ->setBody($mail->getText());

                $this->get('mailer')->send($message);

                return $this->render('BestTripMailBundle:Default:mail.html.twig', array('to' => $to,
                            'from' => $mail->getFrom()
                ));
            }
        }

        return $this->redirect($this->generateUrl('my_app_mail_form'));
    }

    public function newAction() {

        /*$mail = new Mail();

        $form = $this->container->get('form.factory')->create(new MailType(), $mail);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {

                $this->sendMailAction('weego003@gmail.com', $mail->getFrom(), $mail->getNom(), $mail->getText());
            }
        }

        return $this->render('BestTripMailBundle:Default:new.html.twig', array('form' =>$form->createView()));*/
        
        $mail = new Mail();
        $f = new MailType();
        $form=$this->createForm($f,$mail);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            /*$form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();
                return $this->redirect($this->generateUrl('listevenement'));
            }*/
            
            $mailer = $this->container->get('mailer');
            $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com',465);
        }

        return $this->render('ExamenTunivisionCultureBundle:Evenement:ajoutEvenement.html.twig', array('form' => $form->createView()));
        
    }

}
