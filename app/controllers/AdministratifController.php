<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of FolderController
 *
 * @author karth solution
 */
use Phalcon\Mvc\Controller;

class AdministratifController extends Controller
{

    public function initialize()
    {
         if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $this->view->setMainView('board');
        $this->tag->setTitle('Bienvenue');
        $userid = $this->session->get('userid');
        $corbeilles = corbeille:: find(['iduser=' . $userid, 'order' => 'idcorb DESC']);
        $this->view->corbeilles = ($corbeilles) ? $corbeilles : [];
        //parent::initialize();
    }

    public function getActivites($param, $userid)
    {
        $activity = new recentActivity();
        $activity->activite = $param;
        $activity->date = time();
        $activity->iduser = $userid;
        $activity->save();
    }

    public function indexAction()
    {
         if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
    }
    /*
     * create new folder 
     */

    public function newFolderAction()
    {
         if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        //die(print_r($this->session->get("administratif")));
        $key = $this->request->get('key');
        //die(print_r($key));
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $idserv = $this->session->get('administratif');
        if ($this->request->isPost()) {
            $foldername = $this->request->getPost("foldername");
            $permission = implode(",", $this->request->getPost("config"));
            if (empty($foldername)) {
                $this->flashSession->error("Veuillez renseigne le nom du dossier");
            } else {
                $newfolder = new dossier();
                $newfolder->nomdos = $foldername;
                $newfolder->date = time();
                $newfolder->parent = "0";
                $newfolder->permission = $permission;
                $newfolder->iduser = $iduser;
                $newfolder->idserv = $idserv;
                if ($newfolder->save()) {
                    $this->flashSession->success("Le dossier &agrave; &eacute;t&eacute; cr&eacute;er avec success");
                } else {
                    $this->flashSession->error("Echec lors de la cr&eacute;action du dossier");
                }
            }
        }

        $dossiers = dossier::find(["parent=0 and idserv=:serv: order by iddos desc", "bind" => ['serv' => $idserv]]);
        $this->view->dossiers = ($dossiers) ? $dossiers : [];
        $this->view->page = "administratif";
    }
    /*
     * folder listes
     */

