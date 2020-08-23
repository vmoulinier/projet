<?php


namespace App\Entity;

/**
 * @Entity @Table(name="transaction")
 */
class Transaction
{
    const TYPE_PAYPAL = 'paypal';

    const TYPE_CARD = 'card';

    const TYPE_TRANSFERT = 'transfert';

    const STATUS_PENDING = 'pending';

    const STATUS_FINISHED = 'finished';

    const STATUS_NEW = 'new';

    const PAYPAL_TAXES = 5;

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Invoice", inversedBy="transaction")
     * @JoinColumn(name="invoice_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $invoice;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     */
    private $type;

    /**
     * @Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Column(type="integer", nullable=false)
     * @var int
     */
    private $amount;

    /**
     * @Column(type="integer", nullable=true)
     * @var int
     */
    private $deliveryAmount;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $status;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="transaction")
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Transaction
     */
    public function setId(int $id): Transaction
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    /**
     * @param mixed $invoice
     * @return Transaction
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Transaction
     */
    public function setType(string $type): Transaction
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Transaction
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Transaction
     */
    public function setAmount(int $amount): Transaction
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeliveryAmount(): ?int
    {
        return $this->deliveryAmount;
    }

    /**
     * @param int $deliveryAmount
     * @return Transaction
     */
    public function setDeliveryAmount(int $deliveryAmount): Transaction
    {
        $this->deliveryAmount = $deliveryAmount;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Transaction
     */
    public function setStatus(string $status): Transaction
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Transaction
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getPaypalTaxes()
    {
        return ($this->getAmount() + $this->getDeliveryAmount())*self::PAYPAL_TAXES/100;
    }
}
