<?php
/**
 * Created by PhpStorm.
 * User: Vitaliy
 * Date: 12.06.14
 * Time: 12:02
 */

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class PageController extends \Phalcon\Mvc\Controller
{
    function indexAction()
    {
       $data = \users::findFirst("id = '10'");
        $test = \userToRole::findFirst("user_id = '10'");
        $this->view->setVars([
            'data' => $data,
            'test' => $test
        ]);
    }

    function loginAction()
    {
        if($this->request->getPost()) {
            $email          = $this->request->getPost('email', 'email');
            $password       = $this->request->getPost('password', 'string');
            $password       = $this->common->hashPasswd( $password );
            $model = \users::findFirst(array(
                "email = '$email'",
                "password => '$password'",
            ));
            if($model instanceof \users) {
                $this->session->set("user-name", $model->name);
                $this->session->set("user-status", $model->status);
                return $this->response->redirect('index_page');
            } else {
                echo "Пользователя с такими данными не существует";
            }
        }


        $this->view->setVars([

        ]);

    }

    function logoutAction()
    {
        $this->session->destroy();
        return $this->response->redirect('login_page');
    }
}