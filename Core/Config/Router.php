<?php

namespace Core\Config;
require_once 'Core/Config/env.php';
require_once 'vendor/autoload.php';

class Router {

    private $router;

    public function __construct()
    {
        $this->router = new \AltoRouter();
        $this->routing();
        $this->targets();
    }

    public function routing()
    {
        //home
        $this->router->map('GET', '/'.PROJECT_NAME.'/', 'home/index', 'index');
        $this->router->map('GET', '/'.PROJECT_NAME.'/index', 'home/index', 'home_index');
        $this->router->map('GET', '/'.PROJECT_NAME.'/lang/[i:id]', 'home/lang', 'home_lang');
        $this->router->map('GET', '/'.PROJECT_NAME.'/contact', 'home/contact', 'home_contact');
        $this->router->map('POST', '/'.PROJECT_NAME.'/contact', 'home/contact', 'home_contact_post');
        $this->router->map('GET', '/'.PROJECT_NAME.'/about', 'home/about', 'home_about');
        $this->router->map('GET', '/'.PROJECT_NAME.'/terms', 'home/terms', 'home_terms');

        //user
        $this->router->map('GET', '/'.PROJECT_NAME.'/register', 'user/register', 'user_register');
        $this->router->map('POST', '/'.PROJECT_NAME.'/register', 'user/register', 'user_register_post');
        $this->router->map('GET', '/'.PROJECT_NAME.'/login/[a:fb]?', 'user/login', 'user_login');
        $this->router->map('POST', '/'.PROJECT_NAME.'/login/[a:fb]?', 'user/login', 'user_login_post');
        $this->router->map('GET', '/'.PROJECT_NAME.'/logout', 'user/logout', 'user_logout');
        $this->router->map('GET', '/'.PROJECT_NAME.'/loginfb/[a:fb]?', 'user/loginfb', 'user_loginfb');
        $this->router->map('GET', '/'.PROJECT_NAME.'/profil', 'user/profil', 'user_profil');
        $this->router->map('GET', '/'.PROJECT_NAME.'/user_adverts', 'user/adverts', 'user_adverts');
        $this->router->map('POST', '/'.PROJECT_NAME.'/user_adverts', 'user/adverts', 'user_adverts_post');
        $this->router->map('GET', '/'.PROJECT_NAME.'/bookmarks', 'user/bookmarks', 'user_bookmarks');
        $this->router->map('GET', '/'.PROJECT_NAME.'/user_transactions', 'user/transactions', 'user_transactions');
        $this->router->map('POST', '/'.PROJECT_NAME.'/user_transactions', 'user/transactions', 'user_transactions_post');
        $this->router->map('GET', '/'.PROJECT_NAME.'/invoice/[i:id]', 'user/invoice', 'user_invoice');
        $this->router->map('GET', '/'.PROJECT_NAME.'/edit_profil', 'user/edit', 'edit_profil');
        $this->router->map('POST', '/'.PROJECT_NAME.'/edit_profil', 'user/edit', 'edit_profil_post');

        //admin
        $this->router->map('GET', '/'.PROJECT_NAME.'/admin', 'admin/index', 'admin_index');
        $this->router->map('GET', '/'.PROJECT_NAME.'/admin/translations', 'admin/translations', 'admin_translations');
        $this->router->map('POST', '/'.PROJECT_NAME.'/admin/translations', 'admin/translations', 'admin_translations_post');
        $this->router->map('GET', '/'.PROJECT_NAME.'/admin/users', 'admin/users', 'admin_users');
        $this->router->map('POST', '/'.PROJECT_NAME.'/admin/users', 'admin/users', 'admin_users_post');
        $this->router->map('GET', '/'.PROJECT_NAME.'/admin/invoices', 'admin/invoices', 'admin_invoices');
        $this->router->map('GET', '/'.PROJECT_NAME.'/admin/relog', 'admin/relog', 'admin_relog');

        //advert
        $this->router->map('GET', '/'.PROJECT_NAME.'/adverts', 'advert/index', 'advert_index');
        $this->router->map('POST', '/'.PROJECT_NAME.'/adverts', 'advert/index', 'advert_index_post');
        $this->router->map('GET', '/'.PROJECT_NAME.'/advert/[i:id]', 'advert/viewadvert', 'advert_view');
        $this->router->map('POST', '/'.PROJECT_NAME.'/advert/[i:id]', 'advert/viewadvert', 'advert_view_post');
        $this->router->map('GET', '/'.PROJECT_NAME.'/create_advert', 'advert/create', 'create_advert');
        $this->router->map('POST', '/'.PROJECT_NAME.'/create_advert', 'advert/create', 'create_advert_post');
        $this->router->map('GET', '/'.PROJECT_NAME.'/edit_advert/[i:id]', 'advert/edit', 'edit_advert');
        $this->router->map('POST', '/'.PROJECT_NAME.'/edit_advert/[i:id]', 'advert/edit', 'edit_advert_post');
        $this->router->map('POST', '/'.PROJECT_NAME.'/add_bookmark', 'advert/addbookmark', 'add_bookmark_post');

        //transaction
        $this->router->map('POST', '/'.PROJECT_NAME.'/creation', 'transaction/creation', 'transaction_creation_post');
        $this->router->map('POST', '/'.PROJECT_NAME.'/validation', 'transaction/validation', 'transaction_validation_post');
        $this->router->map('POST', '/'.PROJECT_NAME.'/process', 'transaction/process', 'transaction_process_post');
        $this->router->map('GET', '/'.PROJECT_NAME.'/summary/[a:id]?', 'transaction/summary', 'transaction_summary_paypal');
    }

    public function targets()
    {
        $target = ['error', 'error'];
        $match = $this->router->match();

        if ($match) {
            $target = explode('/', $match['target']);
        }

        $controller = '\App\Controller\\' . ucfirst($target[0]) . 'Controller';
        $action = $target[1];

        $controller = new $controller($this->router);
        $params = $match['params'] ?? [];
        $controller->$action($params);
    }
}
