<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of dossier
 *
 * @author bouraima joezer
 */
use Phalcon\Mvc\Model;

class service extends Model
{

    private $idserv;
    private $description;
    private $keyword;

    
    /*
     * declaration des getters
     */
    function getIdserv()
    {
        return $this->idserv;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getKeyword()
    {
        return $this->keyword;
    }

    
    /*
     * declaration des setters
     */
    
    function setIdserv($idserv)
    {
        $this->idserv = $idserv;
    }

    function setDescription($description)
    {
        $this->description = $description;
    }

    function setKeyword($keyword)
    {
        $this->keyword = $keyword;
    }

    public function initialize()
    {
        /*
         * initialisation de la table
         */
        $this->setSource("service");
        /*
         * relation avec la table fichier
         */
        $this->hasMany("idserv", "fichier", "idserv");
        /*
         * relation avec la table dossier
         */
        $this->hasMany("idserv", "dossier", "idserv");
    }
}
