<?php


namespace App\Entity;

/**
 * @Entity @Table(name="invoice")
 */
class Invoice
{
    const STATUS_CLEARED = 'cleared';

    const STATUS_OUTSTANDING = 'outstanding';

    const TYPE_ADVERT = 'advert';

    const TYPE_SUBSCRIPTION = 'subscription';

    const TYPE_URGENT = 'urgent';

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $status;

    /**
     * @Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Column(type="integer", nullable=false)
     * @var int
     */
    private $reference;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $type;

    /**
     * @ManyToOne(targetEntity="Advert", inversedBy="invoice")
     * @JoinColumn(name="advert_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $advert;

    /**
     * @ManyToOne(targetEntity="Subscription", inversedBy="invoice")
     * @JoinColumn(name="subscription_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $subscription;

    /**
     * @ManyToOne(targetEntity="Urgent", inversedBy="invoice")
     * @JoinColumn(name="urgent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $urgent;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Invoice
     */
    public function setId(int $id): Invoice
    {
        $this->id = $id;
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
     * @return Invoice
     */
    public function setStatus(string $status): Invoice
    {
        $this->status = $status;
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
     * @return Invoice
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getReference(): int
    {
        return $this->reference;
    }

    /**
     * @param int $reference
     * @return Invoice
     */
    public function setReference(int $reference): Invoice
    {
        $this->reference = $reference;
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
     * @return Invoice
     */
    public function setType(string $type): Invoice
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
     * @param mixed $advert
     * @return Invoice
     */
    public function setAdvert($advert)
    {
        $this->advert = $advert;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param mixed $subscription
     * @return Invoice
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrgent()
    {
        return $this->urgent;
    }

    /**
     * @param mixed $urgent
     * @return Invoice
     */
    public function setUrgent($urgent)
    {
        $this->urgent = $urgent;
        return $this;
    }
}