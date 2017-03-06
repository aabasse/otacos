<?php

namespace TemperatureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TemperatureBundle\Entity\Releve;

class TemperatureController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine();
    	$categories  = $em->getRepository("TracabiliteBundle:Categorie")->getCategoriePere(200);
    
        $nbr = $em->getRepository("TemperatureBundle:Releve")->getNbrTraceDuJour($this->getUser()->getEntreprise());

        return $this->render('TemperatureBundle:Temperature:index.html.twig', array(
        		'categories'=>$categories,
                'nbr'=>$nbr,
        	));
    }

    public function choixMomentAction($slugCategorie)
    {
        $em = $this->getDoctrine()->getManager();
        $categ  = $em->getRepository("TracabiliteBundle:Categorie")->findOneBySlug($slugCategorie);
        if (!$categ) {
            throw $this->createNotFoundException('Categorie non trouvé.');
        }

        $momentValideDuJour  = $em->getRepository("TemperatureBundle:Releve")->getMomentValidDuJour($categ, $this->getUser()->getEntreprise());
        //dump($momentValideDuJour);die();

        return $this->render('TemperatureBundle:Temperature:choixMoment.html.twig', array(
            'slugCategorie' => $slugCategorie,
            'moments'=> Releve::getLesMoment(),
            'momentValideDuJour' => $momentValideDuJour,
        ));
    }
}
