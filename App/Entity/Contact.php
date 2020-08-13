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
     * @Column(type="string", nullable=true)
     * @var string
     */
    private $address2;

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
     * @ManyToOne(targetEntity="Country", inversedBy="contact")
     * @JoinColumn(name="country_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $country;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $phoneNumber;

    /**
     * @ManyToOne(targetEntity="User", fetch="EAGER")
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
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     * @return Contact
     */
    public function setCountry(Country $country): Contact
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

    /**
     * @return string
     */
    public function getAddress2(): string
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     * @return Contact
     */
    public function setAddress2(string $address2): Contact
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @return int
     */
    public function getPhoneNumber(): int
    {
        return $this->phoneNumber;
    }

    /**
     * @param int $phoneNumber
     * @return Contact
     */
    public function setPhoneNumber(int $phoneNumber): Contact
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }
}
