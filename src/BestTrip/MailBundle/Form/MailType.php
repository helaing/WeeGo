<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MailType
 *
 * @author Aminovski
 */

namespace BestTrip\MailBundle\Form;

use \Symfony\Component\Form\AbstractType;
use \Symfony\Component\Form\FormBuilderInterface;

class MailType extends AbstractType {

    public function getName() {
        return "formulaireMail";
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('nom', 'text')
                ->add('prenom', 'text')
                ->add('tel', 'integer')
                ->add('from', 'email')
                ->add('text', 'textarea')

        ;
    }

}
