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
        setlocale (LC_TIME, 'fr_FR.UTF8','fra');
        foreach ($traces as $key => $t) {
            
            $laDate = utf8_encode( strftime("%B %Y", $t['date']->getTimestamp()) );
            $laDate2 = utf8_encode( strftime("%A %d %B %Y", $t['date']->getTimestamp()) );

            $tracesByDate[ $laDate ][$laDate2][] = $t;
        }
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
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        foreach ($temperatures as $key => $t) {
            $laDate = utf8_encode( strftime("%B %Y", $t['date']->getTimestamp()) );
            $laDate2 = utf8_encode( strftime("%A %d %B %Y", $t['date']->getTimestamp()) );
            $temperaturesByDate[ $laDate ][$laDate2][] = $t;
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
        setlocale (LC_TIME, 'fr_FR.utf8','fra');
        foreach ($receptions as $key => $r) {
            $laDate = utf8_encode( strftime("%B %Y", $r['date']->getTimestamp()) );
            $laDate2 = utf8_encode( strftime("%A %d %B %Y", $r['date']->getTimestamp()) );
            $receptionsByDate[ $laDate ][$laDate2][] = $r;
        }

        //dump($receptionsByDate);die();

        return $this->render('AppBundle:Historique:reception.html.twig', array(
            'receptionsByDate' => $receptionsByDate,
        ));
    }

    private function getTypes(){
        $types[] = array('libelle' => 'traçabilité', 'slug' => 'tracabilite', 'icon'=>'fa-barcode');
        $types[] = array('libelle' => 'temperature', 'slug' => 'temperature', 'icon'=>'fa-thermometer-empty' );
        $types[] = array('libelle' => 'reception', 'slug' => 'reception', 'icon'=>'fa-truck');

        return $types;
        
    }

}
