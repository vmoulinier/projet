<?php

namespace App\Services;

use App\Entity\Translations;

class TranslationsService extends Service
{
    public function updateTranslation(int $id, string $name, string $fr, string $en): void
    {
        $translation = $this->services->getRepository('translations')->find($id);
        $translation->setName(trim($name));
        $translation->setFr($fr);
        $translation->setEn($en);
        $this->services->getEntityManager()->persist($translation);
        $this->services->getEntityManager()->flush();
    }

    public function removeTranslation(int $id): void
    {
        $translation = $this->services->getRepository('translations')->find($id);
        $this->services->getEntityManager()->remove($translation);
        $this->services->getEntityManager()->flush();
    }

    public function addTranslation(string $name, string $fr, string $en): void
    {
        $translation = $this->services->getRepository('translations')->findBy(['name' => $name]);
        if(!$translation) {
            $translation = new Translations();
            $translation->setName(trim($name));
            $translation->setFr($fr);
            $translation->setEn($en);
            $this->services->getEntityManager()->persist($translation);
            $this->services->getEntityManager()->flush();
        }
    }
}
