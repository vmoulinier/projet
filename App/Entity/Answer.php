<?php


namespace App\Entity;

/**
 * @Entity @Table(name="answer")
 */
class Answer
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
    private $message;

    /**
     * @Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $validate = 0;

    /**
     * @ManyToOne(targetEntity="Question", inversedBy="answer")
     * @JoinColumn(name="question_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $question;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Answer
     */
    public function setId(int $id): Answer
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Answer
     */
    public function setMessage(string $message): Answer
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Answer
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getValidate(): int
    {
        return $this->validate;
    }

    /**
     * @param int $validate
     * @return Answer
     */
    public function setValidate(int $validate): Answer
    {
        $this->validate = $validate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     * @return Answer
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }
}