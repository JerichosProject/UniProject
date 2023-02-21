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

// nav panel [
    $(document).on('click','.app-nav-panel',function() {
        let panel=$(this).attr('attr');
        let url="home";

        if(panel=='home') {
            showAllProducts();
            url="home";
        }else if(panel=='departments') {
            showAllDepartments();
            url="departments"
        }else if(panel=='shoplist') {
            shoppingCart();
            url="cart";
        }
        updateURL(url)
    });
// end of nav panel ]


// show all departments [
    function showAllDepartments() {
        $('.app-window').hide();
        $('.app-window[attr=departments]').show();
        $.post('/scripts/home.php',{type:'get_departments'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;
            
            let out='';
            $.each(result.dept,function(index,dep) {
                out+='<div class="col mb-5">';
                    out+='<div class="card h-100">';
                        out+='<img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="...">';
                        out+='<div class="card-body p-4">';
                            out+='<div class="text-center">';
                                out+='<h5 class="fw-bolder">'+dep.name+'</h5>';
                            out+='</div>';
                        out+='</div>';
                        out+='<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
                            out+='<div class="text-center">';
                                out+='<button class="btn btn-sm btn-outline-dark mt-auto app-nav-dept-update" attr="item" url="'+dep.urlname+'">View Products</button>';
                            out+='</div>';
                        out+='</div>';
                    out+='</div>';
                out+='</div>';
            });
            $('.app-window[attr=departments]').html('<div class="row"><div class="col-12"><div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center text-dark">'+out+'</div></div></div>');
        }).always(function(){
        });
    }
// end of show all departments ]

// view product [
    $(document).on('click','.app-nav-update',function() {
        $('.app-nav-update').attr('disabled','disabled');
        let url=$(this).attr('url');
        getProductInfo(url);
    });
// end of view product ]
// view departmnet [
    $(document).on('click','.app-nav-dept-update',function() {
        $('.app-nav-update').attr('disabled','disabled');
        let url=$(this).attr('url');
        updateURL('department/'+url)
        getDepartment(url);
    });
// end of view department ]

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
                                out+='<button class="btn btn-sm btn-outline-dark mt-auto app-nav-update" attr="item" barcode="'+product.barcode+'" uid="'+product.id+'" url="'+product.url+'">View</button> ';
                                out+='<button class="btn btn-sm '+(product.in_cart=='1'?'btn-danger':'btn-outline-warning')+' mt-auto app-nav-shop-list" attr="'+(product.in_cart=='1'?'delete':'add')+'" barcode="'+product.barcode+'" uid="'+product.id+'">'+(product.in_cart=='1'?'Delete':'Add to cart')+'</button>';
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

// get product info [
    function getProductInfo(producturl) {
        $.post('/scripts/home.php',{type:'get_product',post:{producturl:producturl}},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;

            $('.app-window').hide();
            updateURL('product/'+producturl)
            $('.app-window[attr=product] h4.name').eq(0).text(result.product.name);
            $('.app-window[attr=product] p.store_info').eq(0).html('<b>Price</b> £'+result.product.price+' <b>Shelf</b> '+result.product.shelf+' <b>Aisle</b> '+result.product.aisle);

            $('.app-window[attr=product] button.shopping-cart').attr('barcode',result.product.barcode);
            if(result.product.in_cart=='1') $('.app-window[attr=product] button.shopping-cart').addClass('btn-danger').removeClass('btn-outline-warning').text('Remove from Shopping Cart').attr('attr','remove');
            else $('.app-window[attr=product] button.shopping-cart').removeClass('btn-danger').addClass('btn-outline-warning').text('Add to Shopping Cart').attr('attr','add');


            $('.app-window[attr=product] a.view-on-map').attr('href','/maptiler/leaflet.html?barcode='+result.product.barcode);


            $('.app-window[attr=product] h4.name').parent().addClass('col-md-12 col-lg-12 col-xl-12').removeClass('col-md-4 col-lg-4 col-xl-6');
            $('.app-window[attr=product] h4.description').parent().hide();

            // console.table(result.product.json);
            $('.app-window[attr=product] img.image').attr('src','');

            if(result.product.json!='no') {
                let json=JSON.parse(result.product.json);
                json=json.products[0];
                // console.table(json)
                $('.app-window[attr=product] p.description').text(json.description);
                $('.app-window[attr=product] img.image').attr('src',json.images[0]);

                $('.app-window[attr=product] h4.name').parent().removeClass('col-md-12 col-lg-12 col-xl-12').addClass('col-md-4 col-lg-4 col-xl-6');
                $('.app-window[attr=product] p.description').parent().show();
            }
            $('.app-window[attr=product]').show();

        }).always(function() {
            $('.app-nav-update').removeAttr('disabled');
        });
    }
