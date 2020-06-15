<?php


namespace App\Model;


use App\Entity\Answer;

class AnswerRepository extends Repository
{

    public function addAnswer(string $message, int $questionId)
    {
        $question = $this->getRepository('question')->find($questionId);
        $answer = new Answer();
        $answer->setCreatedAt(new \DateTime());
        $answer->setMessage($message);
        $answer->setQuestion($question);
        $this->entityManager->getDoctrine()->persist($answer);
        $this->entityManager->getDoctrine()->flush();
    }
}