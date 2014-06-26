<?php

class seoProjectsRequest extends \Phalcon\Mvc\Model
{

    public function getSource()
    {
        return "seo_projects_request";
    }


    public function initialize()
    {
        $this->belongsTo("site_id", "projects", "id");
    }

}