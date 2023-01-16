<?php
    require('main.php');
    require('home_class.php');
	if(!defined('UniProjects')) exit(json_encode(array('result'=>0,'message'=>'Outside of the network?')));
    if(!isset($_POST,$_POST['type'])||empty($_POST['type'])) exit(json_encode(array('result'=>0,'message'=>'Type not known!')));

    $types=['session_started'];

    switch($_POST['type']) {
        case 'session_started':
            if(!isset($_SESSION['smartshop'])) exit(json_encode(array('result'=>1,'message'=>'Session not started','data'=>0)));
            exit(json_encode(array('result'=>1,'message'=>'Session started!','data'=>1)));
        break;
        case 'start_session':
            if(!isset($_POST['post']['password'])) exit(json_encode(array('result'=>0,'message'=>'Param missing, post.password!')));
            if(gettype($_POST['post']['password'])!=='string') exit(json_encode(array('result'=>0,'message'=>'Param post.password not string!')));

            if($_POST['post']['password']!='uniproject23') exit(json_encode(array('result'=>0,'message'=>'Password does not match required!')));

            $password=$_POST['post']['password'];

            $cses=session::createSession();
            if($cses['result']==0) {
                exit(json_encode(array('result'=>0,'message'=>'Error: '.$cses['message'])));
            }
            exit(json_encode(array('result'=>1,'message'=>'Created session.')));
        break;
        case 'session_logout':
            if(!isset($_SESSION['smartshop']['id'])||!is_numeric($_SESSION['smartshop']['id'])) exit(json_encode(array('result'=>1,'message'=>'Your session was not set!')));
            session::cullSession();
            exit(json_encode(array('result'=>1,'message'=>'Ended!')));
        break;

        case 'get_products':
            if(!session::isLoggedIn()) exit(json_encode(array('result'=>1,'message'=>'Not logged in!')));
            $stmt_products=$dbh->prepare('SELECT * FROM `tbl_products` LIMIT 30');
            $stmt_products->execute();
            if($stmt_products->rowCount()==0) exit(json_encode(array('result'=>0,'message'=>'No products found!')));

            $stmt_aisle=$dbh->prepare('SELECT * FROM `tbl_aisles`');
            $stmt_aisle->execute();
            if($stmt_aisle->rowCount()==0) exit(json_encode(array('result'=>0,'message'=>'No aisles found!')));

            $stmt_cat=$dbh->prepare('SELECT * FROM `tbl_categories`');
            $stmt_cat->execute();
            if($stmt_cat->rowCount()==0) exit(json_encode(array('result'=>0,'message'=>'No departments found!')));

            $rows_cat=$stmt_cat->fetchAll();
            $rows_aisle=$stmt_aisle->fetchAll();
            $rows_products=$stmt_products->fetchAll();
            $data=[];
            foreach($rows_products as $products) {
                $data['products'][]=array(
                    'id'=>$products['id'],
                    'barcode'=>$products['barcode'],
                    'name'=>general::emoji_remove($products['name']),
                    'url'=>general::emoji_remove($products['urlname']),
                    'image'=>general::emoji_remove($products['image']),
                    'price'=>$products['price'],
                    'stock'=>$products['stock'],
                    'shelf'=>$products['shelf'],
                    'aisle'=>$products['aisleid'],
                    'department'=>$products['catid']
                );
            }
            foreach($rows_cat as $cat) {
                $data['dept'][$cat['id']]=array(
                    'name'=>general::emoji_remove($cat['name']),
                    'urlname'=>general::emoji_remove($cat['urlname']),
                );
            }
            foreach($rows_aisle as $aisle) {
                $data['aisles'][$aisle['id']]=array(
                    'name'=>general::emoji_remove($aisle['name']),
                    'number'=>$aisle['number'],
                );
            }
            exit(json_encode(array('result'=>1,'message'=>'Got products!','data'=>$data)));
        break;
        default:
            exit(json_encode(array('result'=>0,'message'=>'Unknown result!')));
        break;
    }

    exit(json_encode(array('result'=>0,'message'=>'Exited, unknown error!')));
?>