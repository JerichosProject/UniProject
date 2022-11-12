<?php

    class home{
        public static function doesResponseSessionExist($id=null) {
            $stmt=$GLOBALS['database']->prepare('SELECT * FROM `tbl_response` WHERE `id`=? LIMIT 1');
            $stmt->execute(array($id));
            if($stmt->rowCount()==0) return false;
            $row=$stmt->fetch();
            if(!isset($row['id'])) return false;
            return $row;
        }
        public static function generateNewQuestion() {
            $stmt=$GLOBALS['database']->prepare('SELECT * FROM `tbl_websites` WHERE `visible`=0 ORDER BY RAND() LIMIT 1');
            $stmt->execute();
            if($stmt->rowCount()==0) return false;
            $row=$stmt->fetch();

            $response=general::get_file($row['url']);
            if($response===false) return array('result'=>0,'message'=>'URL not found!');
            if(empty($response)) return array('result'=>0,'message'=>'Response was empty!');
            if(!general::isJSON($response)) return array('result'=>0,'message'=>'Response was not formatted JSON!');
            $response=json_decode($response,true);

            $code_vals=(general::isJSON($row['code'])?json_decode($row['code'],true):'');
            $rules=home::rules();
            if(is_array($code_vals)&&count($code_vals)>0) {
                foreach($code_vals as $k=>$v) {
                    // print $k.' '.$v.' - '.(isset($rules[$v])?'yes':'no');
                    if(isset($rules[$k])) $rules[$k]=true;
                }
            }

            $data=[];

            foreach($response as $resp) {
                if($rules['id']) {
                    //need to query an alternative url with id!
                    $alt_response=general::url_exists($row['id_url'].$resp[$code_vals['id']]);
                    if(!$alt_response) continue;
                    if(empty($alt_response)) continue;
                    if(!general::isJSON($alt_response)) continue;
                    $alt_response=json_decode($alt_response,true);
                }else{
                    if($row['data_type']==4) { //point
                        $value=($rules['val']?$resp[$code_vals['val']]:$resp['id']);
                        $data['response'][]=$value;
                    }
                }
            }

            $data['graph_type']=$row['data_type'];
            $data['url']=$row['url'];
            $data['name']=$row['name'];
            $data['code']=$code_vals;
            $data['rules']=$rules;


            return array('result'=>1,'data'=>$data);
        }
        public static function rules() {
            $rules=array(
                'id'=>false,
                'val'=>false
            );
            return $rules;
        }


        public static function randomThing($type=0) {
            if($type==0) return 'anon-'.rand(0,1000);
            elseif($type==1) return rand(18,95);
            elseif($type==2) return (rand(0,1)==0?'male':(rand(0,1)==0?'female':'none specified'));
            else return '';
        }
        public static function get_question_number($id=null) {
            if(!self::doesResponseSessionExist($id)) return 0;
            $stmt=$GLOBALS['database']->prepare('SELECT * FROM `tbl_response_graph_data` WHERE `response_id`=? LIMIT 1');
            $stmt->execute(array($id));
            if($stmt->rowCount()==0) return 1;
            return $stmt->rowCount();
        }
    }

?>