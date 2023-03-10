<?php
    require('main.php');
    require('admin_class.php');
	if(!defined('UniProjects')) exit(json_encode(array('result'=>0,'message'=>'Outside of the network?')));
    if(!session::isLoggedIn()) exit(json_encode(array('result'=>1,'message'=>'Not logged in!')));
    if(!isset($_SESSION['smartshop']['admin'])||$_SESSION['smartshop']['admin']===false) exit(json_encode(array('result'=>1,'message'=>'You are not an administrator!')));
    if(!isset($_POST,$_POST['type'])||empty($_POST['type'])) exit(json_encode(array('result'=>0,'message'=>'Type not known!')));

    $types=['get_all_categories','get_all_aisle','create_category','create_aisle','create_product'];


    switch($_POST['type']) {
        case 'get_all_categories':
            $data=[];
            $stmt_categories=$dbh->prepare('SELECT * FROM `tbl_categories`');
            $stmt_categories->execute();
            if($stmt_categories->rowCount()>0) {
                $rows_categories=$stmt_categories->fetchAll();
                foreach($rows_categories as $cat) {
                    $data[]=array(
                        'id'=>$cat['id'],
                        'name'=>$cat['name'],
                        'urlname'=>$cat['urlname'],
                        'image'=>$cat['image']
                    );
                }
            }
            exit(json_encode(array('result'=>1,'message'=>'Got all categories!','data'=>$data)));
        break;
        case 'create_category':
            if(!isset($_POST['post']['name'])||empty($_POST['post']['name'])) exit(json_encode(array('result'=>10,'message'=>'Param post.name not set or is empty!')));
            if(!isset($_POST['post']['urlname'])||empty($_POST['post']['urlname'])) exit(json_encode(array('result'=>0,'message'=>'Param post.urlname not set or is empty!')));

            $name=preg_replace('/\s+/', ' ',substr($_POST['post']['name'],0,60));
            $urlname=preg_replace('/\s+/', ' ',substr($_POST['post']['urlname'],0,60));

            $image="";
            if(isset($_POST['post']['image'])&&!empty($_POST['post']['image'])) $image=preg_replace('/\s+/', ' ',substr($_POST['post']['image'],0,60));

            $stmt_cat_txt="INSERT INTO `tbl_categories`
                (`name`,`urlname`,`image`)
                VALUES
                (:name,:urlname,:image)
            ";
            $stmt_cat=$dbh->prepare($stmt_cat_txt);
            $stmt_cat->execute(
                array(
                    ':name'=>$name,
                    ':urlname'=>$urlname,
                    ':image'=>$image,
		        )
            );
		    // if($stmt_cat->rowCount()>0) return array('result'=>1,'message'=>'Done!','id'=>$dbh->lastInsertId());
            exit(json_encode(array('result'=>1,'message'=>'Created category!')));
        break;
        case 'get_all_aisle':
            $data=[];
            $stmt_ailses=$dbh->prepare('SELECT * FROM `tbl_aisles`');
            $stmt_ailses->execute();
            if($stmt_ailses->rowCount()>0) {
                $rows_ailses=$stmt_ailses->fetchAll();
                foreach($rows_ailses as $ailse) {
                    $data[]=array(
                        'id'=>$ailse['id'],
                        'name'=>$ailse['name'],
                        'number'=>$ailse['number']
                    );
                }
            }
            exit(json_encode(array('result'=>1,'message'=>'Got all aisles!','data'=>$data)));
        break;
        case 'create_aisle':
            if(!isset($_POST['post']['name'])||empty($_POST['post']['name'])) exit(json_encode(array('result'=>10,'message'=>'Param post.name not set or is empty!')));
            if(!isset($_POST['post']['number'])||!is_numeric($_POST['post']['number'])) exit(json_encode(array('result'=>0,'message'=>'Param post.number not set or is not number!')));

            $name=preg_replace('/\s+/', ' ',substr($_POST['post']['name'],0,60));
            $number=preg_replace('/\s+/', ' ',substr($_POST['post']['number'],0,60));
            if($number<0||$number>100) exit(json_encode(array('result'=>0,'message'=>'Aisle (post.number) was out of bounds (less than zero or more than one hundred)!')));

            $stmt_ins_txt="INSERT INTO `tbl_aisles`
                (`name`,`number`)
                VALUES
                (:name,:number)
            ";
            $stmt_ins=$dbh->prepare($stmt_ins_txt);
            $stmt_ins->execute(
                array(
                    ':name'=>$name,
                    ':number'=>$number
		        )
            );
		    // if($stmt_ins->rowCount()>0) return array('result'=>1,'message'=>'Done!','id'=>$dbh->lastInsertId());
            exit(json_encode(array('result'=>1,'message'=>'Created aisle!')));
        break;
        case 'create_product':
            if(!isset($_POST['post']['urlname'])||empty($_POST['post']['urlname'])) exit(json_encode(array('result'=>10,'message'=>'Param post.urlname not set or is empty!')));
            if(!isset($_POST['post']['price'])||empty($_POST['post']['price'])) exit(json_encode(array('result'=>10,'message'=>'Param post.price not set or is empty!')));

            if(!isset($_POST['post']['barcode'])||!is_numeric($_POST['post']['barcode'])) exit(json_encode(array('result'=>0,'message'=>'Param post.barcode not set or is not number!')));
            if(!isset($_POST['post']['categiries'])||!is_numeric($_POST['post']['categiries'])) exit(json_encode(array('result'=>0,'message'=>'Param post.categiries not set or is not number!')));
            if(!isset($_POST['post']['aisles'])||!is_numeric($_POST['post']['aisles'])) exit(json_encode(array('result'=>0,'message'=>'Param post.aisles not set or is not number!')));
            if(!isset($_POST['post']['shelf'])||!is_numeric($_POST['post']['shelf'])) exit(json_encode(array('result'=>0,'message'=>'Param post.shelf not set or is not number!')));
            if(!isset($_POST['post']['stock'])||!is_numeric($_POST['post']['stock'])) exit(json_encode(array('result'=>0,'message'=>'Param post.stock not set or is not number!')));

            $name='';
            if(isset($_POST['post']['name'])&&!empty($_POST['post']['name'])) $name=preg_replace('/\s+/', ' ',substr($_POST['post']['name'],0,60));

            $urlname=strtolower(preg_replace('/\s+/', '_',substr($_POST['post']['urlname'],0,60)));
            $image='';
            if(isset($_POST['post']['price'])&&empty($_POST['post']['price'])) $image=strtolower(preg_replace('/\s+/', '_',substr($_POST['post']['image'],0,60)));

            $barcode=preg_replace('/\s+/', ' ',substr($_POST['post']['barcode'],0,60));
            if($barcode<0) exit(json_encode(array('result'=>0,'message'=>'Product (post.barcode) was out of bounds (less than zero or more than one hundred)!')));

            $categiries=preg_replace('/\s+/', ' ',$_POST['post']['categiries']);
            if($categiries<0||$categiries>9999) exit(json_encode(array('result'=>0,'message'=>'Product (post.categiries) was out of bounds (less than zero or more than one hundred)!')));

            $aisles=preg_replace('/\s+/', ' ',$_POST['post']['aisles']);
            if($aisles<0||$aisles>9999) exit(json_encode(array('result'=>0,'message'=>'Product (post.aisles) was out of bounds (less than zero or more than one hundred)!')));

            $shelf=preg_replace('/\s+/', ' ',$_POST['post']['shelf']);
            if($shelf<0||$shelf>100) exit(json_encode(array('result'=>0,'message'=>'Product (post.shelf) was out of bounds (less than zero or more than one hundred)!')));

            $price=preg_replace('/\s+/', ' ',$_POST['post']['price']);
            if($price<0||$price>2000) exit(json_encode(array('result'=>0,'message'=>'Product (post.price) was out of bounds (less than zero or more than one hundred)!')));

            $stock=preg_replace('/\s+/', ' ',$_POST['post']['stock']);
            if($stock<0||$stock>7000) exit(json_encode(array('result'=>0,'message'=>'Product (post.stock) was out of bounds (less than zero or more than one hundred)!')));

            $tags="";
            if(isset($_POSt['post']['tags'])&&!empty($_POST['post']['tags'])) $tags=$_POST['post']['tags'];
            $coords="";
            if(isset($_POSt['post']['coords'])&&!empty($_POST['post']['tags'])) $coords=$_POST['post']['coords'];

            if(!shop::does_category_exist($categiries)) exit(json_encode(array('result'=>0,'message'=>'Category does not exist!')));
            if(!shop::does_aisle_exist($aisles)) exit(json_encode(array('result'=>0,'message'=>'Aisle does not exist!')));

            $b=barcode::create_barcode($barcode);
            $apilink="";

            if(!$b['result']) exit(json_encode(array('result'=>0,'message'=>'Barcode API error, '.$b['message'].'!')));
            $apilink='done';
            if($name=='') $name=$b['data']['name'];

            $stmt_ins_txt="INSERT INTO `tbl_products`
                (`name`,`urlname`,`barcode`,`apilink`,`price`,`stock`,`image`,`catid`,`aisleid`,`shelf`,`tags`,`locations`)
                VALUES
                (:name,:urlname,:barcode,:apilink,:price,:stock,:image,:catid,:aisleid,:shelf,:tags,:coords)
            ";
            $stmt_ins=$dbh->prepare($stmt_ins_txt);
            $stmt_ins->execute(
                array(
                    ':name'=>$name,
                    ':urlname'=>$urlname,
                    ':barcode'=>$barcode,
                    ':apilink'=>$apilink,
                    ':price'=>$price,
                    ':stock'=>$stock,
                    ':image'=>$image,
                    ':catid'=>$categiries,
                    ':aisleid'=>$aisles,
                    ':shelf'=>$shelf,
                    ':tags'=>$tags,
                    ':coords'=>$coords
		        )
            );
		    // if($stmt_ins->rowCount()>0) return array('result'=>1,'message'=>'Done!','id'=>$dbh->lastInsertId());
            exit(json_encode(array('result'=>1,'message'=>'Created product!')));
        break;
        case 'create_product_info':
            exit('tes');
            if(!isset($_POST['post']['barcode'])||!is_numeric($_POST['post']['barcode'])) exit(json_encode(array('result'=>0,'message'=>'Param post.barcode not set or is not number!')));

            $barcode=preg_replace('/\s+/', ' ',substr($_POST['post']['barcode'],0,60));
            if($barcode<0) exit(json_encode(array('result'=>0,'message'=>'Product (post.barcode) was out of bounds (less than zero or more than one hundred)!')));

            
            $read=barcode::read_barcode_file($barcode);
            if(!$read['result']) {
                $b=barcode::create_barcode($barcode);
                if(!$b['result']) exit(json_encode(array('result'=>0,'message'=>'Barcode API error, '.$b['message'].'!')));
            }

            $read=barcode::read_barcode_file($barcode);
            if(!$read['result']) exit(json_encode(array('result'=>0,'message'=>'Error, message: '.$read['message'])));

            exit(json_encode(array('result'=>1,'message'=>'Reading file!','data'=>$read['data'])));
        break;
        default:
            exit(json_encode(array('result'=>0,'message'=>'Unknown result!')));
        break;
    }

    exit(json_encode(array('result'=>0,'message'=>'Exited, unknown error!')));
?>