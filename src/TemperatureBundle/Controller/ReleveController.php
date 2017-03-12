<?php

namespace TemperatureBundle\Controller;

use TemperatureBundle\Entity\Releve;
use TemperatureBundle\Entity\Degre;
use TemperatureBundle\Form\ReleveType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Releve controller.
 *
 */
class ReleveController extends Controller
{
    /**
     * Creates a new releve entity.
     *
     */
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

        /*$releve = $em->getRepository('TemperatureBundle:Releve')->getOneByDateAndMoment($moment, $categ);
        //$releve = false;
        if(!$releve){*/
            $releve = new Releve();
            $releve->setCategorie($categ);
            $releve->setMoment($moment);
            $releve->addDegre(new Degre());
        /*}*/

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

    /**
     * Finds and displays a releve entity.
     *
     */
    public function showAction(Releve $releve)
    {
        $deleteForm = $this->createDeleteForm($releve);

        return $this->render('TemperatureBundle:Releve:show.html.twig', array(
            'releve' => $releve,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing releve entity.
     *
     */
    public function editAction(Request $request, Releve $releve)
    {
        $deleteForm = $this->createDeleteForm($releve);
        $editForm = $this->createForm('TemperatureBundle\Form\ReleveType', $releve);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('releve_edit', array('id' => $releve->getId()));
        }

        return $this->render('TemperatureBundle:Releve:edit.html.twig', array(
            'releve' => $releve,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a releve entity.
     *
     */
    public function deleteAction(Request $request, Releve $releve)
    {
        $form = $this->createDeleteForm($releve);
        $form->handleRequest($request);

        /*if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($releve);
            $em->flush($releve);
        }*/

        return $this->redirectToRoute('historique_temperature');
    }

    public function deleteButtonAction(Releve $releve){
        $form = $this->createDeleteForm($releve);
        return $this->render('TemperatureBundle:Releve:deleteButton.html.twig', array(
            'form' => $form->createView(),
            'id'=>$releve->getId(),
        ));
    }

    /**
     * Creates a form to delete a releve entity.
     *
     * @param Releve $releve The releve entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Releve $releve)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('releve_delete', array('id' => $releve->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
