<?php

namespace Kassner\FinancesBundle\Twig;

use Doctrine\ORM\EntityRepository;

class AccountsExtension extends \Twig_Extension
{

    private $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getGlobals()
    {
        $accounts = $this->repository->findAll();
        $balance = 0;

        foreach ($accounts as $account) {
            $balance += $account->getBalance();
        }

        return array(
            'accounts' => $accounts,
            'balance' => $balance
        );
    }

    public function getName()
    {
        return 'accounts';
    }

}
