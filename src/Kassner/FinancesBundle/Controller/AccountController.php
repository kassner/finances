<?php

namespace Kassner\FinancesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kassner\FinancesBundle\Entity\Account;
use Kassner\FinancesBundle\Form\AccountType;
use Kassner\FinancesBundle\Form\Search\AccountSearch;

/**
 * Account controller.
 *
 * @Route("/account")
 */
class AccountController extends Controller
{

    /**
     * Lists all Account entities.
     *
     * @Route("/", name="account")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $showSearch = false;
        $entity = new Account();

        $searchForm = $this->createSearchForm($entity);
        $searchForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('KassnerFinancesBundle:Account')->createQueryBuilder('t');

        return array(
            'search_form' => $searchForm->createView(),
            'entities' => $query->getQuery()->getResult(),
            'showSearch' => $showSearch
        );
    }

    /**
     * Creates a search Account form.
     *
     * @param Account $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSearchForm(Account $entity)
    {
        $form = $this->createForm(new AccountSearch(), $entity, array(
            'action' => $this->generateUrl('account'),
            'method' => 'GET',
        ));

        return $form;
    }

    /**
     * Creates a new Account entity.
     *
     * @Route("/", name="account_create")
     * @Method("POST")
     * @Template("KassnerFinancesBundle:Account:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Account();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'The Account was saved successfully.');
            return $this->redirect($this->generateUrl('account'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Account entity.
     *
     * @param Account $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Account $entity)
    {
        $form = $this->createForm(new AccountType(), $entity, array(
            'action' => $this->generateUrl('account_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'control', array(
            'back_url' => $this->generateUrl('account')
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Account entity.
     *
     * @Route("/new", name="account_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Account();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Account entity.
     *
     * @Route("/{id}/edit", name="account_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KassnerFinancesBundle:Account')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Unable to find Account entity.');
            return $this->redirect($this->generateUrl('account'));
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity' => $entity,
            'form' => $editForm->createView()
        );
    }

    /**
     * Creates a form to edit a Account entity.
     *
     * @param Account $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Account $entity)
    {
        $form = $this->createForm(new AccountType(), $entity, array(
            'action' => $this->generateUrl('account_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'control', array(
            'back_url' => $this->generateUrl('account'),
            'delete_url' => $this->generateUrl('account_delete', array('id' => $entity->getId()))
        ));

        return $form;
    }

    /**
     * Edits an existing Account entity.
     *
     * @Route("/{id}", name="account_update")
     * @Method("PUT")
     * @Template("KassnerFinancesBundle:Account:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KassnerFinancesBundle:Account')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Unable to find Account entity.');
            return $this->redirect($this->generateUrl('account'));
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'The Account was saved successfully.');
            return $this->redirect($this->generateUrl('account_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Account entity.
     *
     * @Route("/{id}/delete", name="account_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KassnerFinancesBundle:Account')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Unable to find Account entity.');
            return $this->redirect($this->generateUrl('account'));
        }

        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'The Account was removed successfully.');
        return $this->redirect($this->generateUrl('account'));
    }

}
