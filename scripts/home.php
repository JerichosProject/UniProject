<?php
    require('main.php');
    require('home_class.php');
	if(!defined('UniProjects')) exit(json_encode(array('result'=>0,'message'=>'Outside of the network?')));
    if(!isset($_POST,$_POST['type'])||empty($_POST['type'])) exit(json_encode(array('result'=>0,'message'=>'Type not known!')));

    $types=['session_started'];

    switch($_POST['type']) {
        case 'session_started':
            if(!isset($_SESSION['user'])) exit(json_encode(array('result'=>1,'message'=>'Session not started','data'=>0)));
            $ups=session::updateSession($_SESSION['user']['id']);
            if(!$ups) {
                session::cullSession();
                exit(json_encode(array('result'=>1,'message'=>'Session ended!','data'=>0)));
            }
            //okay, lets get the current graph!
            exit(json_encode(array('result'=>1,'message'=>'Session started!','data'=>1,'anonymous'=>$_SESSION['user']['anonymous'])));
        break;
        case 'start_session':
            if(!isset($_POST['post']['name'],$_POST['post']['age'],$_POST['post']['gender'],$_POST['post']['anonymous'])) exit(json_encode(array('result'=>0,'message'=>'Post data not set, requires: name, age, gender & anonymous!')));
            if(
                empty($_POST['post']['name']) &&
                empty($_POST['post']['age']) &&
                empty($_POST['post']['gender']) &&
                ($_POST['post']['anonymous']==false||$_POST['post']['anonymous']=='false')
            ) exit(json_encode(array('result'=>0,'message'=>'Post data not correct, requires: name [string], age [int], gender [string] OR anonymous [bool]!')));

            $name=$_POST['post']['name'];
            $age=$_POST['post']['age'];
            $gender=$_POST['post']['gender'];
            $anonymous=((gettype($_POST['post']['anonymous'])=='string'&&$_POST['post']['anonymous']=='true')||(gettype($_POST['post']['anonymous'])=='bool'&&$_POST['post']['anonymous']==true)?true:false);

            if(!$anonymous) {
                if(strlen($name)<0||strlen($name)>30) exit(json_encode(array('result'=>0,'message'=>'Name length was less than 0 or more than 30!')));
                if(strlen($gender)<0||strlen($gender)>30) exit(json_encode(array('result'=>0,'message'=>'Gender length was less than 0 or more than 30!')));

                if(!is_numeric($age)||$age<18||$age>100) exit(json_encode(array('result'=>0,'message'=>'Age is not a number or is outside of paramaters from 18 to 100!')));
            }else{
                $name=home::randomThing(0);
                $age=home::randomThing(1);
                $gender=home::randomThing(2);
            }
            $cses=session::createSession(array('name'=>$name,'age'=>$age,'gender'=>$gender,'anonymous'=>$anonymous));
            if($cses['result']==0) {
                exit(json_encode(array('result'=>0,'message'=>'Error: '.$cses['message'])));
            }
            exit(json_encode(array('result'=>1,'message'=>'Created session.','anonymous'=>$anonymous)));
        break;
        case 'session_withdraw':
            if(!isset($_SESSION['user']['id'])||!is_numeric($_SESSION['user']['id'])) exit(json_encode(array('result'=>0,'message'=>'You session was not set!')));

            $stmt=$GLOBALS['database']->prepare('DELETE FROM `tbl_response_graph_data` WHERE `response_id`=?');
            $stmt->execute(array($_SESSION['user']['id']));

            $stmt=$GLOBALS['database']->prepare('UPDATE `tbl_response` SET `name`="",`age`="",`gender`="",`deleted`=1 WHERE `id`=?');
            $stmt->execute(array($_SESSION['user']['id']));
            session::cullSession();
            exit(json_encode(array('result'=>1,'message'=>'Withdrawn!')));
        break;
        case 'session_endsurvey':
            if(!isset($_SESSION['user']['id'])||!is_numeric($_SESSION['user']['id'])) exit(json_encode(array('result'=>0,'message'=>'You session was not set!')));

            $stmt=$GLOBALS['database']->prepare('UPDATE `tbl_response` SET `completed`=1,`completed_time`=? WHERE `id`=?');
            $stmt->execute(array(time(),$_SESSION['user']['id']));
            session::cullSession();
            exit(json_encode(array('result'=>1,'message'=>'Ended!')));
        break;
        case 'session_anonymous':
            if(!isset($_SESSION['user']['id'])||!is_numeric($_SESSION['user']['id'])) exit(json_encode(array('result'=>0,'message'=>'You session was not set!')));

            $stmt=$GLOBALS['database']->prepare('UPDATE `tbl_response` SET `name`=?,`age`=?,`gender`=?,`anonymous`=1 WHERE `id`=?');
            $stmt->execute(array(home::randomThing(0),home::randomThing(1),home::randomThing(2),$_SESSION['user']['id']));
            exit(json_encode(array('result'=>1,'message'=>'Anonymous person :D')));
        break;


        case 'generate_new_question':
            $row=home::doesResponseSessionExist($_SESSION['user']['id']);
            if($row===false) {
                exit(json_encode(array('result'=>0,'message'=>'Whoops, your session is not yet set!')));
            }
            //generate a new question!
            $qu=home::generateNewQuestion();
            if($qu['result']==0) exit(json_encode(array('result'=>0,'message'=>'Cannot generate a new question! '.$qu['message'])));

            exit(json_encode(array('result'=>1,'message'=>'Generated question!','data'=>array('question_number'=>home::get_question_number($_SESSION['user']['id']),'response'=>$qu['data']))));
        break;
        default:
            exit(json_encode(array('result'=>0,'message'=>'Unknown result!')));
        break;
    }

    exit(json_encode(array('result'=>0,'message'=>'Exited, unknown error!')));
?>