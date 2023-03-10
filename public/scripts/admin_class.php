<?php

    if(!defined('UniProjects')) exit(json_encode(array('result'=>false,'message'=>'Outside of the network?')));

    class barcode {
        public static function create_barcode($barcode=null) {
            if($barcode==null) return array('result'=>false,'message'=>'Barcode was empty!');
            if(shop::does_barcode_exist($barcode)===true) return array('result'=>false,'message'=>'Barcode already existed in dB, not wasting API request!');

            $url='https://api.barcodelookup.com/v3/products?barcode='.$barcode.'&formatted=y&key='.$GLOBALS['creds']['barcode_key'];
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL            => $url,
                CURLOPT_HTTPHEADER     => array('Content-Type: application/json'),
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_VERBOSE        => 1,
                CURLOPT_POST           =>0,
                // CURLOPT_POSTFIELDS     => '{"barcode": "'.$barcode.'"}",
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_CUSTOMREQUEST  => "GET"
            ));
            $responses = curl_exec($ch);
            // $info=curl_getinfo($ch);
            curl_close($ch);

            
            if($responses=='') return array('result'=>0,'message'=>'Cannot create file, error: cannot_create_with_class_02; barcode expired?');

            $file_url='';
            if(file_exists('../../../barcode_cache/info.txt')) $file_url='../../../barcode_cache';
            elseif(file_exists('../../barcode_cache/info.txt')) $file_url='../../barcode_cache';
            elseif(file_exists('../barcode_cache/info.txt')) $file_url='../barcode_cache';
            else return array('result'=>false,'message'=>'Could not create file, could not risk creating in an unknown directory.');

            // try{
                echo $file_url.'/'.$barcode.'.json\n\n\n';
                // $file_handle = fopen($file_url.'/'.$barcode.'.json', 'w');
                // fwrite($file_handle, $responses);
                // fclose($file_handle);
            // }catch(Exception $e){
            //     return array('result'=>0,'message'=>'Cannot create file, error: cannot_create_with_class_01');
            // }

            return array('result'=>false,$file_url);
            $name='';
            // print_r($responses);
            if(general::isJSON($responses)) $responses=json_decode($responses,true);

            if(isset($responses['products'][0]['title'])) $name=$responses['products'][0]['title'];
            return array('result'=>true,'message'=>'Create barcode entry!','data'=>array('name'=>$name,'response'=>$responses));
        }
        public static function read_barcode_file($barcode=null) {
            if($barcode==null) return array('result'=>false,'message'=>'Barcode was empty!');

            $file_url='';
            if(file_exists('../../../barcode_cache/info.txt')) $file_url='../../../barcode_cache';
            elseif(file_exists('../../barcode_cache/info.txt')) $file_url='../../barcode_cache';
            elseif(file_exists('../barcode_cache/info.txt')) $file_url='../barcode_cache';
            else return array('result'=>false,'message'=>'Could not get in info, could not risk creating in an unknown directory.');

            if(!file_exists($file_url.'/'.$barcode.'.json')) return array('result'=>false,'message'=>'Barcode file was not found, did you actually add it?');

            $file_handle=file_get_contents($file_url.'/'.$barcode.'.json');
            $file_handle=json_decode($file_handle,true);
            return array('result'=>true,'message'=>'Success','data'=>$file_handle);
        }
        /*
            {
                "products": [
                    {
                        "barcode_number": "886736874135",
                        "barcode_formats": "UPC-A 886736874135, EAN-13 0886736874135",
                        "mpn": "CE-XLR3200",
                        "model": "XLR",
                        "asin": "B01KUHG2G8",
                        "title": "Nike Red Running Shoes - Size 10",
                        "category": "Media > Books > Print Books",
                        "manufacturer": "Xerox",
                        "brand": "Xerox",
                        "contributors": [
                            {
                                "role": "author",
                                "name": "Blake, Quentin"
                            },
                            {
                                "role": "publisher",
                                "name": "Greenwillow Books"
                            }
                        ],
                        "age_group": "adult",
                        "ingredients": "Organic Tapioca Syrup, Organic Dried Cane Syrup, Natural Flavor.",
                        "nutrition_facts": "Protein 0 G, Total lipid (fat) 0 G, Energy 300 KCAL, Sugars, total including NLEA 40 G.",
                        "energy_efficiency_class": "A+ (A+++ to D)",
                        "color": "blue",
                        "gender": "female",
                        "material": "cloth",
                        "pattern": "checkered",
                        "format": "DVD",
                        "multipack": "8",
                        "size": "7 US",
                        "length": "45 in",
                        "width": "30 in",
                        "height": "22 in",
                        "weight": "7 lb",
                        "release_date": "2003-07-28",
                        "description": "One of a kind, Nike Red Running Shoes that are great for walking, running and sports.",
                        "features": [
                            "Rugged construction",
                            "Convenient carrying case",
                            "5 year warranty"
                        ],
                        "images": [
                            "https://images.barcodelookup.com/5219/52194594-1.jpg",
                            "https://images.barcodelookup.com/5219/52194594-2.jpg",
                            "https://images.barcodelookup.com/5219/52194594-3.jpg"
                        ],
                        "last_update": "2022-03-03 20:28:19",
                        "stores": [
                            {
                                "name": "Newegg.com",
                                "country": "US",
                                "currency": "USD",
                                "currency_symbol": "$",
                                "price": "41.38",
                                "sale_price": "35.99",
                                "tax": [
                                    {
                                        "country": "US",
                                        "region": "US",
                                        "rate": "5.00",
                                        "tax_ship": "no"
                                    }
                                ],
                                "link": "https://www.newegg.com/product-link",
                                "item_group_id": "AB-4312",
                                "availability": "in stock",
                                "condition": "new",
                                "shipping": [
                                    {
                                        "country": "US",
                                        "region": "US",
                                        "service": "Standard",
                                        "price": "8.49 USD"
                                    }
                                ],
                                "last_update": "2021-05-19 09:07:42"
                            },
                            .....,
                            .....
                        ],
                        "reviews": [
                            {
                                "name": "Josh Keller",
                                "rating": "5",
                                "title": "Love these shoes!",
                                "review": "A stylish and great fitting shoe for walking and running.",
                                "date": "2015-03-19 21:48:03"
                            },
                            .....,
                            .....
                        ]
                    }
                ]
            }
        */
    }
?>