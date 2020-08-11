<?php


namespace App\Entity;

/**
 * @Entity @Table(name="urgent")
 */
class Urgent
{
    const STATUS_ACTIVE = 'active';

    const STATUS_FINISHED = 'finished';
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Advert", inversedBy="invoice")
     * @JoinColumn(name="advert_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $advert;

    /**
     * @Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Column(type="integer", nullable=false)
     * @var int
     */
    private $duration;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Urgent
     */
    public function setId(int $id): Urgent
    {
        $this->id = $id;
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
     * @return Urgent
     */
    public function setAdvert($advert)
    {
        $this->advert = $advert;
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
     * @return Urgent
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     * @return Urgent
     */
    public function setDuration(int $duration): Urgent
    {
        $this->duration = $duration;
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
     * @return Urgent
     */
    public function setStatus(string $status): Urgent
    {
        $this->status = $status;
        return $this;
    }
}
