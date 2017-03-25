<?php
namespace AppBundle\Services;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

// nom = otacos_app.service

class AppService
{
    private $controller;
    public function __construct($controller){
        $this->controller = $controller;
    }

    public function getRoles(){
        $aRetourner = array();
        $roles = $this->controller->getParameter('security.role_hierarchy.roles');
        foreach ($roles as $key => $role) {
            if( !in_array($key, $aRetourner)){
                $aRetourner[$key] = $key;
            }
            foreach ($role as $r) {
                if( !in_array($r, $aRetourner)){
                    $aRetourner[$r] = $r;
                }
            }
            
        }
        return $aRetourner;
    }

    public function verifierAbonnement(){
        if( $this->controller->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') ){
           $user = $this->controller->get('security.token_storage')->getToken()->getUser();
           $entreprise = $user->getEntreprise();
           if( !$entreprise || !$entreprise->getEstAbonne()){
                throw new HttpException(403, 'non abbbb');
                //non abonne
           }
        }
        else{
             throw new HttpException(403, 'non abbbb');
        }
    }
}

?>