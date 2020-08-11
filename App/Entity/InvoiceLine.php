<?php


namespace App\Entity;

/**
 * @Entity @Table(name="invoice_line")
 */
class InvoiceLine
{

    /**
     * @Id @GeneratedValue @Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Invoice", inversedBy="invoice_line")
     * @JoinColumn(name="invoice_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $invoice;

    /**
     * @Column(type="string", nullable=false)
     * @var string
     */
    private $label;

    /**
     * @Column(type="integer", nullable=false)
     * @var int
     */
    private $unitAmount;

    /**
     * @Column(type="integer", nullable=false)
     * @var int
     */
    private $quantity;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return InvoiceLine
     */
    public function setId(int $id): InvoiceLine
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @param mixed $invoice
     * @return InvoiceLine
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
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
     * @return InvoiceLine
     */
    public function setLabel(string $label): InvoiceLine
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnitAmount(): int
    {
        return $this->unitAmount;
    }

    /**
     * @param int $unitAmount
     * @return InvoiceLine
     */
    public function setUnitAmount(int $unitAmount): InvoiceLine
    {
        $this->unitAmount = $unitAmount;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return InvoiceLine
     */
    public function setQuantity(int $quantity): InvoiceLine
    {
        $this->quantity = $quantity;
        return $this;
    }
}
