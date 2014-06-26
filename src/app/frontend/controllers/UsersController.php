<?php
/**
 * Created by PhpStorm.
 * User: Vitaliy
 * Date: 12.06.14
 * Time: 12:02
 */

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class UsersController extends \Phalcon\Mvc\Controller
{
    public function registrationAction()
    {
        $error = false;
        $user['name']           = $this->request->getPost('name', 'string');
        $user['email']          = $this->request->getPost('email', 'email');
        $user['status']           = 'New User';
        $user['password']       = $this->request->getPost('password', 'string');
        $user['confirm_password'] = $this->request->getPost('confirm_password', 'string');
        $check = \users::findFirst(array("email = '{$user['email']}'"));
        if($check instanceof \users) {
            echo "Такой e-mail уже существует";
            $error = true;
        }
        if($user['password'] != $user['confirm_password']) {
            echo "Неверно введен пароль";
            $error = true;
        } else {
            $user['password'] = $this->common->hashPasswd( $user['password'] );
        }
        $model = new \users;
        if(!$error && $model->save($user)) {
            echo "Вы успешно зарегестрированны";
        } else {
            echo "Произошла ошибка регистрации";
        }
    }

    public function loginAction()
    {
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
            $Online = date('Y-m-d H:i:s');
            $model->last_online = $Online;
            $model->save();
            $this->session->set("user-name", $model->name);
            $this->session->set("user-status", $model->status);

        } else {
            echo "Пользователя с такими данными не существует";
        }
    }

    public function logoutAction()
    {
        $this->session->destroy();
        return $this->response->redirect('');
    }

    public function checkAction() {
        $data = $this->request->getPost('data');
        $data = json_decode($data);
        if(isset($data->id)) {
            $model = \users::findFirst(array("$data->name= '$data->value' AND id = '$data->id'"));
            if($model instanceof \users) {
                $result = array(
                    'errors' => false,
                    'message' => ""
                );
                $data = json_encode($result);
                $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
                echo $data;
                die();
            }
        }

        $model = \users::findFirst("{$data->name}= '{$data->value}'");

        if($model instanceof \users) {
            $result = array(
                'errors' => true,
                'message' => "$data->value уже занято"
            );
        } else {
            $result = array(
                'errors' => false,
                'message' => "$data->value свободно"
            );
        }
        $data = json_encode($result);
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
        echo $data;
    }
}