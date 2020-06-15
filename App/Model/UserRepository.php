<?php

namespace App\Model;

use App\Entity\User;

class UserRepository extends Repository
{
    public function register(string $email, string $password, string $password_verif, string $name, string $firstname, string $facebook = null): array
    {
        $users = $this->findOneBy(['email' => $email]);
        $error = [];

        if(!$users) {
            if($password === $password_verif) {
                $password = sha1($password);
                $user = new User();
                $user->setName($name);
                $user->setFirstName($firstname);
                $user->setEmail($email);
                $user->setPassword($password);
                $user->setFacebookId($facebook);
                if (ENV === 'dev') {
                    $user->setType('ROLE_ADMIN');
                }
                $this->entityManager->getDoctrine()->persist($user);
                $this->entityManager->getDoctrine()->flush();
                $error[0] = "account.register.success";
                $error[1] = "success";
                $error[2] = true;
            } else {
                $error[0] = "account.register.diff.pass";
                $error[1] = "danger";
                $error[2] = false;
            }
        } else {
            $error[0] = "account.register.mail.exist";
            $error[1] = "danger";
            $error[2] = false;
        }

        return $error;
    }

    public function login(string $email, string $password, bool $facebook = false): bool
    {
        $user = $this->findOneBy(['email' =>$email, 'password' =>sha1($password)]);
        if($user) {
            if ($user->getFacebookId() && !$facebook) {
                return false;
            }
            if($user->getType() === 'ROLE_ADMIN'){
                $this->saveSessionAdmin($user->getId(), $user->getType());
                return true;
            }
            $this->saveSession($user->getId());
            return true;
        }
        return false;
    }

    public function loginfb(string $email, string $facebookId): bool
    {
        $user = $this->findOneBy(['email' =>$email, 'facebook_id' => $facebookId]);
        if($user) {
            if($user->getType() === 'ROLE_ADMIN'){
                $this->saveSessionAdmin($user->getId(), $user->getType());
                return true;
            }
            $this->saveSession($user->getId());
            return true;
        }
        return false;
    }

    public function search(string $name, string $email, int $id): array
    {
        $queryBuilder = $this->entityRepository->createQueryBuilder('u');

        return $queryBuilder->select('u')
            ->where($queryBuilder->expr()->orX(
                $queryBuilder->expr()->eq('u.name', ':name'),
                $queryBuilder->expr()->eq('u.email', ':email'),
                $queryBuilder->expr()->eq('u.id', ':id')
            ))
            ->setParameter('name', $name)
            ->setParameter('email', $email)
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function islogged(): bool
    {
        if(isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    public function isloggedAdmin(): bool
    {
        if(isset($_SESSION['user_id']) and isset($_SESSION['user_role_admin']) === 'ROLE_ADMIN') {
            return true;
        }
        return false;
    }

    public function saveSession(int $id)
    {
        $_SESSION['user_id'] = $id;
    }

    public function saveSessionAdmin(int $id, string $role)
    {
        $_SESSION['user_id'] = $id;
        $_SESSION['user_role_admin'] = $role;
    }

    public function findAllPostcodeUsers()
    {
        $queryBuilder = $this->entityRepository->createQueryBuilder('u');

        return $queryBuilder->select('u')
            ->groupBy('u.postCode')
            ->getQuery()
            ->getResult();
    }
}
