<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{
    public function accueilAction()
    {
        return $this->render('AppBundle:Accueil:accueil.html.twig', array(
        ));
    }

    public function accueilAdminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $nbrEntreprise = $em->getRepository('EntrepriseBundle:Entreprise')->getNbr();
        $nbrUtilisateur = $em->getRepository('UtilisateurBundle:Utilisateur')->getNbr();

        return $this->render('AppBundle:Accueil:accueil-admin.html.twig', array(
            'nbrEntreprise'=>$nbrEntreprise,
            'nbrUtilisateur'=>$nbrUtilisateur,
        ));
    }

    public function accueilUserAction()
    {
        $types = $this->getTypes();
        return $this->render('AppBundle:Accueil:accueil-user.html.twig', array(
            'types' => $types,
        ));
    }

    /*public function getRoles($controller){
        //$roles = $controller->getParameter('security.role_hierarchy.roles');
        $roles = $this->container->getParameter('security.role_hierarchy.roles');
        return $roles;
    }*/

    private function getTypes(){
        $types[] = array('libelle' => 'traçabilité', 'root' => 'tracabilite_index', 'icon'=>'fa-barcode');
        $types[] = array('libelle' => 'temperature', 'root' => 'temperature_index', 'icon'=>'fa-thermometer-empty' );
        $types[] = array('libelle' => 'reception', 'root' => 'reception_index', 'icon'=>'fa-truck');
        $types[] = array('libelle' => 'historique', 'root' => 'historique_index', 'icon'=>'fa-hdd-o');

        return $types;
    }

}
