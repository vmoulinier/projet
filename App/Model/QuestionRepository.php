<?php

namespace App\Model;

use App\Entity\Advert;
use App\Entity\Question;
use App\Entity\User;

class QuestionRepository extends Repository
{
    public function addQuestion(string $message, Advert $advert, User $user): void
    {
        $question = new Question();
        $question->setMessage($message);
        $question->setCreatedAt(new \DateTime());
        $question->setAdvert($advert);
        $question->setUser($user);
        $this->entityManager->getDoctrine()->merge($question);
        $this->entityManager->getDoctrine()->flush();
    }

}