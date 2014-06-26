<?php
namespace controllers;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

class ParserController extends \Phalcon\Mvc\Controller
{

    function indexAction() {
        $this->view->setVars([

        ]);
    }

    function parsAction() {
        $name           = $this->request->getPost('name', 'string');
        $site         = $this->request->getPost('site', 'string');
        $result = $this->rds->echosessionRds( $name, $site);
        $this->view->disableLevel(\Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT);
        $this->view->setVars([
            'result' => $result
        ]);
    }
}