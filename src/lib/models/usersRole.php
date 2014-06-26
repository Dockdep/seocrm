<?php


class usersRole extends \Phalcon\Mvc\Model
{
    public function getSource()
    {
        return "users_role";
    }

    public function initialize()
    {
        $this->hasMany("id", "userToRole", "role_id");
    }
}