    public function mesFoldersAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $idserv = $this->session->get('administratif');
        $dossiers = dossier::find(["parent=0 and idserv=:serv: order by iddos desc", "bind" => ['serv' => $idserv]]);
        $this->view->dossiers = ($dossiers) ? $dossiers : [];
        $this->view->page = "administratif";
    }

    public function updateFolderAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $idfolder = base64_decode($this->request->get('id'));
        $idserv = $this->session->get('administratif');
        $this->view->page = "administratif";

        if ($this->request->isPost()) {
            $foldername = $this->request->getPost("foldername");
            $permission = implode(",", $this->request->getPost("config"));
            //die(print_r($permission));
            $parent = $this->request->getPost("tree");
            $folder = dossier:: findFirstByIddos($parent);
            if (empty($foldername)) {
                $this->flashSession->error("Veuillez renseigne le nom du dossier");
            } else {
                if ($folder) {

                    $folder->nomdos = $foldername;
                    $folder->date = time();
                    $folder->permission = $permission;
                    $folder->iduser = $iduser;
                    $folder->idserv = $idserv;
                    if ($folder->save()) {
                        $this->flashSession->success("Le dossier &agrave; &eacute;t&eacute; Modifier avec success");
                        return $this->response->redirect("administratif/updateFolder?id=" . base64_encode($folder->iddos));
                    } else {
                        $this->flashSession->error("Echec de modification du dossier");
                        return $this->response->redirect("administratif/updateFolder?id=" . $folder->iddos);
                    }
                }
            }
            $this->response->redirect("administratif/openFolder?id=" . base64_encode($idfolder));
        }
        $folder = dossier::findFirst(["iddos =?0 ", "bind" => ["0" => $idfolder]]);
        if ($folder == TRUE) {
            $this->view->folder = $folder;
        } else {
            return $this->response->redirect("administratif/newFolder");
        }
    }
    /*
     * open folder openFolder (nouvelle archives
     */

    public function openFolderAction()
    {
         if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $idserv = $this->session->get('administratif');
        $id = base64_decode($this->request->get('id'));
        if (!(int) $id) {
            return $this->response->redirect('administratif/newFolder');
        } else {
            $doc = dossier::findFirstByIddos($id);
            if ($doc) {
                $docFiles = fichier::find(["iddos=:iddos: order by idfile DESC", "bind" => ["iddos" => $id,]]);
                $docChild = dossier::find(["parent=:val: order by iddos DESC", "bind" => ["val" => $id]]);
                $dossier = dossier::findFirstByIddos($id);
                $this->view->dossier = ($dossier) ? $dossier : [];
                $this->view->docFiles = ($docFiles) ? $docFiles : [];
                $this->view->docChild = ($docChild) ? $docChild : [];
            } else {
                $this->response->redirect("administratif/newFolder");
            }
        }
        $this->view->page = "administratif";
    }

    public function childFolderAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $idserv = $this->session->get('administratif');
        if ($this->request->isPost()) {
            $foldername = $this->request->getPost("foldername");
            $permission = implode(",", $this->request->getPost("config"));
            $parent = $this->request->getPost("tree");
            if (empty($foldername)) {
                $this->flashSession->error("Veuillez renseigne le nom du dossier");
            } else {
                $newfolder = new dossier();
                $newfolder->nomdos = $foldername;
                $newfolder->date = time();
                $newfolder->parent = $parent;
                $newfolder->permission = $permission;
                $newfolder->iduser = $iduser;
                $newfolder->idserv = $idserv;
                if ($newfolder->save()) {
                    $this->flashSession->success("Le dossier &agrave; &eacute;t&eacute; cr&eacute;er avec success");
                } else {
                    $this->flashSession->error("Echec lors de la cr&eacute;action du dossier");
                }
            }
            $this->response->redirect("administratif/openfolder?id=" . base64_encode($parent));
        }
    }

    public function childFileAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $idserv = $this->session->get('administratif');

        if ($this->request->isPost()) {

            //die(print_r($pseudo));
            if ($this->request->hasFiles() == true) {
                $folderid = $this->request->getPost("tree");
                $descfile = $this->request->getPost("descfile");
                $permission = implode(",", $this->request->getPost("config"));
                $uploaddocs = $this->request->getUploadedFiles();
                //die(print_r($uploaddocs));

                $isuploads = false;
                foreach ($uploaddocs as $upload) {
                    $extension = new SplFileInfo($upload->getName());
                    $type = $extension->getExtension();
                    if (!in_array(strtolower($type), ['mp3', 'mp4', 'mov', 'flv'])) {
                        $path = $this->rootfile . $upload->getName();
                        $isuploads = $upload->moveTo($path);
                        $valeurdocument[] = $upload->getName();
                    }
                }

                // die(print_r($descfile));

                if (!empty($valeurdocument)) {
                    $nbre = count($valeurdocument);
                    foreach ($valeurdocument as $keya => $value) {
                        foreach ($descfile as $keyb => $file) {
                            if ($keya == $keyb) {
                                $newFolder = new fichier();
                                $newFolder->description = $file;
                                $newFolder->nomfile = $value;
                                $newFolder->iddos = $folderid;
                                $newFolder->date = time();
                                $newFolder->iduser = $iduser;
                                $newFolder->permission = $permission;
                                $newFolder->idserv = $idserv;
                                $newFolder->save();
                            }
                        }
                        $i++;
                    }
                    if ($i == $nbre) {
                        $this->getActivites($pseudo . " a ajouter le dossier " . $folder, $iduser);
                        $this->flashSession->success("Le document a &eacute;t&eacute; creer avec succ&egrave;s");
                    } else {
                        $this->flashSession->error("Le document que vous essayez de creer a echou&eacute;");
                    }
                } else {
                    $this->flashSession->error("D&eacute;sol&eacute;. Le format du fichier n&apos;est pas valide");
                }
            }
            $this->response->redirect("administratif/openfolder?id=" . base64_encode($folderid));
        }
    }
    /*
     * update folder name
     */

    public function updateFolderChildAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $idserv = $this->session->get('administratif');

        if ($this->request->isPost()) {
            $foldername = $this->request->getPost("foldername");
            $permission = implode(",", $this->request->getPost("config"));
            $parent = $this->request->getPost("tree");
            $folder = dossier:: findFirstByIddos($parent);
            if (empty($foldername)) {
                $this->flashSession->error("Veuillez renseigne le nom du dossier");
            } else {
                if ($folder) {

                    $folder->nomdos = $foldername;
                    $folder->date = time();
                    $folder->permission = $permission;
                    $folder->iduser = $iduser;
                    $folder->idserv = $idserv;
                    if ($folder->save()) {
                        $this->flashSession->success("Le dossier &agrave; &eacute;t&eacute; Modifier avec success");
                    } else {
                        $this->flashSession->error("Echec de modification du dossier");
                    }
                }
            }
            $this->response->redirect("administratif/openFolder?id=" . base64_encode($parent));
        }
    }
    /*
     * delete folder enfant
     */

    public function deleteFolderAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $id = base64_decode($this->request->get('id'));
        $allFiles = fichier::find(["iddos=:idd:", "bind" => ["idd" => $id]]);
        if ($allFiles) {
            foreach ($allFiles as $value) {
                $corbeil = new corbeille();
                $corbeil->nomfile = $value->nomfile;
                $corbeil->description = $value->description;
                $corbeil->iddos = $value->iddos;
                $corbeil->date = $value->date;
                $corbeil->iduser = $value->iduser;
                $corbeil->save();
                $value->delete();
            }
            $doc = dossier::findFirstByIddos($id);
            /*
             * récuperation de l'id parent du dossier $idp
             */
            $idp = $doc->parent;
        }
        $corb = new corbeille();
        $corb->description = $doc->nomdos;
        $corb->date = $doc->date;
        $corb->iduser = $doc->iduser;
        $corb->iddos = $doc->iddos;
        $corb->save();
        if ($doc->delete()) {
            //$this->getActivites($pseudo . " a ajouter supprim� un dossier", $iduser);
            $this->flashSession->success("Le dossier a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s");
        } else {
            $this->flashSession->error("Le dossier n' a pu &ecirc;tre supprim&eacute;");
        }
        $this->response->redirect("administratif/openFolder?id=" . base64_encode($idp));
        $this->view->page = "administratif";
    }
    /*
     * delete folder parent new de folfder
     */

    public function deleteFolderPnAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $id = base64_decode($this->request->get('id'));
        $allFiles = fichier::find(["iddos=:idd:", "bind" => ["idd" => $id]]);
        if ($allFiles) {
            foreach ($allFiles as $value) {
                $corbeil = new corbeille();
                $corbeil->nomfile = $value->nomfile;
                $corbeil->description = $value->description;
                $corbeil->iddos = $value->iddos;
                $corbeil->date = $value->date;
                $corbeil->iduser = $value->iduser;
                $corbeil->save();
                $value->delete();
            }
            $doc = dossier::findFirstByIddos($id);
            /*
             * récuperation de l'id parent du dossier $idp
             */
            // $idp= $doc->parent;
        }
        $corb = new corbeille();
        $corb->description = $doc->nomdos;
        $corb->date = $doc->date;
        $corb->iduser = $doc->iduser;
        $corb->iddos = $doc->iddos;
        $corb->save();
        if ($doc->delete()) {
            //$this->getActivites($pseudo . " a ajouter supprim� un dossier", $iduser);
            $this->flashSession->success("Le dossier a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s");
        } else {
            $this->flashSession->error("Le dossier n' a pu &ecirc;tre supprim&eacute;");
        }
        $this->response->redirect("administratif/newFolder");
        $this->view->page = "administratif";
    }
    /*
     * delete folder parent de mes folfders
     */

    public function deleteFolderMAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $id = base64_decode($this->request->get('id'));
        $allFiles = fichier::find(["iddos=:idd:", "bind" => ["idd" => $id]]);
        if ($allFiles) {
            foreach ($allFiles as $value) {
                $corbeil = new corbeille();
                $corbeil->nomfile = $value->nomfile;
                $corbeil->description = $value->description;
                $corbeil->iddos = $value->iddos;
                $corbeil->date = $value->date;
                $corbeil->iduser = $value->iduser;
                $corbeil->save();
                $value->delete();
            }
            $doc = dossier::findFirstByIddos($id);
            /*
             * récuperation de l'id parent du dossier $idp
             */
            // $idp= $doc->parent;
        }
        $corb = new corbeille();
        $corb->description = $doc->nomdos;
        $corb->date = $doc->date;
        $corb->iduser = $doc->iduser;
        $corb->iddos = $doc->iddos;
        $corb->save();
        if ($doc->delete()) {
            //$this->getActivites($pseudo . " a ajouter supprim� un dossier", $iduser);
            $this->flashSession->success("Le dossier a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s");
        } else {
            $this->flashSession->error("Le dossier n' a pu &ecirc;tre supprim&eacute;");
        }
        $this->response->redirect("administratif/mesFolders");
        $this->view->page = "administratif";
    }
    /*
     * delete folder enfant de open de listes archives
     */

    public function deleteFoldersOAction()
    {
         if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $id = base64_decode($this->request->get('id'));
        $allFiles = fichier::find(["iddos=:idd:", "bind" => ["idd" => $id]]);
        if ($allFiles) {
            foreach ($allFiles as $value) {
                $corbeil = new corbeille();
                $corbeil->nomfile = $value->nomfile;
                $corbeil->description = $value->description;
                $corbeil->iddos = $value->iddos;
                $corbeil->date = $value->date;
                $corbeil->iduser = $value->iduser;
                $corbeil->save();
                $value->delete();
            }
            $doc = dossier::findFirstByIddos($id);
            /*
             * récuperation de l'id parent du dossier $idp
             */
            $idp = $doc->parent;
        }
        $corb = new corbeille();
        $corb->description = $doc->nomdos;
        $corb->date = $doc->date;
        $corb->iduser = $doc->iduser;
        $corb->iddos = $doc->iddos;
        $corb->save();
        if ($doc->delete()) {
            //$this->getActivites($pseudo . " a ajouter supprim� un dossier", $iduser);
            $this->flashSession->success("Le dossier a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s");
        } else {
            $this->flashSession->error("Le dossier n' a pu &ecirc;tre supprim&eacute;");
        }
        $this->response->redirect("administratif/open?id=" . base64_encode($idp));
        $this->view->page = "administratif";
    }

    public function deleteFileAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $id = base64_decode($this->request->get('id'));
        ///$id = explode("_", $val[0]);
        if (!(int) $id) {
            return $this->response->redirect('administratif/mesFolders');
        }
        $docFiles = fichier::findFirst(["idfile =?0", "bind" => [$id]]);
        if ($docFiles == TRUE) {
            $idf = $docFiles->iddos;
            $corb = new corbeille();
            $corb->description = $docFiles->description;
            $corb->nomfile = $docFiles->nomfile;
            $corb->typefile = $docFiles->extension;
            $corb->taille = $docFiles->taille;
            $corb->date = $docFiles->date;
            $corb->iduser = $docFiles->iduser;
            $corb->iddos = $docFiles->iddos;
            $corb->save();
            if ($docFiles->delete()) {
                //$this->getActivites($pseudo . " a ajouter supprim� un fichier", $iduser);
                $this->flashSession->success("Le fichier a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s");
            }
        }
        $this->response->redirect("administratif/openFolder?id=" . base64_encode($idf));
        $this->view->page = "administratif";
    }
    /*
     * modification des fichier d'un dossier
     */

    public function updateFileAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $this->view->page = "administratif";
        $pseudo = $this->session->get('pseudo');
        $iduser = $this->session->get('userid');
        $idserv = $this->session->get('administratif');
        $val = $this->request->get('id');
        $idfile = base64_decode(explode(".", $val)[0]);
        $idfolder = base64_decode(explode(".", $val)[1]);

        // die(print_r($val));
        if (!(int) $idfile && !(int) $idfolder) {
            return $this->response->redirect('administratif/newFolder');
        }
        if ($this->request->isPost()) {
            // if ($this->request->hasFiles() == true) {
            $descfile = $this->request->getPost("descfile");
            $permission = implode(",", $this->request->getPost("config"));
            if ($this->request->hasFiles() == true) {

                $uploads = $this->request->getUploadedFiles();
                //$this->view->disable();
                // $idf = $this->request->get('id');
                //die(print_r($idf));
                $docFile = fichier::findFirst(["idfile =?0", "bind" => [$idfile]]);

                $isuploads = false;
                foreach ($uploads as $upload) {

                    $extension = new SplFileInfo($upload->getName());
                    $type = $extension->getExtension();

                    if (!in_array(strtolower($type), ['mp3', 'mp4', 'mov', 'flv'])) {
                        $path = $this->rootfile . $upload->getName();
                        $isuploads = $upload->moveTo($path);

                        if (empty($upload->getName())) {
                            $filname = $docFile->nomfile;
                        } else {
                            $filname = $upload->getName();
                        }
                    }
                }
            }







            $docFile->description = $descfile;
            $docFile->nomfile = $filname;
            $docFile->date = time();
            $docFile->extension = empty($type) ? $docFile->extension : $type;
            $docFile->taille = empty($upload->getSize()) ? $docFile->taille : $upload->getSize();
            $docFile->iduser = $iduser;
            $docFile->idserv = $idserv;
            $docFile->permission = $permission;
            $docFile->type = "0"; // type file
            if ($docFile->update()) {
                $this->flashSession->success("Le fichier a &eacute;t&eacute; mise &agrave; jour avec succ&egrave;s");
                return $this->response->redirect("administratif/updateFile?id=" . base64_encode($idfile) . '.' . base64_encode($docFile->iddos));
            } else {
                $this->flashSession->error("Echec de la mise &agrave; jour du fichier");
                return $this->response->redirect("administratif/updateFile?id=" . base64_encode($idfile) . '.' . base64_encode($docFile->iddos));
            }
        }
        $docFile = fichier::findFirst(["idfile =?0 and iddos=?1", "bind" => ["0" => $idfile, "1" => $idfolder]]);
        if ($docFile == TRUE) {
            $this->view->docFile = $docFile;
        } else {
            return $this->response->redirect("administratif/newFolder");
        }
    }
    /*
     * open de mes folders
     */

    /*
     * open folder openFolder (mes archives)
     */

    public function openAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $id = base64_decode($this->request->get('id'));
        if (!(int) $id) {
            return $this->response->redirect('administratif/newFolder');
        } else {
            $doc = dossier::findFirstByIddos($id);
            if ($doc) {
                $docFiles = fichier::find(["iddos=:iddos: order by idfile DESC", "bind" => ["iddos" => $id,]]);
                $docChild = dossier::find(["parent=:val: order by iddos DESC", "bind" => ["val" => $id]]);
                $dossier = dossier::findFirstByIddos($id);
                $this->view->dossier = ($dossier) ? $dossier : [];
                $this->view->docFiles = ($docFiles) ? $docFiles : [];
                $this->view->docChild = ($docChild) ? $docChild : [];
            } else {
                $this->response->redirect("administratif/newFolder");
            }
        }
        $this->view->page = "administratif";
    }

    public function childFoldersAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $idserv = $this->session->get('administratif');
        if ($this->request->isPost()) {
            $foldername = $this->request->getPost("foldername");
            $permission = implode(",", $this->request->getPost("config"));
            $parent = $this->request->getPost("tree");
            if (empty($foldername)) {
                $this->flashSession->error("Veuillez renseigne le nom du dossier");
            } else {
                $newfolder = new dossier();
                $newfolder->nomdos = $foldername;
                $newfolder->date = time();
                $newfolder->parent = $parent;
                $newfolder->permission = $permission;
                $newfolder->iduser = $iduser;
                $newfolder->idserv = $idserv;
                if ($newfolder->save()) {
                    $this->flashSession->success("Le dossier &agrave; &eacute;t&eacute; cr&eacute;er avec success");
                } else {
                    $this->flashSession->error("Echec lors de la cr&eacute;action du dossier");
                }
            }
            $this->response->redirect("administratif/open?id=" . base64_encode($parent));
        }
    }

    public function childFilesAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $idserv = $this->session->get('administratif');
        if ($this->request->isPost()) {

            //die(print_r($pseudo));
            if ($this->request->hasFiles() == true) {
                $folderid = $this->request->getPost("tree");
                $descfile = $this->request->getPost("descfile");
                $permission = implode(",", $this->request->getPost("config"));

                $uploaddocs = $this->request->getUploadedFiles();
                //die(print_r($permission));

                $isuploads = false;
                foreach ($uploaddocs as $upload) {
                    $extension = new SplFileInfo($upload->getName());
                    $type = $extension->getExtension();
                    if (!in_array(strtolower($type), ['mp3', 'mp4', 'mov', 'flv'])) {
                        $path = $this->rootfile . $upload->getName();
                        $isuploads = $upload->moveTo($path);
                        $valeurdocument[] = $upload->getName();
                    }
                }

                // die(print_r($descfile));

                if (!empty($valeurdocument)) {
                    $nbre = count($valeurdocument);
                    foreach ($valeurdocument as $keya => $value) {
                        foreach ($descfile as $keyb => $file) {
                            if ($keya == $keyb) {
                                $newFolder = new fichier();
                                $newFolder->description = $file;
                                $newFolder->nomfile = $value;
                                $newFolder->iddos = $folderid;
                                $newFolder->date = time();
                                $newFolder->iduser = $iduser;
                                $newFolder->idserv = $idserv;
                                $newFolder->permission = $permission;
                                $newFolder->save();
                            }
                        }
                        $i++;
                    }
                    if ($i == $nbre) {
                        $this->getActivites($pseudo . " a ajouter le dossier " . $folder, $iduser);
                        $this->flashSession->success("Le document a &eacute;t&eacute; creer avec succ&egrave;s");
                    } else {
                        $this->flashSession->error("Le document que vous essayez de creer a echou&eacute;");
                    }
                } else {
                    $this->flashSession->error("D&eacute;sol&eacute;. Le format du fichier n&apos;est pas valide");
                }
            }
            $this->response->redirect("administratif/open?id=" . base64_encode($folderid));
        }
    }
    /*
     * update folder name
     */

    public function updateFoldersChildAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $idserv = $this->session->get('administratif');

        if ($this->request->isPost()) {
            $foldername = $this->request->getPost("foldername");
            $permission = implode(",", $this->request->getPost("config"));
            $parent = $this->request->getPost("tree");
            $folder = dossier:: findFirstByIddos($parent);
            if (empty($foldername)) {
                $this->flashSession->error("Veuillez renseigne le nom du dossier");
            } else {
                if ($folder) {

                    $folder->nomdos = $foldername;
                    $folder->date = time();
                    $folder->permission = $permission;
                    $folder->iduser = $iduser;
                    $folder->idserv = $idserv;
                    if ($folder->save()) {
                        $this->flashSession->success("Le dossier &agrave; &eacute;t&eacute; Modifier avec success");
                    } else {
                        $this->flashSession->error("Echec de modification du dossier");
                    }
                }
            }
            $this->response->redirect("administratif/open?id=" . $parent);
        }
    }
    /*
     * modification des fichier d'un dossier
     */

    public function updateFilesAction()
    {

          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $this->view->page = "administratif";

        $pseudo = $this->session->get('pseudo');
        $iduser = $this->session->get('userid');
        $idserv = $this->session->get('administratif');
        $val = $this->request->get('id');
        $idfile = base64_decode(explode(".", $val)[0]);
        $idfolder = base64_decode(explode(".", $val)[1]);

        //die(print_r($val1.','.$val2));
        if (!(int) $idfile && !(int) $idfolder) {
            return $this->response->redirect('administratif/newFolder');
        }
        if ($this->request->isPost()) {
            // if ($this->request->hasFiles() == true) {
            $descfile = $this->request->getPost("descfile");
            $permission = implode(",", $this->request->getPost("config"));
            if ($this->request->hasFiles() == true) {

                $uploads = $this->request->getUploadedFiles();

                //die(print_r($idfile));
                //$idf = $this->request->get('id');
                $docFile = fichier::findFirst(["idfile =?0", "bind" => [$idfile]]);

                $isuploads = false;
                foreach ($uploads as $upload) {

                    $extension = new SplFileInfo($upload->getName());
                    $type = $extension->getExtension();

                    if (!in_array(strtolower($type), ['mp3', 'mp4', 'mov', 'flv'])) {
                        $path = $this->rootfile . $upload->getName();
                        $isuploads = $upload->moveTo($path);

                        if (empty($upload->getName())) {
                            $filname = $docFile->nomfile;
                        } else {
                            $filname = $upload->getName();
                        }
                    }
                }
            }







            $docFile->description = $descfile;
            $docFile->nomfile = $filname;
            $docFile->date = time();
            $docFile->extension = empty($type) ? $docFile->extension : $type;
            $docFile->taille = empty($upload->getSize()) ? $docFile->taille : $upload->getSize();
            $docFile->iduser = $iduser;
            $docFile->idserv = $idserv;
            $docFile->permission = $permission;
            $docFile->type = "0"; // type file
            if ($docFile->update()) {
                $this->flashSession->success("Le fichier a &eacute;t&eacute; mise &agrave; jour avec succ&egrave;s");
                return $this->response->redirect("administratif/updateFiles?id=" . base64_encode($idfile) . '.' . base64_encode($docFile->iddos));
            } else {
                $this->flashSession->error("Echec de la mise &agrave; jour du fichier");
                return $this->response->redirect("administratif/updateFiles?id=" . base64_encode($idfile) . '.' . base64_encode($docFile->iddos));
            }
        }
        $docFile = fichier::findFirst(["idfile =?0 and iddos=?1", "bind" => ["0" => $idfile, "1" => $idfolder]]);
        if ($docFile == TRUE) {
            $this->view->docFile = $docFile;
        } else {
            return $this->response->redirect("administratif/newFolder");
        }
    }

    public function updateFoldersAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $idfolder = base64_decode($this->request->get('id'));
        $idserv = $this->session->get('administratif');
        $this->view->page = "administratif";

        if ($this->request->isPost()) {
            $foldername = $this->request->getPost("foldername");
            $permission = implode(",", $this->request->getPost("config"));
            //die(print_r($permission));
            $parent = $this->request->getPost("tree");
            $folder = dossier:: findFirstByIddos($parent);
            if (empty($foldername)) {
                $this->flashSession->error("Veuillez renseigne le nom du dossier");
            } else {
                if ($folder) {

                    $folder->nomdos = $foldername;
                    $folder->date = time();
                    $folder->permission = $permission;
                    $folder->iduser = $iduser;
                    $folder->idserv = $idserv;
                    if ($folder->save()) {
                        $this->flashSession->success("Le dossier &agrave; &eacute;t&eacute; Modifier avec success");
                        return $this->response->redirect("administratif/updateFolders?id=" . base64_encode($folder->iddos));
                    } else {
                        $this->flashSession->error("Echec de modification du dossier");
                        return $this->response->redirect("administratif/updateFolders?id=" . base64_encode($folder->iddos));
                    }
                }
            }
            $this->response->redirect("administratif/open?id=" . base64_encode($idfolder));
        }
        $folder = dossier::findFirst(["iddos =?0 ", "bind" => ["0" => $idfolder]]);
        if ($folder == TRUE) {
            $this->view->folder = $folder;
        } else {
            return $this->response->redirect("administratif/mesFolders");
        }
    }

    public function deleteFilesOAction()
    {
         if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $pseudo = $this->session->get('pseudo');
        $id = base64_decode($this->request->get('id'));
        ///$id = explode("_", $val[0]);
        if (!(int) $id) {
            return $this->response->redirect('administratif/mesFolders');
        }
        $docFiles = fichier::findFirst(["idfile =?0", "bind" => [$id]]);
        if ($docFiles == TRUE) {
            $idf = $docFiles->iddos;
            $corb = new corbeille();
            $corb->description = $docFiles->description;
            $corb->nomfile = $docFiles->nomfile;
            $corb->typefile = $docFiles->extension;
            $corb->taille = $docFiles->taille;
            $corb->date = $docFiles->date;
            $corb->iduser = $docFiles->iduser;
            $corb->iddos = $docFiles->iddos;
            $corb->save();
            if ($docFiles->delete()) {
                //$this->getActivites($pseudo . " a ajouter supprim� un fichier", $iduser);
                $this->flashSession->success("Le fichier a &eacute;t&eacute; supprim&eacute; avec succ&egrave;s");
            }
        }
        $this->response->redirect("administratif/open?id=" . base64_encode($idf));
        $this->view->page = "administratif";
    }
    /*
     * sharedoc pour le partage au niveau de newfolder
     */

    public function sharedocAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');

        $docId = base64_decode($this->request->get('id'));
        if (!(int) $docId) {
            return $this->response->redirect("administratif/newfolder");
        }
        $docs = dossier::findFirst($docId);
        $opendocs = dossier::find(["parent=:p:", "bind" => ['p' => $docId]]);
        $openfile = fichier::find(["iddos=:d:", "bind" => ['d' => $docId]]);
        $users = user::find(["actif=:act: and iduser <>:us:", "bind" => ['act' => 1, 'us' => $iduser]]);


        $this->view->docs = ($docs) ? $docs : [];
        $this->view->users = ($users) ? $users : [];
        $this->view->opendocs = ($opendocs) ? $opendocs : [];
        $this->view->openfile = ($openfile) ? $openfile : [];
        $this->view->page = "administratif";
    }
    /*
     * sharedoc pour le partage au niveau de newfolder
     */

    public function sharedocsAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $this->view->page = "administratif";

        $docId = $this->request->get('id');
        if (!(int) $docId) {
            $this->response->redirect("administratif/newfolder");
        }
        $docs = dossier::findFirst($docId);
        $this->view->docs = ($docs) ? $docs : [];
    }

    public function shareAction()
    {
        if (!$this->session->get('userid') && $this->session->get("administratif") != 1) {
            $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $this->view->page = "administratif";

        if ($this->request->isPost()) {
            $id = $this->request->getPost("idShare");
            $type = $this->request->getPost("typeShare");
            $msg = $this->request->getPost("message");
            $users = $this->request->getPost("users");
            $taille = sizeof($users);
            //die(print_r($taille));
            if ($taille == 0) {
                if ($type == "doc") {
                    $this->flashSession->error("Veuillez choisir l&apos;utilisateur auquel vous souhaitez envoyer le courier");
                    return $this->response->redirect("administratif/sharedoc?id=" . $id);
                } else {
                    $this->flashSession->error("Veuillez choisir l&apos;utilisateur auquel vous souhaitez envoyer le courier");
                    return $this->response->redirect("administratif/sharefile?id=" . base64_encode($id));
                }
            }
            $i = 0;
            foreach ($users as $value) {
                $courier = new couriel();
                $courier->message = $msg;
                $courier->iddos = $id;
                $courier->type = $type;
                $courier->iduser = $value;
                $courier->save();
                $i++;
            }
            if ($i == $taille) {
                if ($type == "doc") {
                    $this->flashSession->success("Le dossier &agrave; &eacute;t&eacute; partag&eacute; avec success");
                    return $this->response->redirect("administratif/sharedoc?id=" . base64_encode($id));
                } else {
                    $this->flashSession->success("Le fichier &agrave; &eacute;t&eacute; partag&eacute; avec success");
                    return $this->response->redirect("administratif/sharefile?id=" . base64_encode($id));
                }
            }
        }
    }

    public function SharefileAction()
    {
          if (!$this->session->get('userid') || $this->session->get("administratif") == "0") {
           return $this->response->redirect("session/logout");
        }
        $iduser = $this->session->get('userid');
        $this->view->page = "administratif";

        $fileId = base64_decode($this->request->get('id'));
        if (!(int) $fileId) {
            $this->response->redirect("administratif/newfolder");
        }
        $files = fichier::findFirst($fileId);
        $users = user::find(["actif=:act: and iduser <>:us:", "bind" => ['act' => 1, 'us' => $iduser]]);

        $this->view->files = ($files) ? $files : [];
        $this->view->users = ($users) ? $users : [];
    }
}
