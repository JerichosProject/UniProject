<?php
    require('main.php');
    require('home_class.php');
	if(!defined('UniProjects')) exit(json_encode(array('result'=>0,'message'=>'Outside of the network?')));
    if(!isset($_POST,$_POST['type'])||empty($_POST['type'])) exit(json_encode(array('result'=>0,'message'=>'Type not known!')));

    $types=['session_started'];

    switch($_POST['type']) {
        case 'session_started':
            if(!isset($_SESSION['smartshop'])) exit(json_encode(array('result'=>1,'message'=>'Session not started','data'=>0)));
            exit(json_encode(array('result'=>1,'message'=>'Session started!','data'=>1,'admin'=>session::isAdmin())));
        break;
        case 'start_session':
            if(!isset($_POST['post']['password'])) exit(json_encode(array('result'=>0,'message'=>'Param missing, post.password!')));
            if(gettype($_POST['post']['password'])!=='string') exit(json_encode(array('result'=>0,'message'=>'Param post.password not string!')));

            if($_POST['post']['password']!='uniproject23'&&$_POST['post']['password']!='admin999') exit(json_encode(array('result'=>0,'message'=>'Password does not match required!')));

            $password=$_POST['post']['password'];

            $cses=session::createSession(($password=='admin999'?true:false));
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
                    'department'=>$products['catid'],
                    'in_cart'=>(shop::is_product_in_basket($products['barcode'])?1:0)
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
            exit(json_encode(array('result'=>1,'message'=>'Got products!',$_SESSION['smartshop']['id'],'data'=>$data)));
        break;
        case 'get_departments':
            if(!session::isLoggedIn()) exit(json_encode(array('result'=>1,'message'=>'Not logged in!')));

            $stmt_cat=$dbh->prepare('SELECT * FROM `tbl_categories`');
            $stmt_cat->execute();
            if($stmt_cat->rowCount()==0) exit(json_encode(array('result'=>0,'message'=>'No departments found!')));

            $rows_cat=$stmt_cat->fetchAll();
            $data=[];

            foreach($rows_cat as $cat) {
                $data['dept'][$cat['id']]=array(
                    'name'=>general::emoji_remove($cat['name']),
                    'urlname'=>general::emoji_remove($cat['urlname']),
                    'image'=>general::emoji_remove($cat['image']),
                );
            }
            exit(json_encode(array('result'=>1,'message'=>'Got departments!','data'=>$data)));
        break;
        case 'get_product':
            if(!isset($_POST['post']['producturl'])||empty($_POST['post']['producturl'])) exit(json_encode(array('result'=>1,'message'=>'Param post.producturl was empty or not set!')));
            $urlname=$_POST['post']['producturl'];
            if(!session::isLoggedIn()) exit(json_encode(array('result'=>1,'message'=>'Not logged in!')));
            $stmt_product=$dbh->prepare('SELECT * FROM `tbl_products` WHERE `urlname`=:urlname LIMIT 1');
            $stmt_product->execute(array('urlname'=>$urlname));
            if($stmt_product->rowCount()==0) exit(json_encode(array('result'=>0,'message'=>'No product found by urlname!')));

            $row_product=$stmt_product->fetch();

            $data['product']=array(
                'id'=>$row_product['id'],
                'barcode'=>$row_product['barcode'],
                'name'=>general::emoji_remove($row_product['name']),
                'url'=>general::emoji_remove($row_product['urlname']),
                'image'=>general::emoji_remove($row_product['image']),
                'price'=>$row_product['price'],
                'stock'=>$row_product['stock'],
                'shelf'=>$row_product['shelf'],
                'aisle'=>$row_product['aisleid'],
                'department'=>$row_product['catid'],
                'in_cart'=>(shop::is_product_in_basket($row_product['barcode'])?1:0),
                'json'=>home::get_product_cache($row_product['barcode'])
            );

            exit(json_encode(array('result'=>1,'message'=>'Got product!','data'=>$data)));
        break;
        case 'get_department_products':
            if(!isset($_POST['post']['departmenturl'])||empty($_POST['post']['departmenturl'])) exit(json_encode(array('result'=>1,'message'=>'Param post.departmenturl was empty or not set!')));
            $urlname=$_POST['post']['departmenturl'];

            $stmt_cat=$dbh->prepare('SELECT * FROM `tbl_categories` WHERE `urlname`=:urlname LIMIT 1');
            $stmt_cat->execute(array('urlname'=>strtolower($urlname)));
            if($stmt_cat->rowCount()==0) exit(json_encode(array('result'=>0,'message'=>'No department found!')));

            $row_cat=$stmt_cat->fetch();

            if(!session::isLoggedIn()) exit(json_encode(array('result'=>1,'message'=>'Not logged in!')));
            $stmt_products=$dbh->prepare('SELECT * FROM `tbl_products` WHERE `catid`=:catid LIMIT 30');
            $stmt_products->execute(array('catid'=>$row_cat['id']));
            if($stmt_products->rowCount()==0) exit(json_encode(array('result'=>0,'message'=>'No products found!')));

            $stmt_aisle=$dbh->prepare('SELECT * FROM `tbl_aisles`');
            $stmt_aisle->execute();
            if($stmt_aisle->rowCount()==0) exit(json_encode(array('result'=>0,'message'=>'No aisles found!')));

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
                    'department'=>$products['catid'],
                    'in_cart'=>(shop::is_product_in_basket($products['barcode'])?1:0)
                );
            }
            $data['dept'][$row_cat['id']]=array(
                'name'=>general::emoji_remove($row_cat['name']),
                'urlname'=>general::emoji_remove($row_cat['urlname']),
            );

            foreach($rows_aisle as $aisle) {
                $data['aisles'][$aisle['id']]=array(
                    'name'=>general::emoji_remove($aisle['name']),
                    'number'=>$aisle['number'],
                );
            }

            exit(json_encode(array('result'=>1,'message'=>'Got department product!','data'=>$data)));
        break;
        case 'amend_shopping_cart':
            if(!isset($_POST['post']['barcode'])||!is_numeric($_POST['post']['barcode'])) exit(json_encode(array('result'=>0,'message'=>'Param post.barcode not set or is not number!')));
            if(!isset($_POST['post']['action'])||empty($_POST['post']['action'])) exit(json_encode(array('result'=>0,'message'=>'Param post.action not set or is not number!')));

            $barcode=$_POST['post']['barcode'];
            $action=$_POST['post']['action'];

            $stmt_product=$dbh->prepare('SELECT `id` FROM `tbl_products` WHERE `barcode`=:barcode LIMIT 1');
            $stmt_product->execute(array('barcode'=>$barcode));
            if($stmt_product->rowCount()==0) exit(json_encode(array('result'=>0,'message'=>'Product was not found!')));

            //is product in shopping cart?
            $in_cart=shop::is_product_in_basket($barcode);
            if($action=='add') {
                if($in_cart) exit(json_encode(array('result'=>0,'message'=>'Product was already in cart!')));
                $stmt_cart_txt="INSERT INTO `tbl_shopping_cart`
                    (`userid`,`time`,`barcode`,`quantity`)
                    VALUES
                    (:userid,:time,:barcode,:quant)
                ";
                $stmt_cart=$dbh->prepare($stmt_cart_txt);
                $stmt_cart->execute(
                    array(
                        ':userid'=>$_SESSION['smartshop']['id'],
                        ':time'=>time(),
                        ':barcode'=>$barcode,
                        ':quant'=>1,
                    )
                );
                if($stmt_cart->rowCount()==0) exit(json_encode(array('result'=>0,'message'=>'Could not add to cart!')));
                exit(json_encode(array('result'=>1,'message'=>'Added to cart!')));
            }else{
                //remove
                $stmt_shopping_cart_u=$dbh->prepare('DELETE FROM `tbl_shopping_cart` WHERE `barcode`=:barcode AND `userid`=:userid LIMIT 1');
                $stmt_shopping_cart_u->execute(array('barcode'=>$barcode,'userid'=>$_SESSION['smartshop']['id']));
                if($stmt_shopping_cart_u->rowCount()==0) exit(json_encode(array('result'=>0,'message'=>'Product could not be deleted from cart!')));
                exit(json_encode(array('result'=>1,'message'=>'Deleted from cart!',$_SESSION['smartshop']['id'])));
            }
        break;
        case 'shopping_cart':
            $stmt_cart=$dbh->prepare('SELECT * FROM `tbl_shopping_cart` WHERE `userid`=:userid');
            $stmt_cart->execute(array('userid'=>$_SESSION['smartshop']['id']));
            if($stmt_cart->rowCount()==0) exit(json_encode(array('result'=>1,'message'=>'Shopping cart was empty!','data'=>array('no_products'=>'true'))));

            $rows_cart=$stmt_cart->fetchAll();

            $carts=[];

            $stmt_product=$dbh->prepare('SELECT * FROM `tbl_products` WHERE `barcode`=:barcode LIMIT 1');
            foreach($rows_cart as $cart) {
                $stmt_product->execute(array('barcode'=>$cart['barcode']));
                if($stmt_product->rowCount()==0) continue;

                $row_product=$stmt_product->fetch();

                $carts[]=array(
                    'id'=>$cart['id'],
                    'barcode'=>$cart['barcode'],
                    'time'=>date('d/M/Y H:i',$cart['time']),
                    'product'=>array(
                        'id'=>$row_product['id'],
                        'name'=>general::emoji_remove($row_product['name']),
                        'url'=>general::emoji_remove($row_product['urlname']),
                        'image'=>general::emoji_remove($row_product['image']),
                        'price'=>$row_product['price'],
                        'stock'=>$row_product['stock'],
                        'shelf'=>$row_product['shelf'],
                        'aisle'=>$row_product['aisleid'],
                        'department'=>$row_product['catid']
                    )
                );
            }
            exit(json_encode(array('result'=>1,'message'=>'Shopping cart!','data'=>$carts)));
        break;
        default:
            exit(json_encode(array('result'=>0,'message'=>'Unknown result!')));
        break;
    }

    exit(json_encode(array('result'=>0,'message'=>'Exited, unknown error!')));
?>