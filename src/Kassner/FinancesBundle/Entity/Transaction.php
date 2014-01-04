<?php

namespace Kassner\FinancesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction", indexes={@ORM\Index(name="IDX_723705D19B6B5FBA", columns={"account_id"}), @ORM\Index(name="IDX_723705D1CB4B68F", columns={"payee_id"}), @ORM\Index(name="IDX_723705D112469DE2", columns={"category_id"})})
 * @ORM\Entity
 */
class Transaction
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=12, scale=2, nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="is_reconciled", type="boolean")
     */
    private $isReconciled = false;

    /**
     * @var \Kassner\FinancesBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Kassner\FinancesBundle\Entity\Category", inversedBy="transactions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \Kassner\FinancesBundle\Entity\Account
     *
     * @ORM\ManyToOne(targetEntity="Kassner\FinancesBundle\Entity\Account", inversedBy="transactions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $account;

    /**
     * @var \Kassner\FinancesBundle\Entity\Payee
     *
     * @ORM\ManyToOne(targetEntity="Kassner\FinancesBundle\Entity\Payee")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payee_id", referencedColumnName="id")
     * })
     */
    private $payee;

    /**
     * @var \Kassner\FinancesBundle\Entity\TransactionTransfer
     *
     * @ORM\OneToOne(targetEntity="Kassner\FinancesBundle\Entity\TransactionTransfer", mappedBy="transaction")
     */
    private $transfer;

    public function getId()
    {
        return $this->id;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function getPayee()
    {
        return $this->payee;
    }

    public function getTransfer()
    {
        return $this->transfer;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setDate(\DateTime $date = null)
    {
        $this->date = $date;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setCategory(\Kassner\FinancesBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    public function setAccount(\Kassner\FinancesBundle\Entity\Account $account)
    {
        $this->account = $account;
    }

    public function setPayee(\Kassner\FinancesBundle\Entity\Payee $payee)
    {
        $this->payee = $payee;
    }

    public function setTransfer(\Kassner\FinancesBundle\Entity\TransactionTransfer $transfer)
    {
        $this->transfer = $transfer;
    }

    public function getIsReconciled()
    {
        return $this->isReconciled;
    }

    public function setIsReconciled($isReconciled)
    {
        $this->isReconciled = $isReconciled;
    }

}
