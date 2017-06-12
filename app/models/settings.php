<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of settings
 *
 * @author karth solution
 */
use Phalcon\Mvc\Model;

class settings extends Model
{

    private $id;
    private $data;
    private $module;
    private $logo;
    private $icone;
    private $structure;
    
    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    
    function getData()
    {
        return $this->data;
    }

    function getModule()
    {
        return $this->module;
    }

    function getLogo()
    {
        return $this->logo;
    }

    function getIcone()
    {
        return $this->icone;
    }

    function getStructure()
    {
        return $this->structure;
    }

    function setData($data)
    {
        $this->data = $data;
    }

    function setModule($module)
    {
        $this->module = $module;
    }

    function setLogo($logo)
    {
        $this->logo = $logo;
    }

    function setIcone($icone)
    {
        $this->icone = $icone;
    }

    function setStructure($structure)
    {
        $this->structure = $structure;
    }

    public function initialize()
    {
        $this->setSource("settings");
    }
}
