<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of documentController
 *
 * @author karth solution
 */
use Phalcon\Mvc\Controller;

class documentController extends Controller
{

      public function initialize()
    {
        $this->view->setMainView('board');
        $this->tag->setTitle('Bienvenue');
        $userid = $this->session->get('userid');
        $corbeilles = corbeille:: find(['iduser=' . $userid, 'order' => 'idcorb DESC']);
        $this->view->corbeilles = ($corbeilles) ? $corbeilles : [];
        //parent::initialize();
    }
    public function indexAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }
    }

    public function openAction()
    {
         if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }
        $val = $this->request->get("id");

        $id = $decode = base64_decode($val);

        if (!(int) $id) {
            return $this->response->redirect("page error");
        }
        $fichier = fichier::findFirst(["idfile=?0", "bind" => [$id]]);

        $this->view->fichier = ($fichier) ? $fichier : [];
    }
}
