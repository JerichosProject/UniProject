<?php

    if(!defined('UniProjects')) exit(json_encode(array('result'=>false,'message'=>'Outside of the network?')));

    class home{
        public static function randomThing($type=0) {
            if($type==0) return 'anon-'.rand(0,1000);
            elseif($type==1) return rand(18,95);
            elseif($type==2) return (rand(0,1)==0?'male':(rand(0,1)==0?'female':'none specified'));
            else return '';
        }
        public static function get_product_cache($barcode=null) {
            $url='../../barcode_cache/'.$barcode.'.json';
            if(!file_exists($url)) return "no";
            return file_get_contents($url);
        }
    }

?>