// end of product info ]

// shopping cart [
    $(document).on('click','.app-nav-shop-list',function() {
        let barcode=$(this).attr('barcode');
        let action=$(this).attr('attr');
        let button=$(this);
        $('.app-nav-shop-list').attr('disabled','disabled').css('opacity','0.3')
        
        $.post('/scripts/home.php',{type:'amend_shopping_cart',post:{barcode:barcode,action:action}},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            // if(!isDataValid(data)) {error_errordatanotval(data);return;}
            // let result=data.data;
            if(action=='add') {
                button.attr('attr','delete');
                button.text('Remove');
                button.addClass('btn-danger').removeClass('btn-outline-warning');
            }else{
                button.attr('attr','add');
                button.text('Add to cart');
                button.removeClass('btn-danger').addClass('btn-outline-warning');
            }
        }).always(function(data) {
            $('.app-nav-shop-list').removeAttr('disabled').css('opacity','1.0')
        });
    });
    function shoppingCart() {
        //shopping_cart
        $('.app-window').hide();
        $.post('/scripts/home.php',{type:'shopping_cart'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;
            if(result.no_products!=undefined) {
                $('.app_window[attr=shopping_cart]').html('<div class="row"><div class="col-12"><div class="alert alert-warning"><h4>Nothing found<h4/><p>Your shopping cart is empty.</p></div></div></div>');
                return;
            }
            let out='';
            $.each(result,function(key,cart) {
                out+='<div class="col-12">';
                    out+='<div class="rounded bg-secondary p-3 mb-2 mb-1">';
                        out+='<h4>'+cart.product.name+'</h4>';
                        out+='<button class="btn btn-sm btn-outline-dark mt-auto app-nav-update" attr="item" barcode="'+cart.product.barcode+'" uid="'+cart.id+'" url="'+cart.product.url+'">View</button>';
                        out+='<button class="btn btn-sm btn-danger mt-auto app-nav-shop-list" attr="delete" barcode="'+cart.product.barcode+'" uid="'+cart.product.id+'" style="opacity: 1;">Delete</button>';
                    out+='</div>';
                out+='</div>';
            });
            $('.app-window[attr=shopping_cart]').html('<div class="row">'+out+'</div>').fadeIn(500);
        }).always(function(data) {
        });
    }
// end of shopping cart ]

// get department info [
    function getDepartment(departmenturl) {
        $.post('/scripts/home.php',{type:'get_department_products',post:{departmenturl:departmenturl}},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;

            $('.app-window').hide();

            let out='';

            $.each(result.products,function(index,product) {
                // out+='<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';
                    out+='<div class="col mb-5">';
                        out+='<div class="card h-100 text-dark">';
                            out+='<img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="...">';
                            out+='<div class="card-body p-4">';
                                out+='<div class="text-center">';
                                    out+='<h5 class="fw-bolder">'+product.name+'</h5>';
                                    out+='£'+product.price+(product.stock<50?' / '+product.stock+' stock':'');
                                out+='</div>';
                            out+='</div>';
                            out+='<div class="card-footer p-4 pt-0 border-top-0 bg-transparent">';
                                out+='<div class="text-center">';
                                    out+='<button class="btn btn-sm btn-outline-dark mt-auto app-nav-update" attr="item" barcode="'+product.barcode+'" uid="'+product.id+'" url="'+product.url+'">View</button> ';
                                    out+='<button class="btn btn-sm '+(product.in_cart=='1'?'btn-danger':'btn-outline-warning')+' mt-auto app-nav-shop-list" attr="'+(product.in_cart=='1'?'delete':'add')+'" barcode="'+product.barcode+'" uid="'+product.id+'">'+(product.in_cart=='1'?'Delete':'Add to cart')+'</button>';
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
            $('.app-window[attr=department_products]').html('<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">'+out+'</div>').show();

        }).always(function() {
            $('.app-nav-update').removeAttr('disabled');
        });
    }
// end of department info ]

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
            else if(url[0]=='product') {
                console.log('product');
                if(url[1]!=undefined && url[1]!='') getProductInfo(url[1]);
            }
            else if(url[0]=='departments') {
                if(url[1]!=undefined && url[1]!='') getDepartment(url[1]);
                else showAllDepartments();
            }
            else if(url[0]=='cart') {
                shoppingCart();
            }
        }
    }
// end of window pane ]

$(document).ready(function(){
    // getWindowPane();
    initaliseHome();
});