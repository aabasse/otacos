<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{
    public function accueilAction()
    {
        return $this->render('AppBundle:Accueil:accueil.html.twig', array(
            // ...
        ));
    }

}
