<?php


class users extends \Phalcon\Mvc\Model
{
    public $id;

    public $name;

    public $email;

    public $password;

    public $status;

    public function initialize()
    {
        $this->hasMany("id", "userToProjects", "user_id");
        $this->hasMany("id", "userToRole", "user_id");
    }

    public function checkRole($field)
    {
        $test = \userToRole::findFirst(array("user_id = '$this->id' AND role_id = '$field->id'"));
        if($test instanceof \userToRole){
            return true;
        } else {
            return false;
        }
    }

    public function checkProject($field)
    {
        $test = \userToProjects::findFirst(array("user_id = '$this->id' AND project_id = '$field->id'"));
        if($test instanceof \userToProjects){
            return true;
        } else {
            return false;
        }

    }
}