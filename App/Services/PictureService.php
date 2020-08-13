<?php

namespace App\Services;

use App\Entity\Picture;

class PictureService extends Service
{

    public function processPictures(string $fileName): array
    {
        $arrayNames = [];
        $name = array_key_first($_FILES);
        if ($_FILES[$name]['error'][0] == 0) {
            $extensions = ['.png', '.jpg', '.jpeg', '.PNG', '.JPG', '.JPEG'];

            $dir = "Public/img/" . $fileName . "/";
            if (!is_dir($dir)) {
                $old = umask(0);
                mkdir($dir, 0777);
                chmod($dir, 0777);
                umask($old);
            }

            foreach ($_FILES[$name]['name'] as $key => $filename) {
                $file = $_FILES[$name]['tmp_name'][$key];
                $extension = strrchr($filename, '.');
                if (!in_array($extension, $extensions)) {
                    break;
                }

                $newFileName = uniqid() . '.png';
                move_uploaded_file($file, $dir . $newFileName);
                imagepng(imagecreatefromstring(file_get_contents($dir . $newFileName)), $dir . $newFileName);

                $arrayNames[] = $newFileName;
            }
        }

        return $arrayNames;
    }

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
        $this->entityManager->remove($picture);
        $this->entityManager->flush();
    }
}
