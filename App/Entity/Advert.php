<?php


namespace App\Entity;

use Core\Services\Services;

/**
 * @Entity @Table(name="advert")
 */
class Advert
{

    const STATUS_PENDING = 'pending';

    const STATUS_ACTIVE = 'active';

    const STATUS_PURCHASED = 'purchased';

    const STATUS_LOCKED = 'locked';

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $title;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $description;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $brand;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $shape;

    /**
     * @Column(type="datetime")
     */
    private $purchasedAt;

    /**
     * @Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Column(type="integer", nullable=false)
     * @var int
     */
    private $guarantee = 1;

    /**
     * @Column(type="integer", nullable=false)
     * @var int
     */
    private $price;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $type;

    /**
     * @ManyToOne(targetEntity="Category", inversedBy="advert")
     */
    private $category;

    /**
     * @ManyToOne(targetEntity="ExpeditionType", inversedBy="advert")
     */
    private $expeditionType;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $views = 0;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="advert")
     */
    private $user;

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
     * @return Advert
     */
    public function setId(int $id): Advert
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Advert
     */
    public function setTitle(string $title): Advert
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return Advert
     */
    public function setBrand(string $brand): Advert
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return string
     */
    public function getShape(): string
    {
        return $this->shape;
    }

    /**
     * @param string $shape
     * @return Advert
     */
    public function setShape(string $shape): Advert
    {
        $this->shape = $shape;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPurchasedAt()
    {
        return $this->purchasedAt;
    }

    /**
     * @param mixed $purchasedAt
     * @return Advert
     */
    public function setPurchasedAt($purchasedAt)
    {
        $this->purchasedAt = $purchasedAt;
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
     * @return Advert
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isGuarantee(): bool
    {
        return $this->guarantee;
    }

    /**
     * @param bool $guarantee
     * @return Advert
     */
    public function setGuarantee(?bool $guarantee): Advert
    {
        $this->guarantee = $guarantee;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Advert
     */
    public function setPrice(int $price): Advert
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Advert
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     * @return Advert
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpeditionType()
    {
        return $this->expeditionType;
    }

    /**
     * @param mixed $expeditionType
     * @return Advert
     */
    public function setExpeditionType($expeditionType)
    {
        $this->expeditionType = $expeditionType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Advert
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Advert
     */
    public function setDescription(string $description): Advert
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @param int $views
     * @return Advert
     */
    public function setViews(int $views): Advert
    {
        $this->views = $views;
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
     * @return Advert
     */
    public function setStatus(string $status): Advert
    {
        $this->status = $status;
        return $this;
    }

    public function getAdvertPictures(): array
    {
        $service = new Services();
        return $service->getRepository('picture')->findBy(['advert' => $this]);
    }

    public function getLinkFirstPictures(): string
    {
        $pictures = $this->getAdvertPictures();
        return PATH . '/' . UPLOAD_PATH . $this->getUser()->getId() . '/' . $pictures[0]->getName();
    }

    public function isActive(): bool
    {
        return ($this->status === self::STATUS_ACTIVE) ? true : false;
    }
}
