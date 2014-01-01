<?php

namespace Kassner\FinancesBundle\Service;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Kassner\FinancesBundle\Entity\Transaction as TransactionEntity;
use Kassner\FinancesBundle\Entity\Account as AccountEntity;

class TransactionListener
{

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof TransactionEntity) {
            $this->updateAccountBalance($entity->getAccount());
            $args->getEntityManager()->persist($entity->getAccount());
            $args->getEntityManager()->flush();
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof TransactionEntity) {
            $this->updateAccountBalance($entity->getAccount());
            $args->getEntityManager()->persist($entity->getAccount());
            $args->getEntityManager()->flush();
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof TransactionEntity) {
            $this->updateAccountBalance($entity->getAccount());
            $args->getEntityManager()->persist($entity->getAccount());
            $args->getEntityManager()->flush();
        }
    }

    public function updateAccountBalance(AccountEntity $account)
    {
        $balance = 0;

        foreach ($account->getTransactions() as $transaction) {
            if ($transaction->getType() == 'income') {
                $balance += $transaction->getAmount();
            } elseif ($transaction->getType() == 'expense') {
                $balance -= $transaction->getAmount();
            }

            /**
             * @TODO support transfers
             */
        }

        $account->setBalance($balance);
    }

}
