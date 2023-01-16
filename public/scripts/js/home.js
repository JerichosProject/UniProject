var debug=true;
//signing in [
    function initaliseHome() {
        $.post('/scripts/home.php',{type:'session_started'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;
            if(result==0) {
                //not logged in
                $('#auth div[attr=init]').slideUp(500);
                $('#auth div[attr=signin]').delay(800).slideDown(500);
            }else{
                //logged in, ask them if they want to continue!
                $('#auth').fadeOut(500);
                getWindowPane(true);
                $('#app').delay(800).fadeIn(500);
            }
        });
    }

    $(document).on('click','#auth div[attr=signin] button',function() {
        let password=$('#auth div[attr=signin] input').eq(0).val();
        if(password=='') return;

        $.post('/scripts/home.php',{type:'start_session',post:{password:password}},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}

            $('#auth').fadeOut(500);
            getWindowPane(true);
            $('#app').delay(800).fadeIn(500);
        });
    });
//end signing in ]

// show all products [
    function showAllProducts() {
        $('.app-window').hide();
        $('.app-window[attr=home]').show();
        $.post('/scripts/home.php',{type:'get_products'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;
            
            let out='';
            $.each(result.products,function(index,product) {
                // out+='<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
                    out+='<div class="col mb-5">';
                        out+='<div class="card h-100">';
                            out+='<img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="...">';
                            out+='<div class="card-body p-4">';
                                out+='<div class="text-center">';
                                    out+='<h5 class="fw-bolder">'+product.name+'</h5>';
                                    out+='£'+product.price+(product.stock<50?' / '+product.stock+' left':'');
                                out+='</div>';
                            out+='</div>';
                            out+='<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
                                out+='<div class="text-center">';
                                    out+='<button class="btn btn-sm btn-outline-dark mt-auto app-nav-update" attr="item" barcode="'+product.barcode+'" uid="'+product.id+'">View</button> ';
                                    out+='<button class="btn btn-sm btn-outline-warning mt-auto app-nav-shop-list" attr="add" barcode="'+product.barcode+'" uid="'+product.id+'">Add to list</button>';
                                out+='</div>';

                                if(product.department!='' && result.dept[parseInt(product.department)]!=undefined) {
                                    out+='<div class="text-left"><small><b>Department</b> '+result.dept[product.department].name+'</small></div>';
                                }

                                if(product.aisle!='' && result.aisles[product.aisle]!=undefined) {
                                    out+='<div class="text-left"><small><b>Aisle</b> ('+result.aisles[product.aisle].number+') '+result.aisles[product.aisle].name+'<br/><b>Shelf</b> '+product.shelf+'</small></div>';
                                }
                            out+='</div>';
                        out+='</div>';
                    out+='</div>';
                // out+='</div>';
            });
            $('.app-window[attr=home]').html('<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">'+out+'</div>');
        }).always(function(){
        });
    }
// end of show all products ]

// window pane [
    function getWindowPane(caller) {
        //  if caller equals true then its being called via the onload func;

        let url=(window.location.pathname).substring(1);
        url=url.split('/');

        if(url[0]!=undefined) {
            if(url[0]=='home' || url[0]=='') {
                //  show products!
                showAllProducts();
            }else if(url[0]=='logout') logout();
        }

    }
// end of window pane ]

$(document).ready(function(){
    initaliseHome();
});