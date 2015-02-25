<?php

namespace Sato\MoviesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sato\MoviesBundle\Entity\Distributor;
use Sato\MoviesBundle\Form\DistributorType;

/**
 * Distributor controller.
 *
 */
class DistributorController extends Controller
{

	/**
	 * Lists all Distributor entities.
	 *
	 * @Route("/", name="admin_distributor")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SatoMoviesBundle:Distributor')->findBy( array(), array( 'name'=> 'asc' ) ) ;

		$paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities ,
            $request->query->get('page', 1) ,
            $this->container->getParameter('knp_paginator.page_range')
        ) ;

		return array(
			'entities' => $pagination,
		);
	}
	/**
	 * Creates a new Distributor entity.
	 *
	 * @Route("/", name="admin_distributor_create")
	 * @Method("POST")
	 * @Template("SatoMoviesBundle:Distributor:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$entity = new Distributor();
		$form = $this->createCreateForm($entity);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('admin_distributor_show', array('id' => $entity->getId())));
		}

		return $this->render('SatoMoviesBundle:Distributor:new.html.twig', array(
			'entity' => $entity,
			'form'   => $form->createView(),
		));
	}

	/**
	 * Creates a form to create a Distributor entity.
	 *
	 * @param Distributor $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createCreateForm(Distributor $entity)
	{
		$form = $this->createForm(new DistributorType(), $entity, array(
			'action' => $this->generateUrl('admin_distributor_create'),
			'method' => 'POST',
		));

		$form->add('submit', 'submit', array('label' => 'Create'));

		return $form;
	}

	/**
	 * Displays a form to create a new Distributor entity.
	 *
	 * @Route("/new", name="admin_distributor_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$entity = new Distributor();
		$form   = $this->createCreateForm($entity);

		return $this->render('SatoMoviesBundle:Distributor:new.html.twig', array(
			'entity' => $entity,
			'form'   => $form->createView(),
		));
	}

	/**
	 * Finds and displays a Distributor entity.
	 *
	 * @Route("/{id}", name="admin_distributor_show")
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Distributor')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Distributor entity.');
		}

		$deleteForm = $this->createDeleteForm($id);

		return $this->render('SatoMoviesBundle:Distributor:show.html.twig', array(
			'entity'      => $entity,
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Displays a form to edit an existing Distributor entity.
	 *
	 * @Route("/{id}/edit", name="admin_distributor_edit")
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Distributor')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Distributor entity.');
		}

		$editForm = $this->createEditForm($entity);
		$deleteForm = $this->createDeleteForm($id);

		return $this->render('SatoMoviesBundle:Distributor:edit.html.twig', array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	* Creates a form to edit a Distributor entity.
	*
	* @param Distributor $entity The entity
	*
	* @return \Symfony\Component\Form\Form The form
	*/
	private function createEditForm(Distributor $entity)
	{
		$form = $this->createForm(new DistributorType(), $entity, array(
			'action' => $this->generateUrl('admin_distributor_update', array('id' => $entity->getId())),
			'method' => 'PUT',
		));

		$form->add('submit', 'submit', array('label' => 'Update'));

		return $form;
	}
	/**
	 * Edits an existing Distributor entity.
	 *
	 * @Route("/{id}", name="admin_distributor_update")
	 * @Method("PUT")
	 * @Template("SatoMoviesBundle:Distributor:edit.html.twig")
	 */
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Distributor')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Distributor entity.');
		}

		$deleteForm = $this->createDeleteForm($id);
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->flush();

			return $this->redirect($this->generateUrl('admin_distributor_edit', array('id' => $id)));
		}

		return $this->render('SatoMoviesBundle:Distributor:edit.html.twig', array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}
	/**
	 * Deletes a Distributor entity.
	 *
	 * @Route("/{id}/delete", name="admin_distributor_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, $id)
	{
		$form = $this->createDeleteForm($id);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository('SatoMoviesBundle:Distributor')->find($id);

			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Distributor entity.');
			}

			$em->remove($entity);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('admin_distributor'));
	}

	/**
	 * Creates a form to delete a Distributor entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm($id)
	{
		return $this->createFormBuilder()
			->setAction($this->generateUrl('admin_distributor_delete', array('id' => $id)))
			->setMethod('DELETE')
			->add('submit', 'submit', array('label' => 'Delete'))
			->getForm()
		;
	}
}
