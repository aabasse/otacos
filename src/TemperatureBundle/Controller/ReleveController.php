<?php

namespace TemperatureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TemperatureBundle\Entity\Releve;
use TemperatureBundle\Entity\Degre;
use TemperatureBundle\Form\ReleveType;
use Symfony\Component\HttpFoundation\Request;

class ReleveController extends Controller
{
    public function newAction(Request $request, $slugCategorie, $moment)
    {
    	$em = $this->getDoctrine()->getManager();
    	$categ  = $em->getRepository("TracabiliteBundle:Categorie")->findOneBySlug($slugCategorie);
    	if (!$categ) {
            throw $this->createNotFoundException('Categorie non trouvé.');
        }

        if( !in_array($moment, Releve::getLesMoment()) ){
            throw $this->createNotFoundException('Moment inconu.');
        }

        $releve = $em->getRepository('TemperatureBundle:Releve')->getOneByDateAndMoment($moment, $categ);
        //$releve = false;
        if(!$releve){
            $releve = new Releve();
            $releve->setCategorie($categ);
            $releve->setMoment($moment);
            $releve->addDegre(new Degre());
        }

        $form = $this->createForm(ReleveType::class, $releve);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $releve->setEntreprise($user->getEntreprise());
            $em->persist($releve);
            $em->flush();

            return $this->redirectToRoute('temperature_releve_choix_moment', array('slugCategorie'=>$slugCategorie));
        }

        return $this->render('TemperatureBundle:Releve:new.html.twig', array(
            'form'=>$form->createView()
        ));
    }

}
