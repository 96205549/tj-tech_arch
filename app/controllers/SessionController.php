<?php
use Phalcon\Mvc\Controller,
    Phalcon\Mvc\Model;

class SessionController extends Controller
{

    public function initialize()
    {
        $this->view->setMainView('main');
        $this->tag->setTitle('Bienvenue');
        //parent::initialize();
    }

    public function indexAction()
    {
      //  $this->view->disable();
        $param = settings::findFirst(["data='electra'"]);
        
        $this->view->param= $param;
    }

    public function loginAction()
    {
        if ($this->request->isPost()) {
            $pseudo = $this->request->getPost("username");
            $pwd = $this->request->getPost("pwd");

            if (empty($pseudo)) {
                $this->flashSession->error("veuillez renseigner le pseudo");
                return $this->response->redirect("session/index");
            } elseif (empty($pwd)) {
                $this->flashSession->error("le champ mot de passe est vide!");
                return $this->response->redirect("session/index");
            } else {
                $pass = sha1($pwd);

                $dataUser = user:: findFirst(["pseudo=?0 and password=?1", "bind" => ['0' => $pseudo, '1' => $pass]]);

                if ($dataUser == TRUE) {

                    if ($dataUser->actif == '1') {
                        /*
                         * passage des variable nom et id de l'utilisateur en session
                         */
                        $this->session->set('userid', $dataUser->iduser);
                        $this->session->set('pseudo', $dataUser->pseudo);
                        /*
                         * controller sur les permission
                         */
                        // $permission = ["modifier", "supprimer", "telecharger", "sms"];

                        $access = profile::findFirst($dataUser->idprofile);
                        $services = service::find();
                        $param = settings::findFirst(["data='electra'"]);
                        //die(print_r($access->permission));
                        if ($access == TRUE) {
                            // $this->session->set('permission', $access->permission);

                            $code = explode(",", $access->permission);
                            /*
                             * tableau des modules actif
                             */
                            $actif = explode(",", $param->module);
                            
                            foreach ($services as $value) {
                                if ($value->keyword == "juridique"):
                                    $juridique = (in_array($value->keyword, $code) && in_array($value->keyword, $actif)) ? $value->idserv : "0";
                                endif;
                                if ($value->keyword == "comptabilite"):
                                    $comptabilite = (in_array($value->keyword, $code) && in_array($value->keyword, $actif)) ? $value->idserv : "0";
                                endif;
                                if ($value->keyword == "administratif"):
                                    $administratif = (in_array($value->keyword, $code) && in_array($value->keyword, $actif)) ? $value->idserv : "0";
                                endif;
                                if ($value->keyword == "commercial"):
                                    $commercial = (in_array($value->keyword, $code) && in_array($value->keyword, $actif)) ? $value->idserv : "0";
                                endif;
                            }
                            $cont = (in_array("contact", $code) && in_array("contact", $actif)) ? "1" : "0";
                            $sms = (in_array("sms", $code) && in_array("messagerie", $actif)) ? "1" : "0";
                            $systeme = (in_array("systeme", $code)) ? "1" : "0";
                            $corbeille = (in_array("corbeille", $code)) ? "1" : "0";
                            $permission = (in_array("permission", $code)) ? "1" : "0";
                            /*
                             * passage des valeur dans la session pour les droit d'acc�s
                             */
                            //die(print_r("modifier=>".$mod."; sup=>".$sup.";telech=>".$telech.";sms=>".$sms));
                            $this->session->set('juridique', $juridique);
                            $this->session->set('administratif', $administratif);
                            $this->session->set('commercial', $commercial);
                            $this->session->set('comptabilite', $comptabilite);
                            $this->session->set('cont', $cont);
                            $this->session->set('sms', $sms);
                            $this->session->set('systeme', $systeme);
                            $this->session->set('corbeille', $corbeille);
                            $this->session->set('permission', $permission);
                        }

                        return $this->response->redirect("dashboard/index");
                    } else {
                        $this->flashSession->notice("le compte est inactif");
                        return $this->response->redirect("session/index");
                    }
                } else {
                    $this->flashSession->notice("identifiant incorrect");
                    return $this->response->redirect("session/index");
                }
            }
        }
    }

    public function logoutAction()
    {
        $this->session->destroy();
        return $this->response->redirect("session/index");
    }
}
