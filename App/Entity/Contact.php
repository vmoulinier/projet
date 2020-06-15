<?php


namespace App\Entity;

/**
 * @Entity @Table(name="contact")
 */
class Contact
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
    private $address;

    /**
     * @Column(type="integer", nullable=false)
     * @var integer
     */
    private $postCode;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $city;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $country;

    /**
     * @ManyToOne(targetEntity="User", cascade={"all"}, fetch="EAGER")
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
     * @return Contact
     */
    public function setId(int $id): Contact
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return Contact
     */
    public function setAddress(string $address): Contact
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return int
     */
    public function getPostCode(): int
    {
        return $this->postCode;
    }

    /**
     * @param int $postCode
     * @return Contact
     */
    public function setPostCode(int $postCode): Contact
    {
        $this->postCode = $postCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Contact
     */
    public function setCity(string $city): Contact
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Contact
     */
    public function setCountry(string $country): Contact
    {
        $this->country = $country;
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
     * @return Contact
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
}