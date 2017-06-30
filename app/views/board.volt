<!DOCTYPE html>
<?php
if(!isset($page)){
 $page = "dash";
}
if(!isset($corbeilles)){
 $corbeilles = [];
}
$services = service::find();

$iduser= $this->session->get('userid');

$mesg = couriel::find(["iduser= :u: and lu=:nl:", "bind"=>['u'=>$iduser,'nl'=>0]]);
$msg = couriel::find(["iduser= :u: and lu=:nl: order by idcouriel desc ", "bind"=>['u'=>$iduser,'nl'=>0]]);
    $totmsg= sizeof($mesg);
$param = settings::findFirst(["data='electra'"]);

function coup_word($param) {
    $tab= explode(" ", $param);
    $taille= sizeof($tab);
    if($taille >4){
        $i=0;
    foreach ($tab as $value){
         if($i<7){
        $data[]= $value;
        
        $i++;
        if($i==7){
            break;
        }
        }
    }
    return implode(" ", $data);
    }else {return $param;}
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="<?= $this->url->getBaseUri()."public/archives/".$param->icone; ?>" />
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Electra</title>
        <link href="<?= $this->url->getBaseUri(); ?>public/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= $this->url->getBaseUri(); ?>public/css/jasny-bootstrap.css">
        <link rel="stylesheet" href="<?= $this->url->getBaseUri(); ?>public/vendor/bootstrap/dist/css/bootstrap.css">
        <link href="<?= $this->url->getBaseUri(); ?>public/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= $this->url->getBaseUri(); ?>public/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="<?= $this->url->getBaseUri(); ?>public/vendor/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?= $this->url->getBaseUri(); ?>public/vendor/bootstrap-toggle/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script type="text/javascript">
            //<!--
            document.oncontextmenu = new Function("return false");
            //-->
        </script>
    </head>
    <body class="bod">
        <div class="container-fuild">
            <div class="container-fuild">
                <nav class="navbar navbar-inverse navcol  navbar-fixed-top col-md-12">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>                        
                            </button>
                            <a class="navbar-brand" href="">Electra</a>
                        </div>
                        <div class="collapse navbar-collapse" id="myNavbar">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="#" id="notif" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-envelope navbar-notification-icon"></i>
                                        <span class="visible-xs-inline">&nbsp;Notifications</span>
                                        <b class="badge badge-secondary <?= ($totmsg)> 0 ? "text-danger": " " ?>"><?= $totmsg; ?></b>
                                        <ul class="dropdown-menu sous-menu" role="notification">
                                            <?php foreach ($msg as $message) :?>
                                            <li>
                                                <a href="<?= ($message->type=="doc")? $this->url->get("inbox/doc?id=". base64_encode($message->iddos)."_".base64_encode($message->idcouriel)) : $this->url->get("inbox/file?id=". base64_encode($message->iddos)."_".base64_encode($message->idcouriel)) ?>">
                                                    <div class="col-sm-1 small-text">
                                                        <i class="fa fa-user text-primary">&nbsp; Albert</i>
                                                    </div>
                                                    <div class="col-sm-12 small-text" id="msgCount">
                                                        <p class="small-text">
                                                            <font style="font-size:8px;"><?= coup_word($message->message."geg sgsdgs gdsgshdfh   ssdsddgsd"); ?> </font> 
                                                        </p>
                                                    </div>

                                                </a>
                                            </li> 
                                            <?php endforeach; ?>
                                            <!--li>
                                                <a href="#">
                                                    
                                                    <div class="col-sm-12 text-warning">
                                                       voir Plus
                                                    </div>

                                                </a>
                                            </li--> 
                                        </ul>
                                    </a>
                                </li>
                                <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
                                        <span class="glyphicon glyphicon-user"></span> <?= $this->session->get('pseudo');  ?>&nbsp;<i class="fa fa-caret-down"></i></a>
                                    <ul class="dropdown-menu sous-menu" role="menu">
                                        <li>
                                            <a href="<?= $this->url->get("dashboard/profile?id=".base64_encode($this->session->get('userid'))); ?>"><span class="glyphicon glyphicon-user text-warning"></span>&nbsp; Mon profile</a>
                                        </li> 
                                        <li>
                                            <a href="<?= $this->url->get("session/logout"); ?>"><span class="glyphicon glyphicon-log-out text-warning"></span>&nbsp; D&eacute;connexion</a>
                                        </li>                    
                                    </ul>
                                </li>

<!--li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li-->
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container-fuild">
                    <div class="row-fluid col-md-2 block-ga"> 
                        <div class="bloc-right"> 
                            <div class="xfixed"> 
                                <!--span class="clearfix">&nbsp;</span-->
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a  href="<?= $this->url->get("dashboard/index"); ?>"><span class="glyphicon glyphicon-home text-primary">
                                                    </span> Dashboard</a>
                                            </h4>
                                        </div>

                                    </div>


                                    <?php foreach ($services as $key => $value): ?>
                                    <?php if($this->session->get($value->keyword) != 0 ): ?>                                   
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseS<?= $value->idserv ?>"><span class="glyphicon glyphicon-folder-close text-warning">
                                                    </span> <?= $value->description ?></a>
                                            </h4>
                                        </div>
                                        <div id="collapseS<?= $value->idserv ?>" class="panel-collapse collapse <?= ($page == $value->keyword) ? "in active" : "" ?> ">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <tr> <?php //die(print_r($page)); ?>
                                                        <td>
                                                            <span class="glyphicon glyphicon-folder-open"></span> <a href="<?= $this->url->get("$value->keyword/newFolder" ); ?>"> Nouvelle archive</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="glyphicon glyphicon-folder-close"></span> <a href="<?= $this->url->get("$value->keyword/mesFolders"); ?>"> Listes des archives</a>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php endforeach; ?>

                                    {% if session.get('cont') ==1 %}
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="glyphicon glyphicon-erase text-warning">
                                                    </span> Carnet d&apos; adresse</a>
                                            </h4>
                                        </div>
                                        <div id="collapseFour" class="panel-collapse collapse <?= ($page == "contact")? "in active" : "" ?>">
                                            <div class="panel-body">
                                                <table class="table table-responsive table-triped">
                                                    <tr class="table table-triped">
                                                        <td>
                                                            <span class="glyphicon glyphicon-earphone"></span> <a href="<?= $this->url->get("contact/newContact"); ?>"> Cr&eacute;er un contact</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="glyphicon glyphicon-list-alt"></span> <a href="<?= $this->url->get("contact/mesContacts"); ?>"> Mes Contacts</a> 
                                                        </td>
                                                    </tr>                               
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {% endif %}

                                    {% if session.get('sms') ==1 %}
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive"><span class="glyphicon glyphicon-envelope text-warning">
                                                    </span> Messagerie sms</a>
                                            </h4>
                                        </div>
                                        <div id="collapseFive" class="panel-collapse collapse <?= ($page == "message")? "in active" : "" ?>">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <span class="glyphicon glyphicon-comment"></span><a href="<?= $this->url->get("message/newMessage"); ?>"> Sms unitaire</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="glyphicon glyphicon-comment"></span><a href="<?= $this->url->get("message/smsGroup"); ?>"> Sms group&eacute;(s)</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="glyphicon glyphicon-envelope"></span><a href="<?= $this->url->get("message/mesMessages"); ?>"> historique sms</a>
                                                        </td>
                                                    </tr>     
                                                    <!--tr>
                                                        <td>
                                                            <span class="glyphicon glyphicon-book"></span><a href="<?// $this->url->get("message/backupsms"); ?>"> sms archiver</a>
                                                        </td>
                                                    </tr-->     
                                                </table>
                                            </div>
                                        </div>
                                    </div>                      
                                    {% endif %}
                                     <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseHeight"><span class="glyphicon glyphicon-comment text-warning">
                                                    </span> Couriel</a>
                                            </h4>
                                        </div>
                                        <div id="collapseHeight" class="panel-collapse collapse <?= ($page == "couriel")? "in active" : "" ?>">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <span class="glyphicon glyphicon-chevron-right"></span><a href="<?= $this->url->get("couriel/send"); ?>"> Bo&icirc;te d&apos;envoie</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="glyphicon glyphicon-check"></span><a href="<?= $this->url->get("couriel/recu"); ?>"> Bo&icirc;te de reception</a>
                                                        </td>
                                                    </tr>
                                                      
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {% if session.get('permission') ==1 %}
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseik"><span class="glyphicon glyphicon-user text-warning">
                                                    </span>R&ocirc;le/Permission</a>
                                            </h4>
                                        </div>
                                        <div id="collapseik" class="panel-collapse collapse <?= ($page == "permission")? "in active" : "" ?>">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <span class="fa fa-user"></span><a href="<?= $this->url->get("profile/newUser"); ?>"> utilisateurs</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="fa fa-user-circle"></span><a href="<?= $this->url->get("profile/newProfile"); ?>"> profil</a>
                                                        </td>
                                                    </tr>     
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {% endif %}


                                    {% if session.get('systeme') == 1 %}
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix"><span class="glyphicon glyphicon-cog text-danger">
                                                    </span> Param&egrave;tres</a>
                                            </h4>
                                        </div>
                                        <div id="collapseSix" class="panel-collapse collapse <?= ($page == "settings")? "in active" : "" ?>">
                                            <div class="panel-body">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <span class="glyphicon glyphicon-user"></span><a href="<?= $this->url->get("dashboard/settings"); ?>"> Systeme</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="glyphicon glyphicon-stats"></span><a href="<?= $this->url->get("dashboard/compteSms"); ?>"> Compte Sms</a>
                                                        </td>
                                                    </tr>     
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {% endif %}


                                    {% if session.get('corbeille') ==1 %}
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a href="<?= $this->url->get("dashboard/corbeille"); ?>"><span class="glyphicon glyphicon-trash text-warning">
                                                    </span> Corbeille <?= "(".sizeof($corbeilles).")" ?></a>
                                            </h4>
                                        </div>      
                                    </div>
                                    {% endif %}
                                </div>


                            </div>     
                        </div>     
                    </div>     

                    <div class="col-sm-10 bloc-left"> 
                        {{ content() }}
                    </div>     
                </div>
            </div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

        <!-- Latest compiled and minified JavaScript -->
        <script src="<?= $this->url->getBaseUri(); ?>public/js/jquery.js" ></script>
        <!--script src="<?= $this->url->getBaseUri(); ?>public/vendor/jquery/dist/jquery.js" ></script-->
        <!--script src="<?= $this->url->getBaseUri(); ?>public/vendor/jquery/dist/jquery.min.js"></script-->
        <script src="<?= $this->url->getBaseUri(); ?>public/vendor/bootstrap/dist/js/bootstrap.min.js"></script>      
        <script src="<?= $this->url->getBaseUri(); ?>public/js/delete.js"></script>      
        <!--script src="<?= $this->url->getBaseUri(); ?>vendor/ckeditor/ckeditor/ckeditor.js"></script-->
        <script src="<?= $this->url->getBaseUri(); ?>public/js/archives.js"></script>  

        <script src="<?= $this->url->getBaseUri(); ?>public/js/jquery.slimscroll.min.js"></script>

        <script src="<?= $this->url->getBaseUri(); ?>public/js/jquery.dataTables.min.js"></script>      
        <script src="<?= $this->url->getBaseUri(); ?>public/js/dataTables.bootstrap.js"></script>      
        <script src="<?= $this->url->getBaseUri(); ?>public/js/datatables-helper.js"></script>  
        <!-- script du tri d'un tableau  -->
        <script src="<?= $this->url->getBaseUri(); ?>public/js/mvpready-core.js"></script>
        <script src="<?= $this->url->getBaseUri(); ?>public/js/mvpready-helpers.js"></script>
        <script src="<?= $this->url->getBaseUri(); ?>public/js/mvpready-vendeur.js"></script>



        <script type="text/javascript" src="<?= $this->url->getBaseUri(); ?>public/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?= $this->url->getBaseUri(); ?>public/js/clockpicker.js"></script>
        <script type="text/javascript" src="<?= $this->url->getBaseUri(); ?>public/js/selectize.js"></script>
        <script src="<?= $this->url->getBaseUri(); ?>/public/js/fileinput.js"></script>
        <script type="text/javascript" src="<?= $this->url->getBaseUri(); ?>public/vendor/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>

    </body>
</html>



