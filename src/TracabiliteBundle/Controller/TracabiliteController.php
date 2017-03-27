<?php

namespace TracabiliteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TracabiliteController extends Controller
{
    public function indexAction()
    {
        $this->get('otacos_app.service')->verifierAbonnement();

    	$em = $this->getDoctrine();
        $categories  = $em->getRepository("TracabiliteBundle:Categorie")->getCategoriePere(100);

        $nbr = $em->getRepository("TracabiliteBundle:Trace")->getNbrTraceDuJour();
        
        //dump($nbr);die();

        return $this->render('TracabiliteBundle:tracabilite:index.html.twig', array(
        	'categories'=>$categories,
            'nbr'=>$nbr,
        ));
    }

    public function choixElementAction($slug)
    {
        $this->get('otacos_app.service')->verifierAbonnement();
    	$em = $this->getDoctrine();
    	$categ  = $em->getRepository("TracabiliteBundle:Categorie")->findOneBySlug($slug);
    	if (!$categ) {
            throw $this->createNotFoundException('Categorie non trouvé.');
        }

        $traces  = $em->getRepository("TracabiliteBundle:Trace")->getDuJour();

        $elements  = $em->getRepository("TracabiliteBundle:Element")->getElementByCategorie($categ);

        return $this->render('TracabiliteBundle:tracabilite:choixElement.html.twig', array(
        	'elements'=>$elements,
            'traces'=>$traces,
            'categorie'=>$categ,
        ));
    }


    public function newAction($slugCategorie, $slugElement)
    {
        $this->get('otacos_app.service')->verifierAbonnement();
    	$em = $this->getDoctrine();
    	$element  = $em->getRepository("TracabiliteBundle:Element")->findOneBySlug($slugElement);
    	if (!$element) {
            throw $this->createNotFoundException('Element non trouvé.');
        }

        //dump($element);die();

        return $this->render('TracabiliteBundle:tracabilite:choixElement.html.twig', array(
        	'element'=>$element,
        ));
    }
}
