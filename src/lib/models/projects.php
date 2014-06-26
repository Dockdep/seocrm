<?php


class projects extends \Phalcon\Mvc\Model
{
    public $id;

    public $name;

    public $url;

    public $contacts;

    public $status;

    public function initialize()
    {
        $this->hasMany("id", "userToProjects", "project_id");
        $this->hasMany("id", "seoProjectsRequest", "site_id");
    }
}