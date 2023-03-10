var debug=true;
//signing in [
    function initaliseHome() {
        $('#app').hide();
        $('#auth').show();
        $('#auth div[attr=init]').show();
        $('#auth div[attr=signin]').hide();

        $.post('/scripts/home.php',{type:'session_started'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;
            if(result==0 || data.admin==false || data.admin=='false') {
                //not logged in
                if(data.admin==false || data.admin=='false') {
                    $('#auth div[attr=init]').slideUp(500);
                    $('#auth div[attr=notadmin]').delay(800).slideDown(500);
                }else{
                    $('#auth div[attr=init]').slideUp(500);
                    $('#auth div[attr=signin]').delay(800).slideDown(500);
                }
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

// create categories [
    $(document).on('click','#app-pane-create-category',function() {
        $('.app-window').hide();
        $('.app-window[attr=categories]').show();
    });
    $(document).on('click','.app-window[attr=categories] input[type=button][attr=submit]',function() {
        $(this).attr('disabled','disabled');
        let row=$('.app-window[attr=categories]');
        let name=row.find('input[attr=name]').eq(0).val();
        let urlname=row.find('input[attr=urlname]').eq(0).val();
        let image=row.find('input[attr=image]').eq(0).val();
        if(name==''||urlname=='') {
            $('.app-window[attr=categories] input[type=button][attr=submit]').removeAttr('disabled');
            swal.fire('Error in fields!','Name and/or URLNAME empty','info');
            return;
        }

        $.post('/scripts/admin.php',{type:'create_category',post:{name:name,urlname:urlname,image:image}},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            // if(!isDataValid(data)) {error_errordatanotval(data);return;}
            getAllCategories();
            row.find('input[attr=name],input[attr=urlname],input[attr=image]').val('');
            swal.fire('Created!','Created that category for you','success');
        }).always(function(){
            $('.app-window[attr=categories] input[type=button][attr=submit]').removeAttr('disabled');
        });

    });
// end of create categories ]
// create aisle [
    $(document).on('click','#app-pane-create-aisle',function() {
        $('.app-window').hide();
        $('.app-window[attr=aisle]').show();
    });
    $(document).on('click','.app-window[attr=aisle] input[type=button][attr=submit]',function() {
        $(this).attr('disabled','disabled');
        let row=$('.app-window[attr=aisle]');
        let name=row.find('input[attr=name]').eq(0).val();
        let number=row.find('input[attr=number]').eq(0).val();
        if(name==''||number=='') {
            $('.app-window[attr=aisle] input[type=button][attr=submit]').removeAttr('disabled');
            swal.fire('Error in fields!','Name and/or number empty','info');
            return;
        }

        $.post('/scripts/admin.php',{type:'create_aisle',post:{name:name,number:number}},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            // if(!isDataValid(data)) {error_errordatanotval(data);return;}
            getAllAisles();
            row.find('input[attr=name],input[attr=number]').val('');
            swal.fire('Created!','Created that aisle for you','success');
        }).always(function(){
            $('.app-window[attr=aisle] input[type=button][attr=submit]').removeAttr('disabled');
        });

    });
// end of create aisle ]

// create product [
    $(document).on('click','#app-pane-create-product',function() {
        $('.app-window').hide();
        $('.app-window[attr=product]').show();
    });
    $(document).on('click','.app-window[attr=product] input[type=button][attr=submit]',function() {
        $(this).attr('disabled','disabled');
        let row=$('.app-window[attr=product]');
        let name=row.find('input[attr=name]').eq(0).val();
        let urlname=row.find('input[attr=urlname]').eq(0).val();
        let barcode=row.find('input[attr=barcode]').eq(0).val();
        let price=row.find('input[attr=price]').eq(0).val();
        let stock=row.find('input[attr=stock]').eq(0).val();
        let image=row.find('input[attr=image]').eq(0).val();
        let categiries=row.find('select[attr=categiries]').eq(0).val();
        let aisles=row.find('select[attr=aisles]').eq(0).val();
        let shelf=row.find('input[attr=shelf]').eq(0).val();
        let tags=row.find('input[attr=tags]').eq(0).val();
        let coords=row.find('textarea[attr=coords]').eq(0).val();

        if(urlname==''||barcode==''||price==''||shelf=='') {
            $('.app-window[attr=product] input[type=button][attr=submit]').removeAttr('disabled');
            swal.fire('Error in fields!','Name and/or number empty','info');
            return;
        }

        $.post('/scripts/admin.php',{type:'create_product',post:{name:name,urlname:urlname,barcode:barcode,price:price,stock:stock,categiries:categiries,aisles:aisles,shelf:shelf,image:image,tags:tags,coords:coords}},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            // if(!isDataValid(data)) {error_errordatanotval(data);return;}
            getAllAisles();
            row.find('input[attr=name],input[attr=urlname],input[attr=barcode],input[attr=price],input[attr=image],input[attr=stock],input[attr=shelf],input[attr=tags],textarea[attr=coords]').val('');

            row.find('select[attr=categiries]').val( row.find('select[attr=categiries] option:first').val() );
            row.find('select[attr=aisles]').val( row.find('select[attr=aisles] option:first').val() );
            swal.fire('Created!','Created that product for you','success');
        }).always(function(){
            $('.app-window[attr=product] input[type=button][attr=submit]').removeAttr('disabled');
        });
    });
// end of create product ]

// get all categories [
    function getAllCategories() {
        $.post('/scripts/admin.php',{type:'get_all_categories'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;
            $('select[attr=categiries]').html('<option value="null">No categories found</option>');
            if( ($.isArray(result) || $.isPlainObject(result)) && (result.length>0 || Object.keys(result).length>0) ) {
                let out='';
                $.each(result,function(key,cat) {
                    out+='<option value="'+cat.id+'">'+cat.name+'</option>';
                });
                $('select[attr=categiries]').html('<option value="null">Select categories</option>'+out);
            }
        });
    }
// end of get all categories ]
// get all categories [
    function getAllAisles() {
        $.post('/scripts/admin.php',{type:'get_all_aisle'},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}
            let result=data.data;
            $('select[attr=aisles]').html('<option value="null">No aisles found</option>');
            if( ($.isArray(result) || $.isPlainObject(result)) && (result.length>0 || Object.keys(result).length>0) ) {
                let out='';
                $.each(result,function(key,aisle) {
                    out+='<option value="'+aisle.id+'">['+aisle.number+'] '+aisle.name+'</option>';
                });
                $('select[attr=aisles]').html('<option value="null">Select aisle</option>'+out);
            }
        });
    }
