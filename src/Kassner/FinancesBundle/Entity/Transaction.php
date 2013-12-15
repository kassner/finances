<?php

namespace Kassner\FinancesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction", indexes={@ORM\Index(name="fk_transaction_account_idx", columns={"account_id"}), @ORM\Index(name="fk_transaction_payee1_idx", columns={"payee_id"}), @ORM\Index(name="fk_transaction_category1_idx", columns={"category_id"})})
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *      "income" = "Kassner\FinancesBundle\Entity\Transaction\Income",
 *      "expense" = "Kassner\FinancesBundle\Entity\Transaction\Expense",
 *      "transfer" = "Kassner\FinancesBundle\Entity\Transaction\Transfer"
 * })
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
     * @var integer
     *
     * @ORM\Column(name="amount", type="decimal", nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \Kassner\FinancesBundle\Entity\Account
     *
     * @ORM\ManyToOne(targetEntity="Kassner\FinancesBundle\Entity\Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account_id", referencedColumnName="id")
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
     * @var \Kassner\FinancesBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Kassner\FinancesBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Transaction
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set account
     *
     * @param \Kassner\FinancesBundle\Entity\Account $account
     * @return Transaction
     */
    public function setAccount(\Kassner\FinancesBundle\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Kassner\FinancesBundle\Entity\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set payee
     *
     * @param \Kassner\FinancesBundle\Entity\Payee $payee
     * @return Transaction
     */
    public function setPayee(\Kassner\FinancesBundle\Entity\Payee $payee = null)
    {
        $this->payee = $payee;

        return $this;
    }

    /**
     * Get payee
     *
     * @return \Kassner\FinancesBundle\Entity\Payee 
     */
    public function getPayee()
    {
        return $this->payee;
    }

    /**
     * Set category
     *
     * @param \Kassner\FinancesBundle\Entity\Category $category
     * @return Transaction
     */
    public function setCategory(\Kassner\FinancesBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Kassner\FinancesBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

}
