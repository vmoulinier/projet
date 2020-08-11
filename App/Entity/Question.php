<?php


namespace App\Entity;

use Core\Services\Services;

/**
 * @Entity @Table(name="question")
 */
class Question
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
    private $message;

    /**
     * @Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $validate = 0;

    /**
     * @ManyToOne(targetEntity="Advert", inversedBy="question")
     * @JoinColumn(name="advert_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $advert;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="question")
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
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
     * @return Question
     */
    public function setId(int $id): Question
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Question
     */
    public function setMessage(string $message): Question
    {
        $this->message = $message;
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
     * @return Question
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getValidate(): int
    {
        return $this->validate;
    }

    /**
     * @param int $validate
     * @return Question
     */
    public function setValidate(int $validate): Question
    {
        $this->validate = $validate;
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
     * @return Question
     */
    public function setAdvert($advert)
    {
        $this->advert = $advert;
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
     * @return Question
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getAnswers()
    {
        $service = new Services();
        return $service->getRepository('answer')->findBy(['question'=> $this]);
    }
}