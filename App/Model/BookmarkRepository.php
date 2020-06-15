<?php

namespace App\Model;

use App\Entity\Advert;
use App\Entity\Bookmark;
use App\Entity\User;

class BookmarkRepository extends Repository
{
    public function addBookmark(Advert $advert, User $user): void
    {
        $bookmark = $this->findOneBy(['advert' => $advert, 'user' => $user]);

        if ($bookmark) {
            $this->entityManager->getDoctrine()->remove($bookmark);
        } else {
            $bookmark = new Bookmark();
            $bookmark->setUser($user);
            $bookmark->setAdvert($advert);
            $this->entityManager->getDoctrine()->merge($bookmark);
        }

        $this->entityManager->getDoctrine()->flush();
    }
}
