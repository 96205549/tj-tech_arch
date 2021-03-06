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
        $groups = groupe:: find(['order' => ' idgroupe DESC']);
        $userid = $this->session->get('userid');
        $corbeilles = corbeille:: find(['iduser=' . $userid, 'order' => 'idcorb DESC']);
        $this->view->corbeilles = ($corbeilles) ? $corbeilles : [];
        $this->view->contacts = ($contacts) ? $contacts : [];
        $this->view->groups = ($groups) ? $groups : [];
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
            $sms= $this->request->getPost("smsnbre");
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

                    /*
                     * controle d'unit� si le compte sms est > 0 
                     */
                    $urlSin = "http://localhost/personnel/smsbunk/api/soldein.php?idcompte=2";
                    // urlin pour les sorties le solde des debits
                    $urlSout = "http://localhost/personnel/smsbunk/api/soldeout.php?idcompte=2";

                    $soldin = file_get_contents($urlSin);
                    $jsonIn = json_decode($soldin);
                    //die(var_dump($jsonIn));
                    $soldout = file_get_contents($urlSout);
                    $jsonOut = json_decode($soldout);

                    $solda = $jsonIn->{'soldein'}[0]->{'sms'};
                    $soldb = $jsonOut->{'soldeout'}[0]->{'sms'};
                    $sold = $solda - $soldb;


                    if($sold >0){
                    $link = "http://oceanicsms.com/api/http/sendmsg.php?" .
                        "user=%s&password=%s&from=%s&to=%s&text=%s&api=%s";

                    $result = file_get_contents(sprintf($link, $login, $pass, $expediteur, $destinataire, $text, $apikey));

                    if (preg_match("/err/i", $result)) {
                        echo "erreur lors de l'envoi du message: " . $result;
                    } else {
                        $idcomptsms= 2;
                        
                        
                        $urlinsert="http://localhost/personnel/smsbunk/api/insertcredit.php?idcompte=$idcomptsms&sms=$sms";
                       file_get_contents($urlinsert);
                        echo "message envoyé avec success " . $result;                   
                    }
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

    public function smsGroupAction()
    {
        if (!$this->session->get('userid')) {
            $this->response->redirect("session/logout");
        }

        $models = modelesms::find();
        $this->view->models = ($models) ? $models : [];

        if ($this->request->isPost()) {
            $this->view->disable();
            $expediteur = $this->request->getPost("expediteur");
            $dest = $this->request->getPost("destinataire");
            /* die(print_r($dest));
              return; */
            $message = $this->request->getPost("message");
            //$destinataire = explode(";", $dest);
            // die(print_r($destinataire[1]));
            $size = sizeof($dest);
            $modele = ($this->request->getPost("modelesms") ? "1" : "0");
            $sendme = ($this->request->getPost("sendme") ? "1" : "0");
            $iduser = $this->session->get('userid');

            if (empty($expediteur)) {
                $this->flashSession->error("l expediteur ne peut etre vide");
            } elseif ($size == 0) {
                $this->flashSession->error("Veuillez choisir le groupe destinataire(s)");
            } elseif (empty($message)) {
                $this->flashSession->error("Saisissez le message a envoyer");
            } else {

                $i = 0;
                foreach ($dest as $key => $value) {
                    $datagroup = [];
                    $datagroup = contact:: find(['idgroupe=:0:', 'bind' => ['0' => $value]]);
                    foreach ($datagroup as $group):
                        $newMessage = new sendsms();
                        $newMessage->setExpediteur($expediteur);
                        $newMessage->setDestinataire($group->mobile);
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
                        $destinataire = str_replace("+", "00", $group->mobile);
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
                    endforeach;

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
                    $this->response->redirect("message/smsGroup");
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
        $messages = sendsms::find([' archiver=:val:  order by idsms DESC', 'bind' => ['val' => "0"]]);
        $this->view->messages = ($messages) ? $messages : [];
        $this->view->page = "message";
    }
    /*
     * archivage de plusieurs ligne de sms cocher
     */

    public function archivesSmsAction()
    {

        if ($this->request->isPost()) {
            $historiquesms = $this->request->getPost('zipsms');
            //die(print_r($historiquesms));
            $taille = sizeof($historiquesms);
            if ($taille > 0) {
                $i = 0;
                foreach ($historiquesms as $key => $sms) {
                    $lignMsg = sendsms::findFirst($sms);
                    $lignMsg->archiver = "1";
                    $lignMsg->save();
                    $i++;
                }
                if ($i == $historiquesms) {
                    //$this->flashSession->success("messges archiver avec succ&egrave;s");
                }
            } else {
                $this->flashSession->error("Veuillez cohez les messges � archiver");
            }
        }
        $this->response->redirect("message/mesMessages");
        $this->view->page = "message";
    }
    /*
     * archivage d'une seul ligne sms
     */

    public function onlySmsAction()
    {
        if (!$this->session->get('userid')) {
            return $this->response->redirect("session/logout");
        }

        $code = base64_decode($this->request->get('code'));

        if ((int) $code) {
            $lignMsg = sendsms::findFirst($code);
            $lignMsg->archiver = "1";
            $true = $lignMsg->save();


            if ($true) {
                // $this->flashSession->success("messges archiver avec succ&egrave;s");
            }
        } else {
            $this->response->redirect("message/404");
        }

        $this->response->redirect("message/mesMessages");
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
        $data = [];
        $data["nbrmsg"] = $totmsg;
        foreach ($messages as $message) {
            $data["msg"] = $message->toArray();
        }
        return json_encode($data);
    }
}
