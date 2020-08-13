<?php


namespace App\Entity;

/**
 * @Entity @Table(name="expedition_taxes")
 */
class ExpeditionTaxes
{
    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Continent", inversedBy="expedition_taxes")
     * @JoinColumn(name="continent_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $continent;

    /**
     * @Column(type="integer", nullable=false)
     * @var integer
     */
    private $amount;

    /**
     * @ManyToOne(targetEntity="Advert", inversedBy="expedition_taxes")
     * @JoinColumn(name="advert_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $advert;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ExpeditionTaxes
     */
    public function setId(int $id): ExpeditionTaxes
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * @param mixed $continent
     * @return ExpeditionTaxes
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;
        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return ExpeditionTaxes
     */
    public function setAmount(int $amount): ExpeditionTaxes
    {
        $this->amount = $amount;
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
     * @return ExpeditionTaxes
     */
    public function setAdvert($advert)
    {
        $this->advert = $advert;
        return $this;
    }
}
