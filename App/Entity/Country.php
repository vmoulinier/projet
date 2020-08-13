<?php


namespace App\Entity;

/**
 * @Entity @Table(name="country")
 */
class Country
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
    private $label;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $code;

    /**
     * @ManyToOne(targetEntity="Continent", inversedBy="country")
     * @JoinColumn(name="continent_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $continent;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Country
     */
    public function setId(int $id): Country
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Country
     */
    public function setLabel(string $label): Country
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Country
     */
    public function setCode(string $code): Country
    {
        $this->code = $code;
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
     * @return Country
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;
        return $this;
    }
}
