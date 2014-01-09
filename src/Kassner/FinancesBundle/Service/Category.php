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
        switch ($period) {
            case 'last_year':
                $dateStart = date('Y-01-01', strtotime('-1 year'));
                $dateEnd = date('Y-12-31', strtotime('-1 year'));
                break;
            case 'this_year':
            default:
                $dateStart = date('Y-01-01');
                $dateEnd = date('Y-12-31');
                break;
            case 'last_month':
                $dateStart = date('Y-m-01', strtotime('-1 month'));
                $dateEnd = date('Y-m-t', strtotime('-1 month'));
                break;
            case 'this_month':
            default:
                $dateStart = date('Y-m-01');
                $dateEnd = date('Y-m-t');
                break;
        }

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
            ->andWhere('t.date >= :date_start AND t.date <= :date_end')
            ->setParameter('date_start', $dateStart)
            ->setParameter('date_end', $dateEnd)
            ->setMaxResults(10)
        ;

        return $builder->getQuery()->getResult();
    }

}
