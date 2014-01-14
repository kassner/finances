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
            $this->updateAccountBalance($args->getEntityManager(), $entity->getAccount());
            $args->getEntityManager()->persist($entity->getAccount());
            $args->getEntityManager()->flush();
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof TransactionEntity) {
            $this->updateAccountBalance($args->getEntityManager(), $entity->getAccount());
            $args->getEntityManager()->persist($entity->getAccount());
            $args->getEntityManager()->flush();
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof TransactionEntity) {
            $this->updateAccountBalance($args->getEntityManager(), $entity->getAccount());
            $args->getEntityManager()->persist($entity->getAccount());
            $args->getEntityManager()->flush();
        }
    }

    public function updateAccountBalance(EntityManager $em, AccountEntity $account)
    {
        $balance = 0;
        $transactions = $em
            ->getRepository('KassnerFinancesBundle:Transaction')
            ->findByAccountId($account->getId())
        ;

        foreach ($transactions as $transaction) {
            switch ($transaction->getType()) {
                case 'income':
                    $balance += $transaction->getAmount();
                    break;
                case 'expense':
                    $balance -= $transaction->getAmount();
                    break;
                case 'transfer':
                    if ($account->getId() == $transaction->getTransfer()->getAccount()->getId()) {
                        $balance += $transaction->getAmount();
                    } else {
                        $balance -= $transaction->getAmount();
                        $this->updateAccountBalance($em, $transaction->getTransfer()->getAccount());
                    }
                    break;
            }
        }

        $account->setBalance($balance);
    }

}
