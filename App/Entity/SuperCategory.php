<?php


namespace App\Entity;

/**
 * @Entity @Table(name="super_category")
 */
class SuperCategory
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
     * @return SuperCategory
     */
    public function setId(int $id): SuperCategory
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
     * @return SuperCategory
     */
    public function setLabel(string $label): SuperCategory
    {
        $this->label = $label;
        return $this;
    }
}