<?php

namespace ReceptionBundle\Controller;

use ReceptionBundle\Entity\Reception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TracabiliteBundle\Entity\Photo;

/**
 * Reception controller.
 *
 */
class ReceptionController extends Controller
{
    /**
     * Lists all reception entities.
     *
     */
    public function indexAction()
    {
        $this->get('otacos_app.service')->verifierAbonnement();
        $em = $this->getDoctrine()->getManager();

        $em = $this->getDoctrine();
        $categories  = $em->getRepository("TracabiliteBundle:Categorie")->getCategoriePere(300);

        $categValid = $em->getRepository("ReceptionBundle:Reception")->getCategValidDuJour($this->getUser()->getEntreprise());

        //dump($categValid);die();

        return $this->render('ReceptionBundle:reception:index.html.twig', array(
            'categories'=>$categories,
            'categValid'=>$categValid,
        ));
    }


    /**
     * Creates a new reception entity.
     *
     */
    public function newAction(Request $request, $slugCategorie)
    {
        $this->get('otacos_app.service')->verifierAbonnement();
        $em = $this->getDoctrine()->getManager();
        $categ  = $em->getRepository("TracabiliteBundle:Categorie")->findOneBySlug($slugCategorie);
        if (!$categ) {
            throw $this->createNotFoundException('Categorie non trouvé.');
        }

        //$reception = $em->getRepository("ReceptionBundle:Reception")->getDuJourByCateg($categ);

        //if($reception == null){
            $reception = new Reception();
            $reception->setCategorie($categ);
            $photo1 = new Photo();
            $reception->addPhoto($photo1);   
        //}

        $form = $this->createForm('ReceptionBundle\Form\ReceptionType', $reception);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $gestionImage = $this->get('otacos_gestion.image');
            foreach ($reception->getPhotos() as $photo) {
                //dump($photo->getUrl());die();
                $originalName = $photo->getFile()->getClientOriginalName();
                $url = $gestionImage->telecharger($photo->getFile(),  array('prefix'=>$gestionImage::slugify( $originalName ),
                        'type'=>'reception'));

                if($photo->getUrl() != null)
                {
                    $gestionImage->supprimer($photo->getUrl(), 'reception');
                }
                $photo->setUrl($url);

            }
            $user = $this->getUser();
            $reception->setEntreprise($user->getEntreprise());
            $em->persist($reception);
            $em->flush();

            return $this->redirectToRoute('reception_index');
        }

        return $this->render('ReceptionBundle:reception:new.html.twig', array(
            'reception' => $reception,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reception entity.
     *
     */
    public function showAction(Reception $reception)
    {
        $this->get('otacos_app.service')->verifierAbonnement();
        $deleteForm = $this->createDeleteForm($reception);

        return $this->render('ReceptionBundle:reception:show.html.twig', array(
            'reception' => $reception,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reception entity.
     *
     */
    public function editAction(Request $request, Reception $reception)
    {
        $this->get('otacos_app.service')->verifierAbonnement();
        $editForm = $this->createForm('ReceptionBundle\Form\ReceptionEditType', $reception);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reception_edit', array('id' => $reception->getId()));
        }

        return $this->render('ReceptionBundle:reception:edit.html.twig', array(
            'reception' => $reception,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a reception entity.
     *
     */
    public function deleteAction(Request $request, Reception $reception)
    {
        $this->get('otacos_app.service')->verifierAbonnement();
        $form = $this->createDeleteForm($reception);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $lesPhotoAsupprimer = array();
            foreach ($reception->getPhotos() as $photo) {
                $lesPhotoAsupprimer[] = $photo->getUrl();
            }

            $em->remove($reception);
            $em->flush($reception);

            $gestionImage = $this->get('otacos_gestion.image');
            foreach ($lesPhotoAsupprimer as $p) {
                $gestionImage->supprimer($p, 'reception');
            }
        }

        return $this->redirectToRoute('historique_reception');
    }

    public function deleteButtonAction(Reception $reception){
        $form = $this->createDeleteForm($reception);
        return $this->render('ReceptionBundle:reception:deleteButton.html.twig', array(
            'form' => $form->createView(),
            'id'=>$reception->getId(),
        ));
    }

    /**
     * Creates a form to delete a reception entity.
     *
     * @param Reception $reception The reception entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reception $reception)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reception_delete', array('id' => $reception->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
