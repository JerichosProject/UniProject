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
                    <a href="/home" class="mb-2">Go back</a>
                    <h2>What is this Website?</h2>
                    <p>
                        This website is being ran as part of a University Dissertation. Its intention is to assess whether customers require more information whilst in-store shopping.<br/>
                        The research is looking into current technologies being used, current ways of shopping in-store, what is the difference between online shopping and what do shops do to encourage in-store shopping.
                    </p>
                    <hr/>
                    <h2>What is being done differently in this research?</h2>
                    <p>
                        We are gathering several product and storing them on this site, we are then assiging alises, departments, stock levels, where the product is on the shelf, a map location (static image) where the product is, an online shopping list that will mark items off once scanned in-store and lastly, best directions to navigate the shop.
                    </p>
                    <hr/>
                    <h2>why is a Website needed?</h2>
                    <p>
                        To apply methods and run a test group, assessing if the information provided would be useful if the products and location were correct for a real life store. 
                    </p>
                    <hr/>
                    <h5></h5>
                    <p>
                        Need to contact me? <a href="mailto:1702201@student.uwtsd.ac.uk">1702201@student.uwtsd.ac.uk</a><br/>
                        <a href="/home" class="mt-2">Go back</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>