<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HistoriqueController extends Controller
{
    public function indexAction()
    {
        $types = $this->getTypes();
        return $this->render('AppBundle:Historique:index.html.twig', array(
            'types' => $types,
        ));
    }

    public function tracabiliteAction()
    {
        $user = $this->getUser();
        $entreprise = $user->getEntreprise();
        $em = $this->getDoctrine()->getManager();
        $traces = $em->getRepository('TracabiliteBundle:Trace')->getAllArray($entreprise);
        //$traces = $em->getRepository('TracabiliteBundle:Trace')->findAll();
        $tracesByDate = array();
        //dump($traces);die();
        foreach ($traces as $key => $t) {
            $laDate = date_format($t['date'], 'F - Y');
            $tracesByDate[ $laDate ][] = $t;
        }
        //dump($tracesByDate);die();


        return $this->render('AppBundle:Historique:tracabilite.html.twig', array(
            'tracesByDate' => $tracesByDate,
        ));
    }

    public function temperatureAction()
    {
        $user = $this->getUser();
        $entreprise = $user->getEntreprise();
        $em = $this->getDoctrine()->getManager();
        $temperatures = $em->getRepository('TemperatureBundle:Releve')->getAllArray($entreprise);
        $temperaturesByDate = array();
        foreach ($temperatures as $key => $r) {
            $laDate = date_format($r['date'], 'F - Y');
            $temperaturesByDate[ $laDate ][] = $r;
        }

        //dump($temperaturesByDate);die();
        return $this->render('AppBundle:Historique:temperature.html.twig', array(
            'temperaturesByDate' => $temperaturesByDate,
        ));
    }

    public function receptionAction()
    {
        $user = $this->getUser();
        $entreprise = $user->getEntreprise();
        $em = $this->getDoctrine()->getManager();
        $receptions = $em->getRepository('ReceptionBundle:Reception')->getAllArray($entreprise);
        $receptionsByDate = array();
        foreach ($receptions as $key => $r) {
            $laDate = date_format($r['date'], 'F - Y');
            $receptionsByDate[ $laDate ][] = $r;
        }

        //dump($receptionsByDate);die();

        return $this->render('AppBundle:Historique:reception.html.twig', array(
            'receptionsByDate' => $receptionsByDate,
        ));
    }

    private function getTypes(){
        $types[] = array('libelle' => 'traçabilité', 'slug' => 'tracabilite');
        $types[] = array('libelle' => 'temperature', 'slug' => 'temperature');
        $types[] = array('libelle' => 'reception', 'slug' => 'reception');

        return $types;
        
    }

}
