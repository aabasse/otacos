<?php

namespace TracabiliteBundle\Controller;

use TracabiliteBundle\Entity\Trace;
use TracabiliteBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TracabiliteBundle\Form\TraceType;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Trace controller.
 *
 */
class TraceController extends Controller
{
    /**
     * Lists all trace entities.
     *
     */
    public function indexAction()
    {
        $this->get('otacos_app.service')->verifierAbonnement();
        $em = $this->getDoctrine()->getManager();
        $traces = $em->getRepository('TracabiliteBundle:Trace')->findAll();

        return $this->render('TracabiliteBundle:trace:index.html.twig', array(
            'traces' => $traces,
        ));
    }

    /**
     * Creates a new trace entity.
     *
     */
    public function newAction(Request $request, $slugCategorie, $slugElement)
    {
        $this->get('otacos_app.service')->verifierAbonnement();
        $em = $this->getDoctrine()->getManager();
        $element  = $em->getRepository("TracabiliteBundle:Element")->findOneBySlug($slugElement);
        if (!$element) {
            throw $this->createNotFoundException('Produit inconnu');
        }


        $user = $this->getUser();
        $entreprise = $user->getEntreprise();

        $trace = new Trace();
        $trace->setEntreprise($entreprise);
        $trace->setDate(new \DateTime());
        $trace->setElement($element);
        $photo1 = new Photo();
        $trace->addPhoto($photo1);
        //}

        $form = $this->createForm(TraceType::class, $trace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $gestionImage = $this->get('otacos_gestion.image');
            foreach ($trace->getPhotos() as $photo) {
                $originalName = $photo->getFile()->getClientOriginalName();
                $photo->setUrl($gestionImage->telecharger($photo->getFile(), array('prefix'=>$gestionImage::slugify( $originalName ))
                        ));
            }

            $em->persist($trace);
            $em->flush();
            //$session->getFlashBag()->add('message', 'Votre annonce a bien été enregistré');

            return $this->redirectToRoute('tracabilite_choixElement', array('slug' => $slugCategorie));
        }

        return $this->render('TracabiliteBundle:trace:new.html.twig', array(
            'trace' => $trace,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a trace entity.
     *
     */
    public function showAction(Trace $trace)
    {
        $this->get('otacos_app.service')->verifierAbonnement();
        $deleteForm = $this->createDeleteForm($trace);

        return $this->render('TracabiliteBundle:trace:show.html.twig', array(
            'trace' => $trace,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing trace entity.
     *
     */
    public function editAction(Request $request, Trace $trace)
    {
        $this->get('otacos_app.service')->verifierAbonnement();
        $deleteForm = $this->createDeleteForm($trace);
        $editForm = $this->createForm('TracabiliteBundle\Form\TraceEditType', $trace);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trace_edit', array('id' => $trace->getId()));
        }

        return $this->render('TracabiliteBundle:trace:edit.html.twig', array(
            'trace' => $trace,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a trace entity.
     *
     */
    public function deleteAction(Request $request, Trace $trace)
    {
        $this->get('otacos_app.service')->verifierAbonnement();
        $form = $this->createDeleteForm($trace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $lesPhotoAsupprimer = array();
            foreach ($trace->getPhotos() as $photo) {
                $lesPhotoAsupprimer[] = $photo->getUrl();
            }

            $em->remove($trace);
            $em->flush($trace);

            $gestionImage = $this->get('otacos_gestion.image');
            foreach ($lesPhotoAsupprimer as $p) {
                $gestionImage->supprimer($p, 'trace');
            }
        }

        return $this->redirectToRoute('historique_tracabilite');
    }

    public function deleteButtonAction(Trace $trace){
        $form = $this->createDeleteForm($trace);
        return $this->render('TracabiliteBundle:trace:deleteButton.html.twig', array(
            'form' => $form->createView(),
            'id'=>$trace->getId(),
        ));
    }

    /**
     * Creates a form to delete a trace entity.
     *
     * @param Trace $trace The trace entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Trace $trace)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trace_delete', array('id' => $trace->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
