<?php

    class home{
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