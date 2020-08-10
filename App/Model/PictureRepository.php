<?php

namespace App\Model;

use App\Entity\Picture;

class PictureRepository extends Repository
{
    public function rotate(Picture $picture, int $degrees): void
    {
        $fileName = $picture->getRelLink();
        $source = imagecreatefrompng($fileName);
        $rotate = imagerotate($source, $degrees*-1, 0);
        imagepng($rotate, $fileName);
    }

    public function delete(Picture $picture): void
    {
        unlink($picture->getRelLink());
        $this->entityManager->getDoctrine()->remove($picture);
        $this->entityManager->getDoctrine()->flush();
    }
}
