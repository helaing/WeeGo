<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GrapheController
 *
 * @author Aminovski
 */

namespace BestTrip\GrapheBundle\Controller;

use \Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Ob\HighchartsBundle\Highcharts\Highchart;
use \Zend\Json\Expr;
use \BestTrip\GrapheBundle\Form\RechercheParAnneeType;

class GrapheController extends Controller {

    public function chartLineAction() {

        $series = array(array("name" => "Nombre d'expériences publiées", "data" => array(1, 2, 3, 4, 5, 7)));

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');
        $ob->title->text('Titre du graphique');
        $ob->xAxis->title(array('text' => "Titre axe horizontal"));

        $ob->yAxis->title(array('text' => "Titre axe vertical "));

        $ob->series($series);

        return $this->render('BestTripGrapheBundle:Graphe:LineChart.html.twig', array(
                    'chart' => $ob
        ));
    }

    public function chartHistogrammeAction() {
        
        //$form = $this->createForm(new RechercheParAnneeType(), array('attr' => array('target'=>'_blank')));
        //$request = $this->getRequest();
        $requete = $this->container->get('request');
        $annee = $requete->get('annee');
        //var_dump($requete);
        if ($requete->getMethod() == 'POST') {
            
            //$form->bind($request);
            
            if ($annee != "") {
                
                $em = $this->getDoctrine()->getManager();
                //$data = $this->getRequest()->request->get('formulaireRechercheParAnnee');
                $query = $em->createQuery("SELECT count(exp.id) as nbr, SUBSTRING(exp.datePublication,6,2) AS month FROM BestTripWeeGoBundle:Experience exp WHERE (SUBSTRING(exp.datePublication,1,4)= :an) group by month")
                        ->setParameter('an', $annee);

                $experiences = $query->getResult();

                $nbrExp = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

                $mois = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

                foreach ($experiences as $e):

                    for ($i = 0; $i < 12; $i++) {
                        if ($mois[$i] == $e['month']) {
                            $nbrExp[$i] = intval($e['nbr']);
                        }
                    }

                endforeach;
                $series = array(
                    array(
                        'name' => 'Experiences',
                        'type' => 'column',
                        'color' => '#75c5c3',
                        'yAxis' => 1,
                        'data' => $nbrExp,
                    ),
                    array(
                        'name' => 'Temperature',
                        'type' => 'spline',
                        'color' => '#e0304a',
                        'data' => array(7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6),
                    ),
                );
                $yData = array(
                    array(
                        'labels' => array(
                            'formatter' => new Expr('function () { return this.value + " degrees C" }'),
                            'style' => array('color' => '#e0304a')
                        ),
                        'title' => array(
                            'text' => 'Temperature',
                            'style' => array('color' => '#e0304a')
                        ),
                        'opposite' => true,
                    ),
                    array(
                        'labels' => array(
                            'formatter' => new Expr('function () { return this.value}'),
                            'style' => array('color' => '#75c5c3')
                        ),
                        'gridLineWidth' => 0,
                        'title' => array(
                            'text' => 'Expériences',
                            'style' => array('color' => '#4572A7')
                        ),
                    ),
                );
                $categories = array('Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sep', 'Oct', 'Nov', 'Déc');

                $ob = new Highchart();

                $ob->chart->renderTo('container'); // The #id of the div where to render the chart

                $ob->chart->type('column');

                $ob->title->text("Évolution des expériences et des nouveaux inscrits pour l'année ".$annee);

                $ob->xAxis->categories($categories);

                $ob->yAxis($yData);

                $ob->legend->enabled(false);

                $formatter = new Expr('function () {

            var unit = {

            "Expériences": "",

            "Temperature": "degrees C"

            }[this.series.name];

            return this.x + ": <b>" + this.y + "</b> " + unit;

            }');

                $ob->tooltip->formatter($formatter);

                $ob->series($series);

                return $this->render('BestTripGrapheBundle:Graphe:histogramme.html.twig', array(
                            'chart' => $ob
                ));
            }
        }
        return $this->render('BestTripGrapheBundle:Experiences:ListeExperiences.html.twig');
    }

    public function rechercheAction() {
        $form = $this->createForm(new RechercheParAnneeType());
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $data = $this->getRequest()->request->get('formulaireRechercheParAnnee');
                $query = $em->createQuery("SELECT count(exp.id) as nbr, SUBSTRING(exp.datePublication,6,2) AS month FROM BestTripWeeGoBundle:Experience exp WHERE (SUBSTRING(exp.datePublication,1,4)= :an) group by month")
                        ->setParameter('an', $data['annee']);

                $experiences = $query->getResult();

                $nbrExp = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

                $mois = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');


                foreach ($experiences as $e):

                    for ($i = 0; $i < 12; $i++) {
                        if ($mois[$i] == $e['month']) {
                            $nbrExp[$i] = intval($e['nbr']);
                        }
                    }

                endforeach;






                return $this->render('BestTripGrapheBundle:Experiences:ListeExperiences.html.twig', array('form' => $form->createView()));
            }
        }

        return $this->render('BestTripGrapheBundle:Experiences:ListeExperiences.html.twig', array('form' => $form->createView()));
    }

}
