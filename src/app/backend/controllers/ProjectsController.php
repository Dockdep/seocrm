<?php
/**
 * Created by PhpStorm.
 * User: Vitaliy
 * Date: 12.06.14
 * Time: 12:02
 */

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class ProjectsController extends \Phalcon\Mvc\Controller
{
    public function indexAction()
    {
        $data = \projects::find(array("order" => 'id'));
        $this->view->setVars([
            'data' => $data,
        ]);
    }

    public function addAction()
    {
        if( $this->request->isPost() )
        {
            $project['name']           = $this->request->getPost('name', 'string');
            $project['url']           = $this->request->getPost('url', 'string');
            $project['contacts']           = $this->request->getPost('contacts', 'string');
            $project['status']           = $this->request->getPost('status');
            if($this->request->getPost('id')) {
               $id =  $this->request->getPost('id');
               $model = \projects::findFirst("id = '$id'");
               $model->save($project);
            } else {
                $model = new \projects;
                $model->save($project);
            }
            return $this->response->redirect('project_index');
        }
        $status = \projectsStatus::find();
        $this->view->setVars([
            'status' => $status
        ]);
    }

    public function deleteAction()
    {
        $id = $this->request->get('id');
        $model = \projects::findFirst("id = '$id'");
        if($model instanceof \projects) {
            $model->userToProjects->delete();
            $model->delete();
            return $this->response->redirect('project_index');
        } else {
            echo "Данный проект не найден";
        }

    }

    public function editAction()
    {
        $id = $this->request->get('id');
        $data = \projects::findFirst("id = '$id'");
        $status = \projectsStatus::find();
        $this->view->setVars([
            'data' => $data,
            'status' => $status
        ]);
    }

    public function sortAction()
    {
        $sort = $this->request->getPost('data', 'string', NULL );
        $data = \projects::find(array("order" => $sort));
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
        $this->view->setVars([
            "data" =>$data
        ]);
    }

    public function checkAction() {
        $data = $this->request->getPost('data');
        $data = json_decode($data);
        if(isset($data->id)) {
            $model = \projects::findFirst(array("$data->name= '$data->value' AND id = '$data->id'"));
            if($model instanceof \projects) {
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

        $model = \projects::findFirst("{$data->name}= '{$data->value}'");

        if($model instanceof \projects) {
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