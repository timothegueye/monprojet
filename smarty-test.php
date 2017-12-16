<?php


//require_once('config/init.conf.php');
require_once('config/bdd.conf.php');

require_once('config/connexion.inc.php');
require_once('include/function.inc.php');

require_once('libs/Smarty.class.php');

$prenom = 'Timothe';
$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
//$smarty->config_dir   = '/web/www.example.com/guestbook/configs/';
//$smarty->cache_dir    = '/web/www.example.com/guestbook/cache/';

$smarty->assign('name', $prenom);
//** un-comment the following line to show the debug console


include('include/header.inc.php');
$smarty->display('smarty-test.tpl');
include ('include/footer.inc.php');
?>
