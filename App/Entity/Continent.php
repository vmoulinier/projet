<?php


namespace App\Entity;

/**
 * @Entity @Table(name="continent")
 */
class Continent
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Continent
     */
    public function setId(int $id): Continent
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
     * @return Continent
     */
    public function setLabel(string $label): Continent
    {
        $this->label = $label;
        return $this;
    }
}
