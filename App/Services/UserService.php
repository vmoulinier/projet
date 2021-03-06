<?php


namespace App\Services;

use App\Entity\Country;
use App\Entity\User;

class UserService extends Service
{

    public function register(string $email, string $password, string $password_verif, string $name, string $firstname, ?Country $country, ?string $zip, string $facebook = null): array
    {
        $users = $this->getRepository('user')->findOneBy(['email' => $email]);
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
                $user->setCountry($country);
                $user->setPostCode($zip);
                if (ENV === 'dev') {
                    $user->setType('ROLE_ADMIN');
                }
                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();
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
        $user = $this->getRepository('user')->findOneBy(['email' =>$email, 'password' =>sha1($password)]);
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

    public function loginAdmin(int $id): void
    {
        $_SESSION['edit_admin_id'] = $_SESSION['user_id'];

        $userRepo =  $this->getRepository('user');
        $user = $userRepo->find($id);

        if($user->getType() === 'ROLE_ADMIN'){
            $this->saveSessionAdmin($user->getId(), $user->getType());
            return;
        }

        $this->saveSession($user->getId());
    }

    public function edit(string $name, string $firstname, string $zip, Country $country, User $user): void
    {
        $user->setName($name);
        $user->setFirstname($firstname);
        $user->setPostCode($zip);
        $user->setCountry($country);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
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
}