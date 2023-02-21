<?php
    class session{
        public static function cullSession() {
            $stmt_shopping_cart_u=$dbh->prepare('DELETE FROM `tbl_shopping_cart` WHERE `userid`=:userid');
            $stmt_shopping_cart_u->execute(array('userid'=>$_SESSION['smartshop']['id']));

            $_SESSION['smartshop']=null;
            unset($_SESSION['smartshop']);
        }
        public static function createSession($admin=false) {
            $_SESSION['smartshop']['id']=rand(1000,9999).rand(1000,9999);
            $_SESSION['smartshop']['admin']=$admin;
            return array('result'=>1,'message'=>'Created!');
        }
        public static function isLoggedIn() {
            return (isset($_SESSION['smartshop']['id'])&&is_numeric($_SESSION['smartshop']['id'])?true:false);
        }
        public static function isAdmin() {
            return (isset($_SESSION['smartshop']['admin'])?$_SESSION['smartshop']['admin']:false);
        }
    }

    class general {
        public static function url_exists($url=null) {
            if($url==null||empty($url)) return false;
            $file_headers=@get_headers($url);
            if(!is_array($file_headers)||!isset($file_headers[0])) return false;
            if(!is_numeric(strpos(strtolower($file_headers[0]),'ok'))) return false;
            return true;
        }
        public static function get_file($url=null) {
            if($url==null||empty($url)) return false;
            if(!self::url_exists($url)) return "23['".$url."]";
            return file_get_contents($url);
        }
        public static function isJSON($json='') {
            return is_string($json) && is_array(json_decode($json, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
        }
        public static function emoji_remove($text='') {
            $text = iconv('UTF-8', 'ISO-8859-15//IGNORE', $text);
            $text = preg_replace('/\s+/', ' ', $text);
            return iconv('ISO-8859-15', 'UTF-8', $text);
        }
    }

    class get_page {
        public static function get_url($__get=null) {
            global $_GET;
            $get=$_GET;
            if($__get!=null) $get=$__get;
            $data=[];
            if(isset($get['path'])) {
                $get=explode('/',$get['path']);
                $data=$get;
            }
            if(count($data)==0 || $data[0]=='') $data[0]='home';
            return $data;
        }
    }


    class shop{
        public static function does_category_exist($catid=null) {
            $stmt=$GLOBALS['database']->prepare('SELECT * FROM `tbl_categories` WHERE `id`=:id LIMIT 1');
            $stmt->execute(array('id'=>$catid));
            if($stmt->rowCount()==0) return array('result'=>false,'message'=>'Category does not exist!');
            return array('result'=>true,'message'=>'Category exists!');
        }
        public static function does_aisle_exist($aisleid=null) {
            $stmt=$GLOBALS['database']->prepare('SELECT * FROM `tbl_aisles` WHERE `id`=:id LIMIT 1');
            $stmt->execute(array('id'=>$aisleid));
            if($stmt->rowCount()==0) return array('result'=>false,'message'=>'Aisle does not exist!');
            return array('result'=>true,'message'=>'Aisle exists!');
        }
        public static function does_barcode_exist($barcode=null) {
            $stmt=$GLOBALS['database']->prepare('SELECT * FROM `tbl_products` WHERE `barcode`=:barcode LIMIT 1');
            $stmt->execute(array('barcode'=>$barcode));
            if($stmt->rowCount()>0) return array('result'=>true,'message'=>'Barcode exists!');
            return array('result'=>false,'message'=>'Barcode does not exist!');
        }
        public static function is_product_in_basket($barcode=null) {
            $stmt=$GLOBALS['database']->prepare('SELECT * FROM `tbl_shopping_cart` WHERE `barcode`=:barcode AND `userid`=:userid LIMIT 1');
            $stmt->execute(array('barcode'=>$barcode,'userid'=>$_SESSION['smartshop']['id']));
            if($stmt->rowCount()==0) return false;
            return true;
        }
    }
?>