<?php

namespace Kassner\FinancesBundle\Repository;

use Doctrine\ORM\EntityRepository;

class Transaction extends EntityRepository
{

    public function getQueryByAccountId($accountId)
    {
        $query = $this->createQueryBuilder('t');

        $query->leftJoin('t.transfer', 'tt');
        $query->andWhere('t.account = :account OR tt.account = :account');
        $query->setParameter('account', $accountId);

        $query->orderBy('t.date', 'ASC');

        return $query;
    }

    public function findByAccountId($accountId)
    {
        return $this->getQueryByAccountId($accountId)->getQuery()->getResult();
    }

}
