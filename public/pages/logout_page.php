<?php
    if(!defined('UniProjects')) {
        $GLOBALS['errors'][]='Outside of the Project network!';
        include_once('site_down.php');
        die();
        // die(json_encode(array('result'=>0,'message'=>'Outside of the project network?')));
    }
?>
<div class="container">
    <div class="row h-100">
        <div class="col-12">
            <div class="row d-flex align-items-center justify-content-center vh-100 text-white text-center">
                <div class="col-12">
                    <div class="alert alert-warning">
                        <h3>Logging out!</h3>
                        <p>Please wait.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>