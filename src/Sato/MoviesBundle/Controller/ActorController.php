<?php

namespace Sato\MoviesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sato\MoviesBundle\Entity\Actor;
use Sato\MoviesBundle\Form\ActorType;

/**
 * Actor controller.
 *
 * @Route("/admin/actor")
 */
class ActorController extends Controller
{

	/**
	 * Lists all Actor entities.
	 *
	 * @Route("/", name="admin_actor")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$sql = "SELECT a FROM SatoMoviesBundle:Actor a";
		$query = $em->createQuery($sql);

		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$request->query->get('page', 1),
			5
		);
		return array(
			'entities' => $pagination,
		);
	}
	/**
	 * Creates a new Actor entity.
	 *
	 * @Route("/", name="admin_actor_create")
	 * @Method("POST")
	 * @Template("SatoMoviesBundle:Actor:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$entity = new Actor();
		$form = $this->createCreateForm($entity);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('admin_actor_show', array('id' => $entity->getId())));
		}

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
		);
	}

	/**
	 * Creates a form to create a Actor entity.
	 *
	 * @param Actor $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createCreateForm(Actor $entity)
	{
		$form = $this->createForm(new ActorType(), $entity, array(
			'action' => $this->generateUrl('admin_actor_create'),
			'method' => 'POST',
		));

		$form->add('submit', 'submit', array('label' => 'Create'));

		return $form;
	}

	/**
	 * Displays a form to create a new Actor entity.
	 *
	 * @Route("/new", name="admin_actor_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$entity = new Actor();
		$form   = $this->createCreateForm($entity);

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
		);
	}

	/**
	 * Finds and displays a Actor entity.
	 *
	 * @Route("/{id}", name="admin_actor_show")
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Actor')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Actor entity.');
		}

		$deleteForm = $this->createDeleteForm($id);

		return array(
			'entity'      => $entity,
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Displays a form to edit an existing Actor entity.
	 *
	 * @Route("/{id}/edit", name="admin_actor_edit")
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Actor')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Actor entity.');
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
	* Creates a form to edit a Actor entity.
	*
	* @param Actor $entity The entity
	*
	* @return \Symfony\Component\Form\Form The form
	*/
	private function createEditForm(Actor $entity)
	{
		$form = $this->createForm(new ActorType(), $entity, array(
			'action' => $this->generateUrl('admin_actor_update', array('id' => $entity->getId())),
			'method' => 'PUT',
		));

		$form->add('submit', 'submit', array('label' => 'Update'));

		return $form;
	}
	/**
	 * Edits an existing Actor entity.
	 *
	 * @Route("/{id}", name="admin_actor_update")
	 * @Method("PUT")
	 * @Template("SatoMoviesBundle:Actor:edit.html.twig")
	 */
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Actor')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Actor entity.');
		}

		$deleteForm = $this->createDeleteForm($id);
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->flush();

			return $this->redirect($this->generateUrl('admin_actor_edit', array('id' => $id)));
		}

		return array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}
	/**
	 * Deletes a Actor entity.
	 *
	 * @Route("/{id}", name="admin_actor_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, $id)
	{
		$form = $this->createDeleteForm($id);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository('SatoMoviesBundle:Actor')->find($id);

			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Actor entity.');
			}

			$em->remove($entity);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('admin_actor'));
	}

	/**
	 * Creates a form to delete a Actor entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm($id)
	{
		return $this->createFormBuilder()
			->setAction($this->generateUrl('admin_actor_delete', array('id' => $id)))
			->setMethod('DELETE')
			->add('submit', 'submit', array('label' => 'Delete'))
			->getForm()
		;
	}
}
