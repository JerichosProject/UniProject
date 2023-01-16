<?php
    class session{
        public static function cullSession() {
            $_SESSION['smartshop']=null;
            unset($_SESSION['smartshop']);
        }
        public static function createSession() {
            $_SESSION['smartshop']['id']=rand(1000,9999).rand(1000,9999);
            return array('result'=>1,'message'=>'Created!');
        }
        public static function isLoggedIn() {
            return (isset($_SESSION['smartshop']['id'])&&is_numeric($_SESSION['smartshop']['id'])?true:false);
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
            if(!self::url_exists($url)) return false;
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
        public static function get_url() {
            global $_GET;
            $get=$_GET;
            $data=[];
            if(isset($get['path'])) {
                $get=explode('/',$get['path']);
                $data=$get;
            }
            if(count($data)==0 || $data[0]=='') $data[0]='home';
            return $data;
        }
    }
?>