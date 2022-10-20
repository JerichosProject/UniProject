<?php

    ini_set("session.cookie_lifetime",3600 * 24 * 7);
    session_start();
    define('UniProjects','true');
    date_default_timezone_set('Europe/London');
    header('Content-Type: text/html; charset=utf-8');
    mb_internal_encoding('utf-8');

    require('session_class.php');

    $dbh=null;
    $database=array(
        'host'=>'localhost',
        'dbname'=>'graph_db',
        'username'=>'jericho',
        'password'=>'yF21zkk8XujhbYM'
    );
    if(!isset($GLOBALS['database'])) $GLOBALS['database']=null;

    try {
        $dbh = new PDO('mysql:host='.$database['host'].';dbname='.$database['dbname'].';',$database['username'],$database['password']);
        $GLOBALS['database']=$dbh;
    } catch (PDOException $e) {
        exit(json_encode(array('result'=>0,'message'=>'Error while connecting to MAIN Database: '.$e->getMessage().'<br/>')));
        die();
    }

?>