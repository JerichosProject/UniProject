var debug=false;
var interval=null;
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
                let current_slide=0;
                let max_slide=$('.login-home-item').length;
                interval=setInterval(() => {
                    if(interval==null) return;
                    $('.login-home-item').fadeOut(500);
                    setTimeout(() => {
                        current_slide++;
                        if(current_slide>=max_slide) current_slide=0;
                        $('.login-home-item').eq(current_slide).fadeIn(500);
                    }, 800);
                }, 10000);
                $('#auth div[attr=init]').slideUp(500);
                $('#auth div[attr=welcome]').delay(800).slideDown(500);
            }else{
                //logged in, ask them if they want to continue!
                $('#auth').fadeOut(500);
                getWindowPane(true);
                $('#app').delay(800).fadeIn(500);
            }
        });
    }

    function startCycle() {
        if(interval!=null) return;

        let current_slide=0;

        
        $('.login-home-item').each(function(k,i) {
            if($(this).css('display')!='none') {
                current_slide=k;
                return false;
            }
        });

        interval=setInterval(() => {
            if(interval==null) return;
            $('.login-home-item').fadeOut(500);
            current_slide++;
            nextCycle(current_slide,true)
        }, 10000);
    }
    function nextCycle(slide,dir) {
        let direction=true;// true = positive - false = negative;
        if(dir!=undefined && dir==false) direction=false;

        $('.login-home-item').fadeOut(500);

        let max_slide=$('.login-home-item').length;
        setTimeout(() => {
            if(direction) slide++;
            else slide--;

            if(slide>=max_slide) slide=0;
            $('.login-home-item').eq(slide).fadeIn(500);
        }, 800);
    }

    $(document).on('click','.login-cycle-option',function() {
        let attr=$(this).attr('attr');
        if(attr=='resume') {
            $('.login-cycle-option[attr=resume]').hide();
            startCycle();
            return;
        }

        $('.login-cycle-option[attr=resume]').show();

        clearInterval(interval);
        interval=null;
        if($('.login-home-item').length==0) return;

        let current_slide=0;

        $('.login-home-item').each(function(k,i) {
            if($(this).css('display')!='none') {
                current_slide=k;
                return false;
            }
        });
        
        nextCycle(current_slide,(attr=='next'?true:false));
    });

    $(document).on('click','#home-div-welcome-login',function() {
        $('#auth div[attr=welcome]').fadeOut(500);
        $('#auth div[attr=signin]').delay(800).fadeIn(500);
        if(interval!=null) clearInterval(interval);
    });
    $(document).on('click','#auth div[attr=signin] button.login',function() {
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
            showFeatured();
            url="home";
        }else if(panel=='departments') {
            showAllDepartments();
            url="departments"
        }else if(panel=='shoplist') {
            shoppingCart();
            url="list";
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
        updateURL('departments/'+url)
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
                                out+='<button class="btn btn-sm '+(product.in_cart=='1'?'btn-danger':'btn-outline-warning')+' mt-auto app-nav-shop-list" attr="'+(product.in_cart=='1'?'delete':'add')+'" barcode="'+product.barcode+'" uid="'+product.id+'">'+(product.in_cart=='1'?'Delete':'Add to list')+'</button>';
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
// show 4 featured [
    function showFeatured() {
        $('.app-window').hide();
        $('.app-window[attr=home]').show();
        $.post('/scripts/home.php',{type:'get_featured'},function(data) {
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
                                out+='<button class="btn btn-sm '+(product.in_cart=='1'?'btn-danger':'btn-outline-warning')+' mt-auto app-nav-shop-list" attr="'+(product.in_cart=='1'?'delete':'add')+'" barcode="'+product.barcode+'" uid="'+product.id+'">'+(product.in_cart=='1'?'Delete':'Add to list')+'</button>';
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
            let prepended='';
            prepended+='<div class="row">';
                prepended+='<div class="col-12 text-center text-white">';
                    prepended+='<h1 class="display-4">Featured</h1>';
                prepended+='</div>';
            prepended+='</div>';
            $('.app-window[attr=home]').html(prepended+'<div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">'+out+'</div>');
        }).always(function(){
        });
    }
// end of show featured ]

// search for product [
    var searchProductTypeTimer;

    $('#navbarSupportedContent input[type=search]').on('keyup',function() {
        //https://stackoverflow.com/questions/4220126/run-javascript-function-when-user-finishes-typing-instead-of-on-key-up thanks
        clearTimeout(searchProductTypeTimer);
        searchProductTypeTimer=setTimeout(searchInputNavBar,1000);
    });
    $('#navbarSupportedContent input[type=search]').on('keydown',function() {
        clearTimeout(searchProductTypeTimer);
    });
    /* $(document).on('blur','#navbarSupportedContent input[type=search]',function() {
        $('#navbarSupportedContentSearchDropDown,#navbarSupportedContentSearchDropDownBackDrop').hide();
    }); */
    $(document).on('focus','#navbarSupportedContent input[type=search]',function() {
        let search=$('#navbarSupportedContent input[type=search]').val();
        if(search.length>0) {
            $('#navbarSupportedContentSearchDropDown,#navbarSupportedContentSearchDropDownBackDrop').show();
        }
    });

    $(document).on('click','#navbarSupportedContentSearchDropDownBackDrop',function() {
        $('#navbarSupportedContentSearchDropDownBackDrop,#navbarSupportedContentSearchDropDown').hide();
    });

    function searchInputNavBar() {
        let search=$('#navbarSupportedContent input[type=search]').val();
        $('#navbarSupportedContentSearchDropDown').hide();
        if(search.length<3) return;

        getProductsByNameAndTags(search,'navbarSupportedContentSearchDropDown');
    }
    
    function getProductsByNameAndTags(search,appendto) {
        $.post('/scripts/home.php',{type:'get_products_by_name_and_tags',post:{search:search}},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;
            let out='';
            
            $('#navbarSupportedContentSearchDropDown,#navbarSupportedContentSearchDropDownBackDrop').show();
            $('#navbarSupportedContent input[type=search]').focus();

            if(result.noresults!=undefined) {
                out+='<div class="card mt-1 ">';
                    out+='<div class="card-header d-flex justify-content-between">';
                        out+='<div class="fw-bold">';
                            out+='<span class="fs-6 text-dark">No results found!</span><br/>';
                            out+='<span class="fs-7 text-muted">Please try again.</span>';
                        out+='</div>';

                    out+='</div>';
                out+='</div>';
                $('#'+appendto).html(out);
                return;
            }
            $.each(result.products,function(index,product) {
                out+='<div class="card mt-1 ">';
                    out+='<div class="card-header d-flex justify-content-between">';
                        out+='<div class="fw-bold">';
                            out+='<span class="fs-6 text-dark">'+product.name+'</span><br/>';
                            out+='<span class="fs-7 text-muted">'+result.dept[product.department].name+' / '+result.aisles[product.aisle].name+'<br/>A: '+result.aisles[product.aisle].number+' S: '+product.shelf+' - £'+product.price+'<br/><button class="btn btn-sm btn-outline-dark mt-auto app-nav-update" attr="item" barcode="'+product.barcode+'" uid="'+product.id+'" url="'+product.url+'">View</button> <button class="btn btn-sm '+(product.in_cart=='1'?'btn-danger':'btn-outline-warning')+' mt-auto app-nav-shop-list" attr="'+(product.in_cart=='1'?'delete':'add')+'" barcode="'+product.barcode+'" uid="'+product.id+'">'+(product.in_cart=='1'?'Delete':'Add to list')+'</button></span>';
                        out+='</div>';

                    out+='</div>';
                out+='</div>';
            });

            let out2='';


            // out2='<ul class="dropdown-menu">'+out+'</ul></div>';
            $('#'+appendto).html(out);
        }).always(function() {
            $('.app-nav-update').removeAttr('disabled');
        });
    }

// end of search for product ]

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
            if(result.product.in_cart=='1') $('.app-window[attr=product] button.shopping-cart').addClass('btn-danger').removeClass('btn-outline-warning').text('Remove from Shopping List').attr('attr','remove');
            else $('.app-window[attr=product] button.shopping-cart').removeClass('btn-danger').addClass('btn-outline-warning').text('Add to Shopping List').attr('attr','add');


            $('.app-window[attr=product] a.view-on-map').attr('href','/maptiler/leaflet.php?barcode='+result.product.barcode);


            $('.app-window[attr=product] h4.name').parent().addClass('col-md-12 col-lg-12 col-xl-12').removeClass('col-md-4 col-lg-4 col-xl-6');
            $('.app-window[attr=product] h4.description').parent().hide();

            // console.table(result.product.json);
            $('.app-window[attr=product] img.image').attr('src','');

            $('.app-window div.restrictions_apply').hide();
            if(result.product.verification==1) $('.app-window div.restrictions_apply').show();

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
    $(document).on('click','.app-window[attr=product] a.view-on-map',function(e) {
        let href=$(this).attr('href');
        window.open(href, 'popup', 'height=500,width=400,toolbar=no')
        e.preventDefault();
    });
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
                button.text('Add to list');
                button.removeClass('btn-danger').addClass('btn-outline-warning');
            }
        }).always(function(data) {
            $('.app-nav-shop-list').removeAttr('disabled').css('opacity','1.0')
        });
    });
    function shoppingCart() {
        //shopping_cart
        $('.app-window').hide();
        $('.app-window[attr=shopping_cart]').show();
        $.post('/scripts/home.php',{type:'shopping_cart'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;
            if(result.no_products!=undefined) {
                $('.app-window[attr=shopping_cart] div[attr=list]').html('<div class="row mt-2"><div class="col-12"><div class="alert alert-warning"><h4>Nothing found</h4><p>Your shopping list is empty.</p></div></div></div>');
                return;
            }
            let out='';
            $.each(result,function(key,cart) {
                out+='<div class="col-12">';
                    out+='<div class="rounded bg-secondary p-3 mb-2 mb-1">';
                        out+='<h4>'+cart.product.name+'</h4><p>Time added: '+cart.time+'</p>';
                        out+='<button class="btn btn-sm btn-outline-dark mt-auto app-nav-update" attr="item" barcode="'+cart.barcode+'" uid="'+cart.id+'" url="'+cart.product.url+'">View</button> ';
                        out+='<button class="btn btn-sm btn-danger mt-auto app-nav-shop-list" attr="delete" barcode="'+cart.barcode+'" uid="'+cart.product.id+'" style="opacity: 1;">Delete</button>';
                    out+='</div>';
                out+='</div>';
            });
            $('.app-window[attr=shopping_cart] div[attr=list]').html('<div class="row mt-2">'+out+'</div>').fadeIn(500);
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
                                    out+='<button class="btn btn-sm '+(product.in_cart=='1'?'btn-danger':'btn-outline-warning')+' mt-auto app-nav-shop-list" attr="'+(product.in_cart=='1'?'delete':'add')+'" barcode="'+product.barcode+'" uid="'+product.id+'">'+(product.in_cart=='1'?'Delete':'Add to list')+'</button>';
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
                showFeatured();
            }else if(url[0]=='logout') logout();
            else if(url[0]=='product') {
                console.log('product');
                if(url[1]!=undefined && url[1]!='') getProductInfo(url[1]);
            }
            else if(url[0]=='departments') {
                if(url[1]!=undefined && url[1]!='') getDepartment(url[1]);
                else showAllDepartments();
            }
            else if(url[0]=='list') {
                shoppingCart();
            }
        }
    }

    
    window.addEventListener('popstate', function(event) {
        getWindowPane();
    }, false);

// end of window pane ]

$(document).ready(function(){
    // getWindowPane();
    initaliseHome();
});