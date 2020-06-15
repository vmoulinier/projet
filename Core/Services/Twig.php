<?php

namespace Core\Services;

use App\Entity\Advert;
use Core\Config\Config;

class Twig extends Config
{

    public function getCurrentUser()
    {
        if(isset($_SESSION['user_id'])) {
            $id = $_SESSION['user_id'];
            return $this->entityManager->getRepository('App\Entity\User')->find($id);
        }
        return false;
    }

    public function postExist($exist, $else)
    {
        if (isset($_GET[$exist])) {
            return $_GET[$exist];
        }
        return $else;
    }

    public function isSelected($exist, $value)
    {
        if (isset($_GET[$exist])) {
            if ($_GET[$exist] == $value) {
                return 'selected';
            }
        }
        return false;
    }

    public function logged(): bool
    {
        if(isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    public function loggedAdmin(): bool
    {
        if(isset($_SESSION['user_id']) && isset($_SESSION['user_role_admin'])) {
            if($_SESSION['user_role_admin'] === 'ROLE_ADMIN') {
                return true;
            }
        }
        return false;
    }

    public function translation(string $name, array $params = []): string
    {
        $lang = DEFAULT_LANGAGE;

        if (isset($_SESSION['lang'])) {
            if ($_SESSION['lang'] === 'en') {
                $lang = 'en';
            } elseif ($_SESSION['lang'] === 'fr') {
                $lang = 'fr';
            }
        }

        $translation = $this->entityManager->getRepository('App\Entity\Translations')->findOneBy(['name' => $name]);
        if ($translation) {
            $method = 'get' . ucfirst($lang);
            if (method_exists($translation, $method)) {
                $str = $translation->$method();
                foreach ($params as $key => $param) {
                    $str = str_replace('%'.$key.'%', $param, $str);
                }
                return html_entity_decode($str);
            }
        }
        $str = ' ';
        foreach ($params as $key => $param) {
            $str .= '%' . $key . '% ';
        }
        return html_entity_decode($name . $str);
    }

    public function isMobile()
    {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    public function isBookmarked(Advert $advert)
    {
        return $this->entityManager->getRepository('App\Entity\Bookmark')->findOneBy(['user' => $this->getCurrentUser(), 'advert' => $advert]);
    }

    public function isNavActive($url)
    {
        $get = explode('/', array_key_first ($_GET))[0];

        if(isset($get) && $get === $url) {
            return 'active';
        }

        return '';
    }
}
