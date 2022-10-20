<?php
    class session{
        public static function cullSession() {
            $_SESSION['user']=null;
            unset($_SESSION['user']);
        }
        public static function updateSession($id=null) {
            $row=home::doesResponseSessionExist($id);
            if($row===false) return false;

            if($row['completed']==1||$row['completed_time']!='') return false;
            $_SESSION['user']['name']=$row['name'];
            $_SESSION['user']['age']=$row['age'];
            $_SESSION['user']['gender']=$row['gender'];
            $_SESSION['user']['anonymous']=$row['anonymous'];
            return true;
        }
        public static function createSession($post) {
            if(!isset($post['name'])) return array('result'=>0,'message'=>'Name not set!');
            if(!isset($post['age'])) return array('result'=>0,'message'=>'Age not set!');
            if(!isset($post['gender'])) return array('result'=>0,'message'=>'Gender not set!');
    
            try {
                $sqllog = "INSERT INTO `tbl_response`(`name`,`age`,`gender`,`anonymous`,`register_time`) VALUES (:name,:age,:gender,:anon,:reg)";
                $qlog = $GLOBALS['database']->prepare($sqllog);
                $qlog->execute(array(':name'=>$post['name'],
                                    ':age'=>$post['age'],
                                    ':gender'=>$post['gender'],
                                    ':anon'=>(isset($post['anonymous'])&&($post['anonymous']==true?1:0)),
                                    ':reg'=>time()
                ));
            }catch(PDOException $e){
                return array('result'=>0,'message'=>'Error: '.$qlog->errorInfo());
            }
            $id=$GLOBALS['database']->lastInsertId();
            $_SESSION['user']['name']=$post['name'];
            $_SESSION['user']['age']=$post['gender'];
            $_SESSION['user']['gender']=$post['gender'];
            $_SESSION['user']['anonymous']=(isset($post['anonymous'])&&($post['anonymous']==true?1:0));
            $_SESSION['user']['id']=$id;
    
            return array('result'=>1,'message'=>'Created!');
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
    }
?>