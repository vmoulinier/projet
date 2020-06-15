<?php


namespace App\Entity;

/**
 * @Entity @Table(name="category")
 */
class Category
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
    private $descriptionSeo;

    /**
     * @ManyToOne(targetEntity="SuperCategory", cascade={"all"}, fetch="EAGER")
     */
    private $superCategory;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Category
     */
    public function setId(int $id): Category
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
     * @return Category
     */
    public function setLabel(string $label): Category
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescriptionSeo(): string
    {
        return $this->descriptionSeo;
    }

    /**
     * @param string $descriptionSeo
     * @return Category
     */
    public function setDescriptionSeo(string $descriptionSeo): Category
    {
        $this->descriptionSeo = $descriptionSeo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuperCategory()
    {
        return $this->superCategory;
    }

    /**
     * @param mixed $superCategory
     * @return Category
     */
    public function setSuperCategory($superCategory)
    {
        $this->superCategory = $superCategory;
        return $this;
    }
}