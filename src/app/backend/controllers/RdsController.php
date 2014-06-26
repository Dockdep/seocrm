<?php
/**
 * Created by PhpStorm.
 * User: Vitaliy
 * Date: 12.06.14
 * Time: 12:02
 */

namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class RdsController extends \Phalcon\Mvc\Controller
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