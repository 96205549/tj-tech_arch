<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of couriel
 *
 * @author karth solution
 */
use Phalcon\Mvc\Model;

class couriel extends Model
{

    private $idcouriel;
    private $message;
    private $iddos;
    private $type;
    private $iduser;
    private $actif;
    private $lu;
    
   

        function getType()
    {
        return $this->type;
    }

    function setType($type)
    {
        $this->type = $type;
    }

        function getIdcouriel()
    {
        return $this->idcouriel;
    }

    function getMessage()
    {
        return $this->message;
    }

    function getIddos()
    {
        return $this->iddos;
    }

   

    function getIduser()
    {
        return $this->iduser;
    }

    function getActif()
    {
        return $this->actif;
    }
     function getLu()
    {
        return $this->lu;
    }

    function setIdcouriel($idcouriel)
    {
        $this->idcouriel = $idcouriel;
    }

    function setMessage($message)
    {
        $this->message = $message;
    }

    function setIddos($iddos)
    {
        $this->iddos = $iddos;
    }

   
    function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    function setActif($actif)
    {
        $this->actif = $actif;
    }
    
    function setLu($lu)
    {
        $this->lu = $lu;
    }

    public function initialize()
    {
        $this->setSource("couriel");
        /*
         * relation entre la ta
         */
        $this->belongsTo("iddos", "dossier", "iddos");
        /*
         * relation avec la table fichier
         */
        $this->belongsTo("idfile", "fichier", "idfile");
        /*
         * relation avec la table user 
         */
        $this->belongsTo("iduser", "user", "iduser");
    }
}
