<?php

namespace Sato\MoviesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sato\MoviesBundle\Entity\Director;
use Sato\MoviesBundle\Form\DirectorType;

/**
 * Director controller.
 *
 * @Route("/admin/director")
 */
class DirectorController extends Controller
{

    /**
     * Lists all Director entities.
     *
     * @Route("/", name="admin_director")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SatoMoviesBundle:Director')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Director entity.
     *
     * @Route("/", name="admin_director_create")
     * @Method("POST")
     * @Template("SatoMoviesBundle:Director:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Director();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_director_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Director entity.
     *
     * @param Director $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Director $entity)
    {
        $form = $this->createForm(new DirectorType(), $entity, array(
            'action' => $this->generateUrl('admin_director_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Director entity.
     *
     * @Route("/new", name="admin_director_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Director();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Director entity.
     *
     * @Route("/{id}", name="admin_director_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SatoMoviesBundle:Director')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Director entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Director entity.
     *
     * @Route("/{id}/edit", name="admin_director_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SatoMoviesBundle:Director')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Director entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Director entity.
    *
    * @param Director $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Director $entity)
    {
        $form = $this->createForm(new DirectorType(), $entity, array(
            'action' => $this->generateUrl('admin_director_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Director entity.
     *
     * @Route("/{id}", name="admin_director_update")
     * @Method("PUT")
     * @Template("SatoMoviesBundle:Director:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SatoMoviesBundle:Director')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Director entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_director_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Director entity.
     *
     * @Route("/{id}", name="admin_director_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SatoMoviesBundle:Director')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Director entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_director'));
    }

    /**
     * Creates a form to delete a Director entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_director_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
