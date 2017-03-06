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

    /*public function getRoles($controller){
        //$roles = $controller->getParameter('security.role_hierarchy.roles');
        $roles = $this->container->getParameter('security.role_hierarchy.roles');
        return $roles;
    }*/

}
