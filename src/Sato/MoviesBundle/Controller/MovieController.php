<?php

namespace Sato\MoviesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sato\MoviesBundle\Entity\Movie;
use Sato\MoviesBundle\Form\MovieType;

/**
 * Movie controller.
 *
 * @Route("/admin/movie")
 */
class MovieController extends Controller
{
	/**
	 * Lists all Movie entities.
	 *
	 * @Route("/", name="admin_movie")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction( Request $request )
	{
        $data = $request->query->all() ;
        
		$em = $this->getDoctrine()->getManager();

        if ( $request->getMethod() == 'GET' && ( ! empty( $data['title'] ) || ! empty ( $data['country'] ) || ! empty ( $data['distributor'] ) )) {
            $entities = $em->getRepository('SatoMoviesBundle:Movie')->search( $data ) ;
        }
        else {
            $entities = $em->getRepository('SatoMoviesBundle:Movie')->findBy( array(), array( 'createdAt'=> 'desc' ) );
        }

        // Popula o select country
        $countries = $em->getRepository('SatoMoviesBundle:Country')->findBy( array(), array( 'name'=> 'asc' ) );

		$paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities ,
            $request->query->get('page', 1) ,
            $this->container->getParameter('knp_paginator.page_range')
        ) ;

		return array(
			'entities' => $pagination ,
            'countries' => $countries ,
		);
	}

	/**
	 * Creates a new Movie entity.
	 *
	 * @Route("/", name="admin_movie_create")
	 * @Method("POST")
	 * @Template("SatoMoviesBundle:Movie:new.html.twig")
	 */
	public function createAction(Request $request)
	{
		$entity = new Movie();
		$form = $this->createCreateForm($entity);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('admin_movie_show', array('id' => $entity->getId())));
		}

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
		);
	}

	/**
	 * Creates a form to create a Movie entity.
	 *
	 * @param Movie $entity The entity
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createCreateForm(Movie $entity)
	{
		$form = $this->createForm(new MovieType(), $entity, array(
			'action' => $this->generateUrl('admin_movie_create'),
			'method' => 'POST',
		));

		$form->add('submit', 'submit', array('label' => 'Create'));

		return $form;
	}

	/**
	 * Displays a form to create a new Movie entity.
	 *
	 * @Route("/new", name="admin_movie_new")
	 * @Method("GET")
	 * @Template()
	 */
	public function newAction()
	{
		$entity = new Movie();
		$form   = $this->createCreateForm($entity);

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
		);
	}

	/**
	 * Finds and displays a Movie entity.
	 *
	 * @Route("/{id}", name="admin_movie_show")
	 * @Method("GET")
	 * @Template()
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Movie')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Movie entity.');
		}

		$deleteForm = $this->createDeleteForm($id);

		return array(
			'entity'      => $entity,
			'delete_form' => $deleteForm->createView(),
		);
	}

	/**
	 * Displays a form to edit an existing Movie entity.
	 *
	 * @Route("/{id}/edit", name="admin_movie_edit")
	 * @Method("GET")
	 * @Template()
	 */
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Movie')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Movie entity.');
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
	* Creates a form to edit a Movie entity.
	*
	* @param Movie $entity The entity
	*
	* @return \Symfony\Component\Form\Form The form
	*/
	private function createEditForm(Movie $entity)
	{
		$form = $this->createForm(new MovieType(), $entity, array(
			'action' => $this->generateUrl('admin_movie_update', array('id' => $entity->getId())),
			'method' => 'PUT',
		));

		$form->add('submit', 'submit', array('label' => 'Update'));

		return $form;
	}
	/**
	 * Edits an existing Movie entity.
	 *
	 * @Route("/{id}", name="admin_movie_update")
	 * @Method("PUT")
	 * @Template("SatoMoviesBundle:Movie:edit.html.twig")
	 */
	public function updateAction(Request $request, $id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Movie')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Movie entity.');
		}

		$deleteForm = $this->createDeleteForm($id);
		$editForm = $this->createEditForm($entity);
		$editForm->handleRequest($request);

		if ($editForm->isValid()) {
			$em->flush();

			return $this->redirect($this->generateUrl('admin_movie_edit', array('id' => $id)));
		}

		return array(
			'entity'      => $entity,
			'edit_form'   => $editForm->createView(),
			'delete_form' => $deleteForm->createView(),
		);
	}
	/**
	 * Deletes a Movie entity.
	 *
	 * @Route("/{id}", name="admin_movie_delete")
	 * @Method("DELETE")
	 */
	public function deleteAction(Request $request, $id)
	{
		$form = $this->createDeleteForm($id);
		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$entity = $em->getRepository('SatoMoviesBundle:Movie')->find($id);

			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Movie entity.');
			}

			$em->remove($entity);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('admin_movie'));
	}

	/**
	 * Creates a form to delete a Movie entity by id.
	 *
	 * @param mixed $id The entity id
	 *
	 * @return \Symfony\Component\Form\Form The form
	 */
	private function createDeleteForm($id)
	{
		return $this->createFormBuilder()
			->setAction($this->generateUrl('admin_movie_delete', array('id' => $id)))
			->setMethod('DELETE')
			->add('submit', 'submit', array('label' => 'Delete'))
			->getForm()
		;
	}

	/**
	 * Export data.
	 *
	 * @Route("/", name="admin_movie_export")
	 * @Method("GET")
	 */
	public function exportAction()
	{
		$repository = $this->getDoctrine()->getRepository('SatoMoviesBundle:Movie'); 
		$query = $repository->createQueryBuilder('m'); 
		$query->orderBy('m.id', 'ASC'); 

		$data = $query->getQuery()->getResult(); 
		$filename = "export_".date("Y_m_d_His").".csv"; 
		$response = $this->render('SatoMoviesBundle:Movie:export.html.twig', array('data' => $data)); 

		$response->setStatusCode(200);
		$response->headers->set('Content-Type', 'text/csv');
		$response->headers->set('Content-Description', 'Submissions Export');
		$response->headers->set('Content-Disposition', 'attachment; filename='.$filename);
		$response->headers->set('Content-Transfer-Encoding', 'binary');
		$response->headers->set('Pragma', 'no-cache');
		$response->headers->set('Expires', '0');
		
		return $response; 
	}
}
