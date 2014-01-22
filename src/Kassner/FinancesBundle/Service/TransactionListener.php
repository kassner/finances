<?php

namespace Kassner\FinancesBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Kassner\FinancesBundle\Entity\Transaction as TransactionEntity;
use Kassner\FinancesBundle\Entity\Account as AccountEntity;

class TransactionListener
{

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof TransactionEntity) {
            $this->updateBalance($args->getEntityManager());
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof TransactionEntity) {
            $this->updateBalance($args->getEntityManager());
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof TransactionEntity) {
            $this->updateBalance($args->getEntityManager());
        }
    }

    public function updateBalance(EntityManager $em)
    {
        /**
         * @TODO update balance only for changed accounts
         */
        $transactions = $em->getRepository('KassnerFinancesBundle:Transaction')->findAll();
        $accounts = array();

        foreach ($transactions as $transaction) {
            if (!isset($accounts[$transaction->getAccount()->getId()])) {
                $accounts[$transaction->getAccount()->getId()] = 0;
            }

            switch ($transaction->getType()) {
                case 'income':
                    $accounts[$transaction->getAccount()->getId()] += $transaction->getAmount();
                    break;
                case 'expense':
                    $accounts[$transaction->getAccount()->getId()] -= $transaction->getAmount();
                    break;
                case 'transfer':
                    if (!isset($accounts[$transaction->getTransfer()->getAccount()->getId()])) {
                        $accounts[$transaction->getTransfer()->getAccount()->getId()] = 0;
                    }

                    $accounts[$transaction->getAccount()->getId()] -= $transaction->getAmount();
                    $accounts[$transaction->getTransfer()->getAccount()->getId()] += $transaction->getAmount();
                    break;
            }
        }

        foreach ($accounts as $id => $balance) {
            $account = $em->getRepository('KassnerFinancesBundle:Account')->find($id);
            $account->setBalance($balance);
            $em->persist($account);
        }

        $em->flush();
    }

}
