<?php

namespace Acme\Bundle\LoginBundle\Controller;

use Acme\Bundle\LoginBundle\Controller\DefaultMainController;

use Acme\Bundle\LoginBundle\Entity\Logins;
use Acme\Bundle\LoginBundle\Form\LoginsType;

/**
 * Logins controller.
 *
 */
class LoginsController extends DefaultMainController
{
    /**
     * Lists all Logins entities.
     *
     */
    public function indexAction()
    {
    	$title= 'Mostrar Accesos';
    	$data = array('title'=> $title);
		
    	if ($this->acceso()) {
    		//###########################################
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('AcmeLoginBundle:Logins')->findAll();

        return $this->render('AcmeLoginBundle:Logins:index.html.twig', array(
            'entities' => $entities, 'title'=> $title
        ));
		//#################################################
		}else return $this->render('AcmeLoginBundle:Autentication:error.html.twig', $data);
    }

    /**
     * Finds and displays a Logins entity.
     *
     */
    public function showAction($id)
    {
    	$title= 'Mostrar Acceso';
    	$data = array('title'=> $title);
		
    	if ($this->acceso()) {
    		//###########################################
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeLoginBundle:Logins')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logins entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeLoginBundle:Logins:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
			'title'=> $title,
        ));
		//#################################################
		}else return $this->render('AcmeLoginBundle:Autentication:error.html.twig', $data);
    }

    /**
     * Displays a form to create a new Logins entity.
     *
     */
    public function newAction()
    {
    	$title= 'Nuevo Acceso';
    	$data = array('title'=> $title);
		
    	if ($this->admacceso()) {
    		//###########################################
        $entity = new Logins();
        $form   = $this->createForm(new LoginsType(), $entity);

        return $this->render('AcmeLoginBundle:Logins:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'title'=> $title
        ));
		//#################################################
		}else return $this->render('AcmeLoginBundle:Autentication:error.html.twig', $data);
    }

    /**
     * Creates a new Logins entity.
     *
     */
    public function createAction()
    {
    	$title= 'Crear Acceso';
    	$data = array('title'=> $title);
		
    	if ($this->admacceso()) {
    		//###########################################
        $entity  = new Logins();
        $request = $this->getRequest();
        $form    = $this->createForm(new LoginsType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('accesos_show', array('id' => $entity->getId())));
            
        }

        return $this->render('AcmeLoginBundle:Logins:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'title'=> $title
        ));
		//#################################################
		}else return $this->render('AcmeLoginBundle:Autentication:error.html.twig', $data);
    }

    /**
     * Displays a form to edit an existing Logins entity.
     *
     */
    public function editAction($id)
    {
    	$title= 'Editar Acceso';
    	$data = array('title'=> $title);
		
    	if ($this->admacceso()) {
    		//###########################################
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeLoginBundle:Logins')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logins entity.');
        }

        $editForm = $this->createForm(new LoginsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AcmeLoginBundle:Logins:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'title'=> $title,
        ));
		//#################################################
		}else return $this->render('AcmeLoginBundle:Autentication:error.html.twig', $data);
    }

    /**
     * Edits an existing Logins entity.
     *
     */
    public function updateAction($id)
    {
    	$title= 'Actualizar Acceso';
    	$data = array('title'=> $title);
		
    	if ($this->admacceso()) {
    		//###########################################
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AcmeLoginBundle:Logins')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Logins entity.');
        }

        $editForm   = $this->createForm(new LoginsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('accesos_edit', array('id' => $id)));
        }

        return $this->render('AcmeLoginBundle:Logins:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'title'=> $title,
        ));
		//#################################################
		}else return $this->render('AcmeLoginBundle:Autentication:error.html.twig', $data);
    }

    /**
     * Deletes a Logins entity.
     *
     */
    public function deleteAction($id)
    {
    	$title= 'Delete Acceso';
    	$data = array('title'=> $title);
		
    	if ($this->admacceso()) {
    		//###########################################
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AcmeLoginBundle:Logins')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Logins entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('accesos'));
		//#################################################
		}else return $this->render('AcmeLoginBundle:Autentication:error.html.twig', $data);
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
