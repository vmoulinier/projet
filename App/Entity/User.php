<?php

namespace App\Entity;

use Core\Services\Services;

/**
 * @Entity @Table(name="user")
 */
class User
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @Column(type="string")
     * @var string
     */
    private $name;

    /**
     * @Column(type="string")
     * @var string
     */
    private $firstname;

    /**
     * @Column(type="string")
     * @var string
     */
    private $password;

    /**
     * @Column(type="string", options={"default" : "ROLE_USER"})
     * @var string
     */
    private $type = "ROLE_USER";

    /**
     * @Column(type="string")
     * @var string
     */
    private $email;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     */
    private $postCode;

    /**
     * @ManyToOne(targetEntity="Country", inversedBy="user")
     */
    private $country;

    /**
     * @Column(type="string", nullable=true)
     * @var string
     */
    private $facebook_id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
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
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
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
     * @return User
     */
    public function setType(string $type): User
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    /**
     * @param string $postCode
     * @return User
     */
    public function setPostCode(?string $postCode): User
    {
        $this->postCode = $postCode;
        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     * @return User
     */
    public function setCountry(?Country $country): User
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookId(): ?string
    {
        return $this->facebook_id;
    }

    /**
     * @param string $facebook_id
     * @return User
     */
    public function setFacebookId(?string $facebook_id): User
    {
        $this->facebook_id = $facebook_id;
        return $this;
    }

    public function isCompleted(): bool
    {
        if (!$this->getCountry() || !$this->getPostCode()) {
            return  false;
        }

        return true;
    }

    public function getRating()
    {
        $rate = 0;
        $service = new Services();
        $transactions = $service->getRepository('transaction')->findBy(['seller' => $this]);
        foreach($transactions as $transaction) {
            if ($transaction->getRate()) {
                $rate += $transaction->getRate()->getRate();
            }
        }

        if ($rate) {
            return $rate/count($transactions);
        }

        return null;
    }

    public function getTransactionRates(): ?array
    {
        $transactionRates = [];
        $service = new Services();
        $transactions = $service->getRepository('transaction')->findBy(['seller' => $this]);
        foreach($transactions as $transaction) {
            if ($transaction->getRate()) {
                $transactionRates[] = $transaction;
            }
        }

        return $transactionRates;
    }

    public function isAdmin(): bool
    {
        return $this->getType() === 'ROLE_ADMIN';
    }
}
