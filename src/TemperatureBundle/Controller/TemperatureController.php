<?php

namespace TemperatureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TemperatureController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine();
    	$categories  = $em->getRepository("TracabiliteBundle:Categorie")->getCategoriePere(200);
        return $this->render('TemperatureBundle:Temperature:index.html.twig', array(
        		'categories'=>$categories
        	));
    }

    public function choixEquipementAction($slug)
    {
    	$em = $this->getDoctrine();
    	$categ  = $em->getRepository("TracabiliteBundle:Categorie")->findOneBySlug($slug);
    	if (!$categ) {
            throw $this->createNotFoundException('Categorie non trouvé.');
        }

        $traces  = $em->getRepository("TracabiliteBundle:Trace")->getDuJour();

        //dump($trace);die();

        $elements  = $em->getRepository("TracabiliteBundle:Element")->getElementByCategorie($categ);

        return $this->render('TracabiliteBundle:tracabilite:choixElement.html.twig', array(
        	'elements'=>$elements,
            'traces'=>$traces,
        ));
    }
}
