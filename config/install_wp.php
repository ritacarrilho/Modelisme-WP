<?php
//recup des infos du lando
$landoInfo = json_decode(getenv('LANDO_INFO'), true);

// recupère le répertoire
$landoWebroot = getenv('LANDO_WEBROOT');

$url = $landoInfo['appserver']['urls'][0];

// récupère les crédentials de base

$dbServer = $landoInfo['database']['internal_connection']['host'];
$dbName = $landoInfo['database']['creds']['database'];
$dbUser = $landoInfo['database']['creds']['user'];
$dbPassword = $landoInfo['database']['creds']['password'];

// tableau de commande pour télécharger wordpress

$cmd = [
    "cd $landoWebroot;",
    "wp core download"
];

$installScript = implode(' ', $cmd);
shell_exec($installScript);

// config de wordpress

$cmd = [
    "cd $landoWebroot;",
    "wp core config",
    "--dbprefix=wp_",
    "--dbhost=$dbServer",
    "--dbname=$dbName",
    "--dbuser=$dbUser",
    "--dbpass=$dbPassword"
];
$installScript = implode(' ', $cmd);
shell_exec($installScript);

//fin de l'installation
$cmd = [
    "cd $landoWebroot;",
    "wp core install",
    "--url='$url'",
    "--title='Wordpress auto configure'",
    "--admin_user='admin'",
    "--admin_password='admin'",
    "--admin_email='rita.carrilho.lameira@lidem.education'"
];
$installScript = implode(' ', $cmd);
shell_exec($installScript);
