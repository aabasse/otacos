<?php

namespace TemperatureBundle\Controller;

use TemperatureBundle\Entity\Equipement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Equipement controller.
 *
 */
class EquipementController extends Controller
{
    /**
     * Lists all equipement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $equipements = $em->getRepository('TemperatureBundle:Equipement')->findAll();

        return $this->render('TemperatureBundle:Equipement:index.html.twig', array(
            'equipements' => $equipements,
        ));
    }

    /**
     * Creates a new equipement entity.
     *
     */
    public function newAction(Request $request)
    {
        $equipement = new Equipement();
        $form = $this->createForm('TemperatureBundle\Form\EquipementType', $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipement);
            $em->flush($equipement);

            return $this->redirectToRoute('equipement_index');
        }

        return $this->render('TemperatureBundle:Equipement:new.html.twig', array(
            'equipement' => $equipement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipement entity.
     *
     */
    public function editAction(Request $request, Equipement $equipement)
    {
        $deleteForm = $this->createDeleteForm($equipement);
        $editForm = $this->createForm('TemperatureBundle\Form\EquipementType', $equipement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipement_edit', array('id' => $equipement->getId()));
        }

        return $this->render('TemperatureBundle:Equipement:edit.html.twig', array(
            'equipement' => $equipement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a equipement entity.
     *
     */
    public function deleteAction(Request $request, Equipement $equipement)
    {
        $form = $this->createDeleteForm($equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($equipement);
            $em->flush($equipement);
        }

        return $this->redirectToRoute('equipement_index');
    }

    /**
     * Creates a form to delete a equipement entity.
     *
     * @param Equipement $equipement The equipement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Equipement $equipement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('equipement_delete', array('id' => $equipement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function deleteButtonAction(Equipement $equipement){
        $form = $this->createDeleteForm($equipement);
        return $this->render('TemperatureBundle:Equipement:deleteButton.html.twig', array(
            'form' => $form->createView(),
            'id'=>$equipement->getId(),
        ));
    }
}
