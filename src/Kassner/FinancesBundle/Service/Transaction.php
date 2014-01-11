<?php

namespace Kassner\FinancesBundle\Service;

use Doctrine\ORM\EntityRepository;

class Transaction
{

    protected $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

	public function getQueryByAccountId($accountId)
	{
        $query = $this->repository->createQueryBuilder('t');

        $query->leftJoin('t.transfer', 'tt');
        $query->andWhere('t.account = :account OR tt.account = :account');
        $query->setParameter('account', $accountId);

        $query->orderBy('t.date', 'ASC');

        return $query;
	}

}