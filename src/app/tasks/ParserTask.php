<?php

class ParserTask extends \Phalcon\CLI\Task
{

    public function parsAction() {
        $model = new \rdsServices();
        $model->name = 'Whois';
        $model->date = date('Y-m-d H:i:s');
        $model->status = '0';
        $model->save();
    }

}