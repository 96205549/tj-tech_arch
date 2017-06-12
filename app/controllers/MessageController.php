<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of MessageController
 *
 * @author karth solution
 */
use Phalcon\Mvc\Controller;

class MessageController extends Controller
{

    public function initialize()
    {
        $this->view->setMainView('board');
        $this->tag->setTitle('Bienvenue');
        $corbeilles = corbeille:: find(['order' => ' idcorb DESC']);
        $contacts = contact:: find(['order' => ' id DESC']);
        $userid = $this->session->get('userid');
        $corbeilles = corbeille:: find(['iduser=' . $userid, 'order' => 'idcorb DESC']);
        $this->view->corbeilles = ($corbeilles) ? $corbeilles : [];
        $this->view->contacts = ($contacts) ? $contacts : [];
    }

    public function indexAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }
    }

    public function newMessageAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }
        $models = modelesms::find();
        $this->view->models = ($models) ? $models : [];

        if ($this->request->isPost()) {

            $expediteur = $this->request->getPost("expediteur");
            $dest = $this->request->getPost("destinataire");
            $message = $this->request->getPost("message");
            $destinataire = explode(";", $dest);
            $size = sizeof($destinataire);
            $modele = ($this->request->getPost("modelesms") ? "1" : "0");
            $sendme = ($this->request->getPost("sendme") ? "1" : "0");
            $iduser = $this->session->get('userid');

            if (empty($expediteur)) {
                $this->flashSession->error("l expediteur ne peut etre vide");
            } elseif (empty($destinataire)) {
                $this->flashSession->error("Veuillez entrer le numero du ou des destinataire(s)");
            } elseif (empty($message)) {
                $this->flashSession->error("Saisissez le message a envoyer");
            } else {

                $i = 0;
                foreach ($destinataire as $key => $value) {
                    $newMessage = new sendsms();
                    $newMessage->setExpediteur($expediteur);
                    $newMessage->setDestinataire($value);
                    $newMessage->setStatus("Envoyer");
                    $newMessage->setDate(time());
                    $newMessage->setMessage($message);
                    $newMessage->setIduser($iduser);
                    //  if ($newMessage->save()) {
                    $newMessage->save();
                    $login = "joezer";
                    $pass = "96205549";
                    $apikey = "987";
                    $expediteur = str_replace(" ", "+", $expediteur);
                    $destinataire = str_replace("+", "00", $value);
                    // str_replace("+", "00", $value)
                    $text = str_replace(" ", "+", $message);

                    //die(print_r($destinataire));

                    $link = "http://oceanicsms.com/api/http/sendmsg.php?" .
                        "user=%s&password=%s&from=%s&to=%s&text=%s&api=%s";

                    $result = file_get_contents(sprintf($link, $login, $pass, $expediteur, $destinataire, $text, $apikey));

                    if (preg_match("/err/i", $result)) {
                        echo "erreur lors de l'envoi du message: " . $result;
                    } else {
                        echo "message envoyé avec success " . $result;
                    }





                    $i++;
                    //  }
                }
                if ($size == $i) {
                    if ($modele == 1) {
                        $newModel = new modelesms();
                        $newModel->setSms($message);
                        $newModel->setDate(time());
                        $newModel->setIduser($iduser);
                        $newModel->save();
                    }
                    $this->flashSession->success("message envoye avec succes");
                    $this->response->redirect("message/newMessage");
                } else {
                    $this->flashSession->success("envoie de message echouer");
                }
            }
        }
        $this->view->page = "message";
    }

    public function mesMessagesAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }
        $messages = sendsms::find(['order' => ' idsms DESC']);
        $this->view->messages = ($messages) ? $messages : [];
        $this->view->page = "message";
    }

    public function notificationAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');

        $messages = couriel::find(["iduser= :u:", "bind" => ['u' => 6]]);
        $totmsg = sizeof($messages);
        $data =[];
        $data["nbrmsg"]=$totmsg;
        foreach ($messages as $message) {
            $data["msg"]=$message->toArray();
          
        }
        return json_encode($data);
        
        
    }
}
