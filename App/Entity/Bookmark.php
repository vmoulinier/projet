<?php


namespace App\Entity;

/**
 * @Entity @Table(name="bookmark")
 */
class Bookmark
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="bookmark")
     * @JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="Advert", inversedBy="bookmark")
     * @JoinColumn(name="advert_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $advert;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Bookmark
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Bookmark
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * @return Bookmark
     */
    public function setAdvert($advert)
    {
        $this->advert = $advert;
        return $this;
    }
}