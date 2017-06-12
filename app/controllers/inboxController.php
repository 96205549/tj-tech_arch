<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of inboxController
 *
 * @author karth solution
 */
use Phalcon\Mvc\Controller;

class inboxController extends Controller
{

    public function initialize()
    {
        $this->view->setMainView('board');
        $this->tag->setTitle('Bienvenue');
        $corbeilles = corbeille:: find(['order' => ' idcorb DESC']);
        $this->view->corbeilles = ($corbeilles) ? $corbeilles : [];
        //parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }
    }

    public function docAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }

        $val = $this->request->get("id");
        $valdoc = explode("_", $val);
       // die(print_r($valdoc[0]));
        $iddoc = $decode = base64_decode($valdoc[0]);
        $idcouriel = $decode = base64_decode($valdoc[1]);
        if (!(int) $iddoc) {
            return $this->response->redirect("page error");
        }
        if (!(int) $idcouriel) {
            return $this->response->redirect("page error");
        }
        //die(print_r($iddoc."/".$idcouriel));
        $couriel = couriel::findFirst(["idcouriel=?0", "bind" => [$idcouriel]]);

        $folder = dossier::findFirst(["iddos=?0", "bind" => [$iddoc]]);
        //die(print_r($folder));
        if ($couriel == true):
            $couriel->lu = "1";
            $couriel->update();
        endif;
        $this->view->folder = ($folder) ? $folder : [];
    }

    public function openAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }
        $val = $this->request->get("id");

    
        $iddoc = $decode = base64_decode($val);
        
      
        if (!(int) $iddoc){
            return $this->response->redirect("page error");
        }

        $docs = dossier::find(["parent=:p:", "bind" => ['p' => $iddoc]]);
        $docFiles = fichier::find(["iddos=:d:", "bind" => ['d' => $iddoc]]);

        // die(print_r($docFiles));
        $this->view->docs = ($docs) ? $docs : [];
        $this->view->docFiles = ($docFiles) ? $docFiles : [];
    }

    public function fileAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }
        $val = $this->request->get("id");

         $valfile = explode("_", $val);
       // die(print_r($valdoc[0]));
        $idfile = $decode = base64_decode($valfile[0]);
        $idcouriel = $decode = base64_decode($valfile[1]);
        if (!(int) $idfile) {
            return $this->response->redirect("page error");
        }
        if (!(int) $idcouriel) {
            return $this->response->redirect("page error");
        }
          $couriel = couriel::findFirst(["idcouriel=?0", "bind" => [$idcouriel]]);
        
        $fichier = fichier::findFirst(["idfile=?0", "bind" => [$idfile]]);


        //die(print_r($folder));
        if ($couriel == true):
            $couriel->lu = "1";
            $couriel->update();
        endif;
        $this->view->fichier = ($fichier) ? $fichier : [];
    }
}
