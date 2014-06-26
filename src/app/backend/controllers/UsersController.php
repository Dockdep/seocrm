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
    private $error = false;

    public function indexAction()
    {
        $data = \users::find(array("order" => 'id'));
        $this->view->setVars([
            'data' => $data,
        ]);
    }

    public function addAction()
    {
        if( $this->request->isPost() )
        {
            $user['name']           = $this->request->getPost('name', 'string');
            $user['email']          = $this->request->getPost('email', 'email');
            $user['password']       = $this->request->getPost('password', 'string');
            $user['confirm_password'] = $this->request->getPost('confirm_password', 'string');
            $user['status']         = $this->request->getPost('status');
            $role                   = $this->request->getPost('role');
            $projects               = $this->request->getPost('projects');

            $check = \users::findFirst(array("email = '{$user['email']}'"));
            if($check instanceof \users) {
                echo "Такой e-mail уже существует";
                $this->error= true;
            }
            if($user['password'] != $user['confirm_password']) {
                echo "Неверно введен пароль";
                $this->error = true;
            } else {
                $user['password'] = $this->common->hashPasswd( $user['password'] );
            }

            $model = new \users;
            if(!$this->error) {
                $model->save($user);
                $user = \users::find(array("order" => 'id'))->getLast();
                foreach($role as $item) {
                    $model = new \userToRole;
                    $model->user_id = $user->id;
                    $model->role_id = $item;
                    $model->save();
                }
                foreach($projects as $project) {
                    $model = new \userToProjects;
                    $model->user_id = $user->id;
                    $model->project_id = $project;
                    $model->save();
                }
                return $this->response->redirect('user_index');
            }
        }
        $role = \usersRole::find();
        $status = \usersStatus::find();
        $projects = \projects::find(array("order" => 'id'));

        $this->view->setVars([
            'role' => $role,
            'status' => $status,
            'projects' => $projects
        ]);
    }

    public function updateAction()
    {
        $id = $this->request->get('id','int');
        if( $this->request->isPost('update') )
        {
            $user['name']         = $this->request->getPost('name', 'string');
            $user['email']        = $this->request->getPost('email', 'email');
            $user['status']       = $this->request->getPost('status', 'string');
            $role                 = $this->request->getPost('role');
            $projects             = $this->request->getPost('projects');
            $new_password         = $this->request->getPost('new_password', 'string');
            $new_password_r       = $this->request->getPost('new_password_r', 'string');


            $model = \users::findFirst(array("id = '$id'"));
            if(!$model instanceof \users) {
                echo "Ползователь не найден";
                $this->error= true;
            }

            if($model->email != $user['email']) {
                $check = \users::findFirst(array("email = '{$user['email']}'"));
                if($check instanceof \users) {
                    echo "Такой e-mail уже существует";
                    $this->error= true;
                }
            }

            if(!$this->error && !empty($new_password)){
                if($new_password != $new_password_r) {
                    $this->error= true;
                    echo "Неверно указан проверочный пароль";
                } else {
                    $user['password'] = $this->common->hashPasswd($new_password);
                }
            }

            if(!$this->error) {

                $model->save($user);
                $model->userToRole->delete();
                foreach($role as $item) {
                    $userToRole = new \userToRole;
                    $userToRole->user_id = $model->id;
                    $userToRole->role_id = $item;
                    $userToRole->save();
                }
                $model->userToProjects->delete();
                foreach($projects as $project) {
                    $userToProjects = new \userToProjects;
                    $userToProjects->user_id = $model->id;
                    $userToProjects->project_id = $project;
                    $userToProjects->save();
                }
                return $this->response->redirect('user_index');
            }

        }

        if(!$id) {
            echo "Не указан номер пользователя";
        } else {
            $data = \users::findFirst("id = '$id'");
            if($data instanceof \users) {
                $role = \usersRole::find();
                $status = \usersStatus::find();
                $projects = \projects::find(array("order" => 'id'));

                $this->view->setVars([
                    'role' => $role,
                    'status' => $status,
                    'projects' => $projects,
                    'data' => $data
                ]);
            }

        }
    }

    public function deleteAction()
    {
        $id = $this->request->get('id');
        $model = \users::findFirst("id = '$id'");
        if($model instanceof \users) {
            $model->userToRole->delete();
            $model->userToProjects->delete();
            $model->delete();
            return $this->response->redirect('user_index');
        } else {
            echo "Данный пользователь не найден";
        }

    }

    public function editAction()
    {
        $id = $this->request->get('id');
        $data = \users::findFirst("id = '$id'");
        $this->view->setVars([
            'data' => $data,
        ]);
    }

    public function sortAction()
    {
        $sort = $this->request->getPost('data', 'string', NULL );
        $data = \users::find(array("order" => $sort));
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
        $this->view->setVars([
            "data" =>$data
        ]);
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