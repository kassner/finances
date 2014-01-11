<?php

namespace Kassner\FinancesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kassner\FinancesBundle\Entity\Transaction;
use Kassner\FinancesBundle\Form\TransactionType;
use Kassner\FinancesBundle\Form\Search\TransactionSearch;

/**
 * Transaction controller.
 */
class TransactionController extends Controller
{

    /**
     * Lists all Transaction entities.
     *
     * @Route("/account/{account}/transaction", name="transaction", requirements={"account" = "\d+"})
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request, $account)
    {
        $em = $this->getDoctrine()->getManager();

        $account = $em->getRepository('KassnerFinancesBundle:Account')->find($account);

        if (!$account) {
            $this->get('session')->getFlashBag()->add('error', 'Unable to find Account entity.');
            return $this->redirect($this->generateUrl('account'));
        }

        $showSearch = false;
        $entity = new Transaction();
        $entity->setAccount($account);

        $searchForm = $this->createSearchForm($entity);
        $searchForm->handleRequest($request);

        $query = $this->get('finances.service.transaction')->getQueryByAccountId($account);

        return array(
            'account' => $account,
            'search_form' => $searchForm->createView(),
            'entities' => $query->getQuery()->getResult(),
            'showSearch' => $showSearch
        );
    }

    /**
     * Creates a search Transaction form.
     *
     * @param Transaction $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSearchForm(Transaction $entity)
    {
        $form = $this->createForm(new TransactionSearch(), $entity, array(
            'action' => $this->generateUrl('transaction', array('account' => $entity->getAccount()->getId())),
            'method' => 'GET',
        ));

        return $form;
    }

    /**
     * Creates a new Transaction entity.
     *
     * @Route("/transaction/", name="transaction_create")
     * @Method("POST")
     * @Template("KassnerFinancesBundle:Transaction:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Transaction();
        $entity->setDate(new \DateTime());

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'The Transaction was saved successfully.');
            return $this->redirect($this->generateUrl('transaction', array('account' => $entity->getAccount()->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Transaction entity.
     *
     * @param Transaction $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Transaction $entity)
    {
        $form = $this->createForm(new TransactionType(), $entity, array(
            'action' => $this->generateUrl('transaction_create'),
            'method' => 'POST',
        ));

        if ($entity->getAccount()) {
            $backUrl = $this->generateUrl('transaction', array('account' => $entity->getAccount()->getId()));
        } else {
            $backUrl = $this->generateUrl('home');
        }

        $form->add('submit', 'control', array(
            'back_url' => $backUrl
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Transaction entity.
     *
     * @Route("/transaction/new", name="transaction_new", defaults={"account" = null})
     * @Route("/transaction/new/{account}", name="transaction_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($account = null)
    {
        $entity = new Transaction();
        $entity->setDate(new \DateTime());

        if ($account) {
            $account = $this->getDoctrine()->getManager()->find('KassnerFinancesBundle:Account', $account);
            if ($account) {
                $entity->setAccount($account);
            }
        }

        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Transaction entity.
     *
     * @Route("/transaction/{id}/edit", name="transaction_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('KassnerFinancesBundle:Transaction')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Unable to find Transaction entity.');
            return $this->redirect($this->generateUrl('home'));
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity' => $entity,
            'form' => $editForm->createView()
        );
    }

    /**
     * Creates a form to edit a Transaction entity.
     *
     * @param Transaction $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Transaction $entity)
    {
        $form = $this->createForm(new TransactionType(), $entity, array(
            'action' => $this->generateUrl('transaction_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'control', array(
            'back_url' => $this->generateUrl('transaction', array('account' => $entity->getAccount()->getId())),
            'delete_url' => $this->generateUrl('transaction_delete', array('id' => $entity->getId()))
        ));

        return $form;
    }

    /**
     * Edits an existing Transaction entity.
     *
     * @Route("/transaction/{id}", name="transaction_update")
     * @Method("PUT")
     * @Template("KassnerFinancesBundle:Transaction:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KassnerFinancesBundle:Transaction')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Unable to find Transaction entity.');
            return $this->redirect($this->generateUrl('home'));
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'The Transaction was saved successfully.');
            return $this->redirect($this->generateUrl('transaction', array('account' => $entity->getAccount()->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
        );
    }

    /**
     * Deletes a Transaction entity.
     *
     * @Route("/transaction/{id}/delete", name="transaction_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('KassnerFinancesBundle:Transaction')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->add('error', 'Unable to find Transaction entity.');
            return $this->redirect($this->generateUrl('home'));
        }

        $accountId = $entity->getAccount()->getId();
        $em->remove($entity);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'The Transaction was removed successfully.');
        return $this->redirect($this->generateUrl('transaction', array('account' => $accountId)));
    }

}
