<?php
namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class ParserController extends \Phalcon\Mvc\Controller
{

    function indexAction() {
        $model = \rdsServices::find(array("order" => 'id'));
        $this->view->setVars([
            'data' => $model,
        ]);
    }

    function addAction() {

    }

    function deleteAction() {

    }

    function updateAction() {

    }
}