// end of get all categories ]

// get product info [
    $(document).on('click','.app-window[attr=product] input[type=button][attr=product_info]',function() {
        $(this).attr('disabled','disabled');
        let row=$('.app-window[attr=product]');
        let barcode=row.find('input[attr=barcode]').eq(0).val();

        if(barcode=='') {
            $('.app-window[attr=product] input[type=button][attr=product_info]').removeAttr('disabled');
            swal.fire('Error in fields!','Barcode number empty','info');
            return;
        }

        $.post('/scripts/admin.php',{type:'create_product_info',post:{barcode:barcode}},function(data) {
            if(debug) console.log(data);
            if(!isJSON(data)) {error_cannotread();return;}
            data=JSON.parse(data);
            if(!isJSONSuccess(data)) {error_erroroccured(data);return;}
            if(!isDataValid(data)) {error_errordatanotval(data);return;}

            if(row.find('input[attr=name]').eq(0).val()=='') {
                row.find('input[attr=name]').eq(0).val(data.data.products[0].title);
                if(data.data.products[0].images[0]!=undefined) row.find('input[attr=image]').eq(0).val(data.data.products[0].images[0]);
            }

            swal.fire('Created!','Created that product for you','success');
        }).always(function(){
            $('.app-window[attr=product] input[type=button][attr=product_info]').removeAttr('disabled');
        });
    });
// end of get product info ]

// window pane [
    function getWindowPane(caller) {
        //  if caller equals true then its being called via the onload func;

        let url=(window.location.pathname).substring(1);
        url=url.split('/');

        if(url[1]!=undefined) {
            if(url[1]=='') {
            }else if(url[1]=='logout') logout();
        }

    }
// end of window pane ]

$(document).ready(function() {
    getAllCategories();
    getAllAisles();
    initaliseHome();
});