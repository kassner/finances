<?php

namespace Kassner\FinancesBundle\Service;

use Doctrine\ORM\EntityRepository;

class Category
{

    protected $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getTop10($period, $type)
    {
        /** @TODO $period */
        $builder = $this->repository->createQueryBuilder('c')
            ->addSelect('c.id')
            ->addSelect('c.name')
            ->addSelect('SUM(t.amount) AS balance')
            ->andWhere('t.type = :type')
            ->join('c.transactions', 't')
            ->orderBy('balance', 'DESC')
            ->setParameter('type', $type)
            ->addGroupBy('c.id')
            ->addGroupBy('c.name')
        ;

        return $builder->getQuery()->getResult();
    }

}
