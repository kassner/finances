<?php

namespace Kassner\FinancesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kassner\FinancesBundle\Entity\Payee;
use Kassner\FinancesBundle\Form\PayeeType;
use Kassner\FinancesBundle\Form\Search\PayeeSearch;

/**
 * Payee controller.
 *
 * @Route("/payee")
 */
class PayeeController extends Controller
{

    /**
     * Lists all Payee entities.
     *
     * @Route("/", name="payee")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $showSearch = false;
        $entity = new Payee();

        $searchForm = $this->createSearchForm($entity);
        $searchForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('KassnerFinancesBundle:Payee')->createQueryBuilder('t');

        return array(
            'search_form' => $searchForm->createView(),
            'entities' => $query->getQuery()->getResult(),
            'showSearch' => $showSearch
        );
    }

    /**
     * Creates a search Payee form.
     *
     * @param Payee $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSearchForm(Payee $entity)
    {
        $form = $this->createForm(new PayeeSearch(), $entity, array(
            'action' => $this->generateUrl('payee'),
            'method' => 'GET',
        ));

        return $form;
    }

    /**
     * Creates a new Payee entity.
     *
     * @Route("/", name="payee_create")
     * @Method("POST")
     * @Template("KassnerFinancesBundle:Payee:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Payee();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'The Payee was saved successfully.');
            return $this->redirect($this->generateUrl('payee'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Payee entity.
     *
     * @param Payee $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Payee $entity)
    {
        $form = $this->createForm(new PayeeType(), $entity, array(
            'action' => $this->generateUrl('payee_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'control', array(
            'back_url' => $this->generateUrl('payee')
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Payee entity.
     *
     * @Route("/new", name="payee_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Payee();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Payee entity.
     *
     * @Route("/{id}/edit", name="payee_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KassnerFinancesBundle:Payee')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Unable to find Payee entity.');
            return $this->redirect($this->generateUrl('payee'));
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity' => $entity,
            'form' => $editForm->createView()
        );
    }

    /**
     * Creates a form to edit a Payee entity.
     *
     * @param Payee $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Payee $entity)
    {
        $form = $this->createForm(new PayeeType(), $entity, array(
            'action' => $this->generateUrl('payee_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'control', array(
            'back_url' => $this->generateUrl('payee'),
            'delete_url' => $this->generateUrl('payee_delete', array('id' => $entity->getId()))
        ));

        return $form;
    }

    /**
     * Edits an existing Payee entity.
     *
     * @Route("/{id}", name="payee_update")
     * @Method("PUT")
     * @Template("KassnerFinancesBundle:Payee:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KassnerFinancesBundle:Payee')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Unable to find Payee entity.');
            return $this->redirect($this->generateUrl('payee'));
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'The Payee was saved successfully.');
            return $this->redirect($this->generateUrl('payee'));
        }

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Payee entity.
     *
     * @Route("/{id}/delete", name="payee_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KassnerFinancesBundle:Payee')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Unable to find Payee entity.');
            return $this->redirect($this->generateUrl('payee'));
        }

        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'The Payee was removed successfully.');
        return $this->redirect($this->generateUrl('payee'));
    }

}
