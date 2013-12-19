<?php

namespace Kassner\FinancesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TransactionTransfer
 *
 * @ORM\Table(name="transaction_transfer", indexes={@ORM\Index(name="IDX_E468AA89B6B5FBA", columns={"account_id"})})
 * @ORM\Entity
 */
class TransactionTransfer
{

    /**
     * @var \Kassner\FinancesBundle\Entity\Transaction
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Kassner\FinancesBundle\Entity\Transaction", inversedBy="transfer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transaction_id", referencedColumnName="id")
     * })
     */
    private $transaction;

    /**
     * @var \Kassner\FinancesBundle\Entity\Account
     *
     * @ORM\ManyToOne(targetEntity="Kassner\FinancesBundle\Entity\Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     * })
     */
    private $account;

    public function getTransaction()
    {
        return $this->transaction;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function setTransaction(\Kassner\FinancesBundle\Entity\Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function setAccount(\Kassner\FinancesBundle\Entity\Account $account)
    {
        $this->account = $account;
    }

}
