<?php

namespace UtilisateurBundle\Controller;

use UtilisateurBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Utilisateur controller.
 *
 */
class UtilisateurController extends Controller
{
    /**
     * Lists all utilisateur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateurs = $em->getRepository('UtilisateurBundle:Utilisateur')->findAll();

        return $this->render('UtilisateurBundle:Utilisateur:index.html.twig', array(
            'utilisateurs' => $utilisateurs,
        ));
    }

    public function salariesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entreprise = $this->getUser()->getEntreprise();
        $utilisateurs = $em->getRepository('UtilisateurBundle:Utilisateur')->findByEntreprise($entreprise);

        return $this->render('UtilisateurBundle:Utilisateur:salaries.html.twig', array(
            'utilisateurs' => $utilisateurs,
        ));
    }


    /**
     * Creates a new utilisateur entity.
     *
     */
    public function newAction(Request $request)
    {
        $utilisateur = new Utilisateur();

        if ($this->isGranted('ROLE_CHEF_ENTREPRISE')) {
            $entreprise = $this->getUser()->getEntreprise();
            $utilisateur->setEntreprise($entreprise);
        }
        $form = $this->createForm('UtilisateurBundle\Form\UtilisateurType', $utilisateur);

       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $utilisateur->setEnabled(true); // on active l'utilisateur
            $em->persist($utilisateur);
            $em->flush($utilisateur);

            return $this->redirectToRoute('utilisateur_show', array('id' => $utilisateur->getId()));
        }

        return $this->render('UtilisateurBundle:Utilisateur:new.html.twig', array(
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ));
    }

    private function verifierDroit($utilisateur){
        if ($this->isGranted('ROLE_CHEF_ENTREPRISE')) {
            if($utilisateur->getEntreprise() != $this->getUser()->getEntreprise() ){
                throw new HttpException(403);
            }
        }
    }

    /**
     * Finds and displays a utilisateur entity.
     *
     */
    public function showAction(Utilisateur $utilisateur)
    {
        $this->verifierDroit($utilisateur);
        $deleteForm = $this->createDeleteForm($utilisateur);
        return $this->render('UtilisateurBundle:Utilisateur:show.html.twig', array(
            'utilisateur' => $utilisateur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing utilisateur entity.
     *
     */
    public function editAction(Request $request, Utilisateur $utilisateur)
    {
        $this->verifierDroit($utilisateur);
        
        $roles = $this->get('otacos_app.service')->getRoles($this);
        $editForm = $this->createForm('UtilisateurBundle\Form\UtilisateurEditType', $utilisateur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //dump($utilisateur);die();
            if ($this->isGranted('ROLE_ADMIN')) {
                $utilisateur->setRoles($utilisateur->getLesRoles());
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateur_edit', array('id' => $utilisateur->getId()));
        }

        //dump($utilisateur);die();

        return $this->render('UtilisateurBundle:Utilisateur:edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a utilisateur entity.
     *
     */
    public function deleteAction(Request $request, Utilisateur $utilisateur)
    {
        $form = $this->createDeleteForm($utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //$em->remove($utilisateur);
            //$em->flush($utilisateur);
        }

        return $this->redirectToRoute('utilisateur_index');
    }

    /**
     * Creates a form to delete a utilisateur entity.
     *
     * @param Utilisateur $utilisateur The utilisateur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Utilisateur $utilisateur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('utilisateur_delete', array('id' => $utilisateur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
