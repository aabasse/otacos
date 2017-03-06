<?php
namespace AppBundle\Services;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}

?>