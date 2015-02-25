<?php

namespace Sato\MoviesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sato\MoviesBundle\Entity\Genre;
use Sato\MoviesBundle\Form\GenreType;

/**
 * Genre controller.
 *
 */
class GenreController extends Controller
{

	/**
	 * Lists all Genre entities.
	 *
	 * @Route("/", name="admin_genre")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SatoMoviesBundle:Genre')->findBy( array(), array( 'name'=> 'asc' ) ) ;

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
	 * Creates a new Genre entity.
	 *
	 * @Route("/", name="admin_genre_create")
	 * @Method("POST")
	 * @Template("SatoMoviesBundle:Genre:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$entity = new Genre();
		$form = $this->createCreateForm($entity);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('admin_genre_show', array('id' => $entity->getId())));
		}

		return $this->render('SatoMoviesBundle:Genre:new.html.twig', array(
			'entity' => $entity,
			'form'   => $form->createView(),
		));
	}

	/**
	 * Creates a form to create a Genre entity.
	 *
	 * @param Genre $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createCreateForm(Genre $entity)
	{
		$form = $this->createForm(new GenreType(), $entity, array(
			'action' => $this->generateUrl('admin_genre_create'),
			'method' => 'POST',
		));

		$form->add('submit', 'submit', array('label' => 'Create'));

		return $form;
	}

	/**
	 * Displays a form to create a new Genre entity.
	 *
	 * @Route("/new", name="admin_genre_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$entity = new Genre();
		$form   = $this->createCreateForm($entity);

		return $this->render('SatoMoviesBundle:Genre:new.html.twig', array(
			'entity' => $entity,
			'form'   => $form->createView(),
		));
	}

	/**
	 * Finds and displays a Genre entity.
	 *
	 * @Route("/{id}", name="admin_genre_show")
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Genre')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Genre entity.');
		}

		$deleteForm = $this->createDeleteForm($id);

		return $this->render('SatoMoviesBundle:Genre:show.html.twig', array(
			'entity'      => $entity,
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	 * Displays a form to edit an existing Genre entity.
	 *
	 * @Route("/{id}/edit", name="admin_genre_edit")
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Genre')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Genre entity.');
		}

		$editForm = $this->createEditForm($entity);
		$deleteForm = $this->createDeleteForm($id);

		return $this->render('SatoMoviesBundle:Genre:edit.html.twig', array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}

	/**
	* Creates a form to edit a Genre entity.
	*
	* @param Genre $entity The entity
	*
	* @return \Symfony\Component\Form\Form The form
	*/
	private function createEditForm(Genre $entity)
	{
		$form = $this->createForm(new GenreType(), $entity, array(
			'action' => $this->generateUrl('admin_genre_update', array('id' => $entity->getId())),
			'method' => 'PUT',
		));

		$form->add('submit', 'submit', array('label' => 'Update'));

		return $form;
	}
	/**
	 * Edits an existing Genre entity.
	 *
	 * @Route("/{id}", name="admin_genre_update")
	 * @Method("PUT")
	 * @Template("SatoMoviesBundle:Genre:edit.html.twig")
	 */
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Genre')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Genre entity.');
		}

		$deleteForm = $this->createDeleteForm($id);
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->flush();

			return $this->redirect($this->generateUrl('admin_genre_edit', array('id' => $id)));
		}

		return $this->render('SatoMoviesBundle:Genre:edit.html.twig', array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		));
	}
	/**
	 * Deletes a Genre entity.
	 *
	 * @Route("/{id}", name="admin_genre_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, $id)
	{
		$form = $this->createDeleteForm($id);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository('SatoMoviesBundle:Genre')->find($id);

			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Genre entity.');
			}

			$em->remove($entity);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('admin_genre'));
	}

	/**
	 * Creates a form to delete a Genre entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm($id)
	{
		return $this->createFormBuilder()
			->setAction($this->generateUrl('admin_genre_delete', array('id' => $id)))
			->setMethod('DELETE')
			->add('submit', 'submit', array('label' => 'Delete'))
			->getForm()
		;
	}
}
