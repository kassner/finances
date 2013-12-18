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

        return array(
            'accounts' => $accounts
        );
    }

    public function getName()
    {
        return 'accounts';
    }

}
