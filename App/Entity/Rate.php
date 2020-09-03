<?php


namespace App\Entity;

/**
 * @Entity @Table(name="rate")
 */
class Rate
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $comment;

    /**
     * @Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Column(type="integer", nullable=false)
     * @var int
     */
    private $rate;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Rate
     */
    public function setId(int $id): Rate
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return Rate
     */
    public function setComment(string $comment): Rate
    {
        $this->comment = $comment;
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
     * @return Rate
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getRate(): int
    {
        return $this->rate;
    }

    /**
     * @param int $rate
     * @return Rate
     */
    public function setRate(int $rate): Rate
    {
        $this->rate = $rate;
        return $this;
    }
}
