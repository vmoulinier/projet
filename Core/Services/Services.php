<?php

namespace Core\Services;

use App\Model\Repository;
use Core\Config\Config;
use Doctrine\ORM\EntityManager;
use Mailjet\Resources;

require_once 'Core/Config/Config.php';

class Services extends Config
{

    public function sendMail(string $to, string $subject, string $htmlPart): void
    {
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => MJ_FROM_EMAIL,
                        'Name' => MJ_FROM_NAME
                    ],
                    'To' => $to,
                    'Subject' => $subject,
                    'TextPart' => "",
                    'HTMLPart' => $htmlPart,
                    'CustomID' => ""
                ]
            ]
        ];
        $this->mailjet->post(Resources::$Email, ['body' => $body]);
    }

    public function getRepository($entity): Repository
    {
        if (class_exists('\App\Model\\' . ucfirst($entity) . 'Repository')) {
            $repository = '\App\Model\\' . ucfirst($entity) . 'Repository';
            return new $repository($this);
        }

        throw new \Error('repository not found');
    }

    public function getDoctrine(): EntityManager
    {
        return $this->entityManager;
    }

    public function getUrlLoginFacebook($scope): string
    {
        return $this->helper->getLoginUrl(PATH .'/loginfb/', $scope);
    }

    public function getProfilFacebook()
    {
        try {
            $accessToken = $this->helper->getAccessToken();
            $response = $this->fb->get('/me?fields=email,first_name,last_name,gender', $accessToken->getValue());
            return $response->getGraphUser();
        } catch (FacebookResponseException  $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
    }

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
}
