<?php

    ini_set("session.cookie_lifetime",3600 * 24 * 7);
    session_start();
    define('UniProjects','true');
    date_default_timezone_set('Europe/London');
    header('Content-Type: text/html; charset=utf-8');
    mb_internal_encoding('utf-8');

    $GLOBALS['creds']=null;
    $GLOBALS['errors']=[];
    $GLOBALS['page']=array('slashes'=>array(),'query'=>array(),'info'=>array());

    if(file_exists('../access.ini')) $GLOBALS['creds']=parse_ini_file('../access.ini');
    else $GLOBALS['creds']=parse_ini_file('../../access.ini');

    require('session_class.php');

    $dbh=null;
    $database=array(
        'host'=>$GLOBALS['creds']['ip'],
        'dbname'=>'smart_shop',
        'username'=>$GLOBALS['creds']['db_user'],
        'password'=>$GLOBALS['creds']['db_pass']
    );
    if(!isset($GLOBALS['database'])) $GLOBALS['database']=null;

    try {
        $dbh = new PDO('mysql:host='.$database['host'].';dbname='.$database['dbname'].';',$database['username'],$database['password']);
        $GLOBALS['database']=$dbh;
    } catch (PDOException $e) {
        $GLOBALS['errors'][]=$e->getMessage();
        if(file_exists('pages/site_down.php')) include('pages/site_down.php');
        else include('../pages/site_down.php');

        // exit(json_encode(array('result'=>0,'message'=>'Error while connecting to MAIN Database: '.$e->getMessage().'<br/>')));
        die();
    }
    echo '<p class="text-white">';
        print_r($_GET);
    echo '</p>';

    if(isset($_GET) && is_array($_GET) && count($_GET)>0) {
        foreach($_GET as $key=>$get) {
            if($key=='path') $GLOBALS['page']['slashes']=explode('/',$_GET['path']);
            else $GLOBALS['page']['query'][$key]=$get;
        }
    }

    if(!isset($GLOBALS['page']['slashes'])||$GLOBALS['page']['slashes']==''||!isset($GLOBALS['page']['slashes'][0])||$GLOBALS['page']['slashes'][0]=='') $GLOBALS['page']['slashes'][0]='home';

    // $GLOBALS['page']['info']=page::get_page($GLOBALS['page']['slashes'][0]);
    // if($GLOBALS['page']['info']['result']==0) $GLOBALS['page']['info']['data']=array(
    //     'id'=>null,
    //     'file'=>'404.png',
    //     'name'=>'Page not found',
    //     'url'=>'404',
    //     'stats'=>0
    // );
    // $GLOBALS['page']['info']=$GLOBALS['page']['info']['data'];

?>