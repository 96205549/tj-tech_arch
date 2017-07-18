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

class courielController extends Controller
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
    /*
     * code source des couriel envoyé
     */

    public function sendAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }

           $iduser = $this->session->get('userid');

        $couriers = couriel:: find(["exp <>:ex:", 'bind' => ['ex'=>$iduser]]);
        if ($couriers) {
            foreach ($couriers as $courier):
                $data = [];
                $dossiers = dossier::find(["iddos=:val:", 'bind' => ['val' => $couriers->iddos]]);
                $data = $dossiers;
            endforeach;
        }
        $this->view->dossiers = ($data) ? $data : [];
        $this->view->couriers = ($couriers) ? $couriers : [];
       
        $this->view->page = "couriel";
    }
    /*
     * code source des couriel reçu
     */

    public function recuAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');

        $couriers = couriel:: find(["iduser =:val: and exp <>:ex:", 'bind' => ['val' => $iduser,'ex'=>$iduser]]);
        if ($couriers) {
            foreach ($couriers as $courier):
                $data = [];
                $dossiers = dossier::find(["iddos=:val:", 'bind' => ['val' => $couriers->iddos]]);
                $data = $dossiers;
            endforeach;
        }
        $this->view->dossiers = ($data) ? $data : [];
        $this->view->couriers = ($couriers) ? $couriers : [];
        $this->view->page = "couriel";
    }
}
