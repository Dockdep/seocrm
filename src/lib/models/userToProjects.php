<?php

class userToProjects extends \Phalcon\Mvc\Model
{
    public $id;

    public $user_id;

    public $project_id;

    public function getSource()
    {
        return "user_to_projects";
    }


    public function initialize()
    {
        $this->belongsTo("user_id", "users", "id");
        $this->belongsTo("project_id", "projects", "id");
    }

}