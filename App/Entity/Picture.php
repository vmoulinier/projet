<?php


namespace App\Entity;

/**
 * @Entity @Table(name="picture")
 */
class Picture
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Advert")
     */
    private $advert;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $name;

    /**
     * @Column(type="datetime")
     */
    private $createdAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Picture
     */
    public function setId(int $id): Picture
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Advert
     */
    public function getAdvert(): Advert
    {
        return $this->advert;
    }

    /**
     * @param mixed $advert
     * @return Picture
     */
    public function setAdvert($advert)
    {
        $this->advert = $advert;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Picture
     */
    public function setName(string $name): Picture
    {
        $this->name = $name;
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
     * @return Picture
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getLink(): string
    {
        return PATH . '/' . UPLOAD_PATH . $this->getAdvert()->getUser()->getId() . '/' . $this->getName();
    }

    public function getRelLink(): string
    {
        return UPLOAD_PATH . $this->getAdvert()->getUser()->getId() . '/' . $this->getName();
    }
}
