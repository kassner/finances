<?php

namespace Kassner\FinancesBundle\Entity\Transaction;

use Kassner\FinancesBundle\Entity\Transaction;
use Doctrine\ORM\Mapping as ORM;

/**
 * Transfer
 *
 * @ORM\Table(name="transaction_transfer", indexes={@ORM\Index(name="fk_transaction_transfer_account1_idx", columns={"account_id"})})
 * @ORM\Entity
 */
class Transfer extends Transaction
{

    /**
     * @var \Kassner\FinancesBundle\Entity\Account
     *
     * @ORM\ManyToOne(targetEntity="Kassner\FinancesBundle\Entity\Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $toAccount;

    /**
     * Set destination account
     *
     * @param \Kassner\FinancesBundle\Entity\Account $toAccount
     * @return TransactionTransfer
     */
    public function setToAccount(\Kassner\FinancesBundle\Entity\Account $toAccount = null)
    {
        $this->toAccount = $toAccount;

        return $this;
    }

    /**
     * Get destination account
     *
     * @return \Kassner\FinancesBundle\Entity\Account 
     */
    public function getToAccount()
    {
        return $this->toAccount;
    }

}
