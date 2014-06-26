<?php

class userToRole extends \Phalcon\Mvc\Model
{
    public $id;

    public $user_id;

    public $role_id;

    public function getSource()
    {
        return "user_to_role";
    }


    public function initialize()
    {
        $this->belongsTo("user_id", "users", "id");
        $this->belongsTo("role_id", "usersRole", "id");
    }

}