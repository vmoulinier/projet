<?php


namespace App\Entity;

/**
 * @Entity @Table(name="expedition_type")
 */
class ExpeditionType
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
    private $conditions;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return ExpeditionType
     */
    public function setId(int $id): ExpeditionType
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
     * @return ExpeditionType
     */
    public function setLabel(string $label): ExpeditionType
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getConditions(): string
    {
        return $this->conditions;
    }

    /**
     * @param string $conditions
     * @return ExpeditionType
     */
    public function setConditions(string $conditions): ExpeditionType
    {
        $this->conditions = $conditions;
        return $this;
    }
}