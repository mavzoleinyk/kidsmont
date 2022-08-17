jQuery(document).ready(function ($) {

$('.checkout-button').prop("disabled", true);
	
$('#checkb').click(function() {
 if ($(this).is(':checked')) {
 $('.checkout-button').prop("disabled", false);
 } else {
 if ($('#checkb').filter(':checked').length < 1){
 $('.checkout-button').attr('disabled',true);}
 }
});
	
	
	
	
$('.form__submit').prop("disabled", true);
	
$('#checkbs').click(function() {
 if ($(this).is(':checked')) {
 $('.form__submit').prop("disabled", false);
 } else {
 if ($('#checkbs').filter(':checked').length < 1){
 $('.form__submit').attr('disabled',true);}
 }
});	
	
	
	
$('#place_order').prop("disabled", true);
	
$('#checkbs').click(function() {
 if ($(this).is(':checked')) {
 $('#place_order').prop("disabled", false);
 } else {
 if ($('#checkbs').filter(':checked').length < 1){
 $('#place_order').attr('disabled',true);}
 }
});	
	
	
	
if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
  // true for mobile device
 $('#place_order').prop("disabled", false);
}	
	
    $('.instal').on('change', function(){
        var val = $(this).val();
        console.log(val);
        $(document.body).trigger("update_checkout");
        
        $.ajax({
            url: globals.url, 
            data:{
                action:'update_inst',
                inst:val
            },
            success:function(data){
   
                $(document.body).trigger("update_checkout");

            }
        });
    })

    $('[name="shipping_country"]').on('change', function(){
        var val = $(this).val();
        console.log(val);
        $.ajax({
            url: globals.url, 
            data:{
                action:'state',
                code:val
            },
            success:function(data){
   
               $('#ship-ajax').html(data);
              
               app.selectInit();

            }
        });
    })

    $('[name="billing_country"]').on('change', function(){
        var val = $(this).val();
        $.ajax({
            url: globals.url, 
            data:{
                action:'bill_state',
                code:val
            },
            success:function(data){
   
               $('#bill-ajax').html(data);
               app.selectInit();
                
            }
        });
    })

    $(document).on('mouseenter', '.sub-menu__link', function(){
        var href = $(this).attr('href');

        $('.menu__img a').attr('href', href);
    });

$("#addreview").validate({
  submitHandler: function(form) {

        $('#addreview').css('opacity', '0.7');
        var data = $('#addreview').serialize();
        $.ajax({
            url: globals.url, 
            data:data, 
            type:'GET', 
            success:function(data){
   
                $('#addreview').css('opacity', '1');

                $('.textarea').val('');
                $('.input').val('');

                 $('.message-text').text('Thank you! Your comment will be published after moderation');

            }
        });
   
  }
 });

$("#addreview_m").validate({
  submitHandler: function(form) {

        $('#addreview_m').css('opacity', '0.7');
        var data = $('#addreview_m').serialize();
        $.ajax({
            url: globals.url, 
            data:data, 
            type:'GET', 
            success:function(data){
   
                $('#addreview_m').css('opacity', '1');

                $('.textarea').val('');
                $('.input').val('');

                 $('.message-text').text('Thank you! Your comment will be published after moderation');

            }
        });
   
  }
 });



	/* Search FAQ*/


	$(document).on('input', 'input[name="q"]', function(){
      	
      	var val = $(this).val();

        $('.search-result').css({'opacity': 1, 'pointer-events': 'auto'});

        $('.search-result').html('Minimum 3 characters...')

        if (val.length > 2) {
            $('.search-result').html('<div class="preloader"><i class="fa fa-spinner fa-spin"></i></div>')

            $.ajax({
                url:globals.url,
                data:{
                	action:'faq_search',
                    q:val
                },
                success:function(data){

                    $('.search-result').html(data);
                }
            })
        }
    });

    $(document).on('click', '.search-link', function(e){
    	e.preventDefault();
    	var tab = $(this).attr('data-term');

    	$('#tab'+tab).trigger( 'click' );

        $('.search-result').css({'opacity': 0, 'pointer-events': 'none'});

    	
    })

    /**
     * add_to_cart
     */


    $(document).on('click', '.add-to-cart', function (e) {

        e.preventDefault();

        var product_id = $(this).attr('data-product_id');
        var variation_id = $(this).attr('data-variation_id');
        var qty = 1;

        var that = $(this);


        $.ajax({

            url: globals.url,
            data: {
                action: 'add_to_cart',
                product_id: product_id,
                variation_id: variation_id,
                qty: qty
            },
            success: function (data) {

               $('.cart_count').html(data.data.cart_qty);

               that.text('Zum Warenkorb hinzugefügt');

               ajax_mini_cart_update();
//----------------------------
				 $('.side-panel.side-panel--right.selected-products.basket').addClass('side-panel--open');
              
//----------------------------				
            }
        });
    })

    /**
     * add_to_cart_fav
     */


    $(document).on('click', '.fav-to-cart', function (e) {

        e.preventDefault();

        var product_id = $(this).attr('data-product_id');

        var that = $(this);


        $.ajax({

            url: globals.url,
            data: {
                action: 'fav_to_cart',
                product_id: product_id,
            },
            success: function (data) {

               $('.cart_count').html(data.data.cart_qty);

               that.text('Zum Warenkorb hinzugefügt');

               ajax_mini_cart_update();

            }
        });
    })



/**
     *
     * variations
     *
     *
     */

    if($('.woocommerce-variation-add-to-cart.woocommerce-variation-add-to-cart-disabled')){
        $('.add-to-cart').addClass('disable-product');
    }


    $(document).on('show_variation', '.single_variation_wrap', function (event, variation) {
    console.log(variation);
        $('.add-to-cart').attr('data-variation_id', variation.variation_id);

        $('#main_img').attr('src', variation.image.url);

        if(variation.is_in_stock == true){
            $('.add-to-cart').removeClass('disable-product');
        }else{
            $('.add-to-cart').addClass('disable-product');
        }

        if(variation.price_html){
        	$('.product-detail-main-info__price').html(variation.price_html);
        } else{
            var re = /./gi;
            var pr = variation.display_price;
            var newstr = pr.replace(re, ',');
        	$('.product-detail-main-info__price').html(newstr+'€');
        }

    });

    $(document).on('click', '.color-picker__item ', function () {

    	$('.color-picker__item').removeClass('color-picker__item--active');
    	$(this).addClass('color-picker__item--active');

        var size = $(this).closest('.product-detail-main-info__table').find('.option-size.options-list__btn--active').attr('data-size');
        var material = $(this).closest('.product-detail-main-info__table').find('.option-material.options-list__btn--active').attr('data-material');
        var groesse = $(this).closest('.product-detail-main-info__table').find('.option-groesse.options-list__btn--active').attr('data-groesse');
        var model = $(this).closest('.product-detail-main-info__table').find('.option-model.options-list__btn--active').attr('data-model');
        var hoehe = $(this).closest('.product-detail-main-info__table').find('.option-hoehe.options-list__btn--active').attr('data-hoehe');

        var color = $(this).attr('data-color');
        $('#pa_farbe').val(color).change();
        $('#pa_size').val(size).change();
        $('#pa_material').val(material).change();
        $('#pa_hoehe').val(hoehe).change();
        $('#pa_model').val(model).change();
        $('#pa_groesse').val(groesse).change();

    })

    $(document).on('click', '.option-size', function (e) {

    	$('.option-size').removeClass('options-list__btn--active');
    	$(this).addClass('options-list__btn--active');

        var color = $(this).closest('.product-detail-main-info__table').find('.color-picker__item.color-picker__item--active').attr('data-color');
        var material = $(this).closest('.product-detail-main-info__table').find('.option-material.options-list__btn--active').attr('data-material');
        var groesse = $(this).closest('.product-detail-main-info__table').find('.option-groesse.options-list__btn--active').attr('data-groesse');
        var model = $(this).closest('.product-detail-main-info__table').find('.option-model.options-list__btn--active').attr('data-model');
        var hoehe = $(this).closest('.product-detail-main-info__table').find('.option-hoehe.options-list__btn--active').attr('data-hoehe');

        var size = $(this).attr('data-size');
        $('#pa_farbe').val(color).change();
        $('#pa_size').val(size).change();
        $('#pa_material').val(material).change();
        $('#pa_hoehe').val(hoehe).change();
        $('#pa_model').val(model).change();
        $('#pa_groesse').val(groesse).change();

    });


    $(document).on('click', '.option-material', function (e) {

    	$('.option-material').removeClass('options-list__btn--active');
    	$(this).addClass('options-list__btn--active');

        var color = $(this).closest('.product-detail-main-info__table').find('.color-picker__item.color-picker__item--active').attr('data-color');
        var size = $(this).closest('.product-detail-main-info__table').find('.option-size.options-list__btn--active').attr('data-size');
        var groesse = $(this).closest('.product-detail-main-info__table').find('.option-groesse.options-list__btn--active').attr('data-groesse');
        var model = $(this).closest('.product-detail-main-info__table').find('.option-model.options-list__btn--active').attr('data-model');
        var material = $(this).closest('.product-detail-main-info__table').find('.option-material.options-list__btn--active').attr('data-material');

        var material = $(this).attr('data-material');
        $('#pa_farbe').val(color).change();
        $('#pa_size').val(size).change();
        $('#pa_material').val(material).change();
        $('#pa_hoehe').val(hoehe).change();
        $('#pa_groesse').val(groesse).change();
        $('#pa_model').val(model).change();

    });

    $(document).on('click', '.option-groesse', function (e) {

        $('.option-groesse').removeClass('options-list__btn--active');
        $(this).addClass('options-list__btn--active');

        var color = $(this).closest('.product-detail-main-info__table').find('.color-picker__item.color-picker__item--active').attr('data-color');
        var material = $(this).closest('.product-detail-main-info__table').find('.option-material.options-list__btn--active').attr('data-material');
        var hoehe = $(this).closest('.product-detail-main-info__table').find('.option-hoehe.options-list__btn--active').attr('data-hoehe');
        var model = $(this).closest('.product-detail-main-info__table').find('.option-model.options-list__btn--active').attr('data-model');
        var size = $(this).closest('.product-detail-main-info__table').find('.option-size.options-list__btn--active').attr('data-size');
		//var aval = $( ".out-of-stock" ).text();
		
        var groesse = $(this).attr('data-groesse');
        $('#pa_farbe').val(color).change();
        $('#pa_groesse').val(groesse).change();
        $('#pa_material').val(material).change();
        $('#pa_hoehe').val(hoehe).change();
        $('#pa_model').val(model).change();
        $('#pa_size').val(size).change();
		//$('.product-detail-main-info__bottom').html(aval);

    });

    $(document).on('click', '.option-hoehe', function (e) {

        $('.option-hoehe').removeClass('options-list__btn--active');
        $(this).addClass('options-list__btn--active');

        var color = $(this).closest('.product-detail-main-info__table').find('.color-picker__item.color-picker__item--active').attr('data-color');
        var material = $(this).closest('.product-detail-main-info__table').find('.option-material.options-list__btn--active').attr('data-material');
        var groesse = $(this).closest('.product-detail-main-info__table').find('.option-groesse.options-list__btn--active').attr('data-groesse');
        var model = $(this).closest('.product-detail-main-info__table').find('.option-model.options-list__btn--active').attr('data-model');
        var size = $(this).closest('.product-detail-main-info__table').find('.option-size.options-list__btn--active').attr('data-size');

        var hoehe = $(this).attr('data-hoehe');
        $('#pa_farbe').val(color).change();
        $('#pa_hoehe').val(hoehe).change();
        $('#pa_material').val(material).change();
        $('#pa_groesse').val(groesse).change();
        $('#pa_model').val(model).change();
        $('#pa_size').val(size).change();


    });

    $(document).on('click', '.option-model', function (e) {

        $('.option-model').removeClass('options-list__btn--active');
        $(this).addClass('options-list__btn--active');

        var color = $(this).closest('.product-detail-main-info__table').find('.color-picker__item.color-picker__item--active').attr('data-color');
        var material = $(this).closest('.product-detail-main-info__table').find('.option-material.options-list__btn--active').attr('data-material');
        var groesse = $(this).closest('.product-detail-main-info__table').find('.option-groesse.options-list__btn--active').attr('data-groesse');
        var hoehe = $(this).closest('.product-detail-main-info__table').find('.option-hoehe.options-list__btn--active').attr('data-hoehe');
        var size = $(this).closest('.product-detail-main-info__table').find('.option-size.options-list__btn--active').attr('data-size');

        var model = $(this).attr('data-model');
        $('#pa_farbe').val(color).change();
        $('#pa_model').val(model).change();
        $('#pa_material').val(material).change();
        $('#pa_groesse').val(groesse).change();
        $('#pa_hoehe').val(hoehe).change();
        $('#pa_size').val(size).change();

    });



    /*
	*
	WISHLIST
	*/


	$(document).on('click', '.add-wish', function (e) {
	    e.preventDefault();

	    var cook = $.cookie('wish');
	    var id = $(this).attr('data-wish');

	    if(cook){
	    	var nc = cook + ','+ id;
	    	var arr = JSON.parse("[" + nc + "]");
	    	var unique = Array.from(new Set(arr));
	    }else{
	    	var nc = id;
	    }

        var c1 = $('.header-actions__item--like .header-actions__count').text();

        $('.header-actions__item--like .header-actions__count').removeClass('hide');
        

        var c2 = Number(c1) + 1;

        $('.header-actions__item--like .header-actions__count').text(c2);

        

	    $(this).removeClass('add-wish');
        $('.wishlist').removeClass('add-wish');
	    $(this).addClass('un-wish');
        $('.wishlist[data-wish="'+id+'"]').addClass('un-wish');
        $('.wishlist[data-wish="'+id+'"]').text('Zur Wunschliste hinzugefügt');
        $('.product-detail__gallery .product-card__like').removeClass('add-wish');
        $('.product-detail__gallery .product-card__like').addClass('un-wish');
	    $.cookie('wish', nc, { expires: 30, path: '/' });

	});

	$(document).on('click', '.un-wish', function (e) {
	    e.preventDefault();

	    var cook = $.cookie('wish');
	    var id = $(this).attr('data-wish');

	    if(cook){
	    	var arr = JSON.parse("[" + cook + "]");
	    	var unique = Array.from(new Set(arr));
	    	var newArray = unique.filter(function(f) { return f !== parseInt(id) })
	    	var newid = newArray.join();

	    }else{
	    	var nc = id;
	    }

	    $(this).addClass('add-wish');
        $('.wishlist').addClass('add-wish');
	    $(this).removeClass('un-wish');
        $('.wishlist[data-wish="'+id+'"]').removeClass('un-wish');
        $('.wishlist[data-wish="'+id+'"]').text('Auf die Liste');
        $('.product-detail__gallery .product-card__like').removeClass('un-wish');
        $('.product-detail__gallery .product-card__like').addClass('add-wish');
        

        var c1 = $('.header-actions__item--like .header-actions__count').text();

        if(c1<=1){
            $('.header-actions__item--like .header-actions__count').addClass('hide');
        }

        var c2 = Number(c1) - 1;

        $('.header-actions__item--like .header-actions__count').text(c2)

	    $.cookie('wish', newid, { expires: 1, path: '/' });

	});


    /**
     * login
     */

    $('.login-form').submit(function(e){
        e.preventDefault();

        var data = $(this).serialize();

        $('.f-result').html('<i class="fab fab-spinner fab-spin"></i>')

        console.log(data);

        $.ajax({
            url: globals.url,
            data: data,
            type: 'POST',
            success: function(data){

                console.log(data);
                
                $('.f-result').html(data.msg);

                // if (data.url) {
                //     location.href = data.url
                // }
            }
        })

    });


    
        if ( $(".register-form").length > 0)
            $(".register-form").validate({
                submitHandler: function(form) {
                    // do other things for a valid form
                   // form.submit();

                    var data = $(".register-form").serialize();

                    $('.f-result').html('<i class="fab fab-spinner fab-spin"></i>')

                    $.ajax({
                        url: globals.url,
                        data: data,
                        type: 'POST',
                        success: function(data){

                            $('.f-result').html(data);
                            
                        }
                    })

                }
            });


    function filter(){

        setTimeout(function(){

            var cont =  '.content';

            $('.desc-filter').removeClass('desc-filter-hide');

            $(cont).animate({'opacity':0.6},300);

            var url =   $('#filter').attr('action');
            var query =   $('#filter').attr('action');
            newurl =  query;
            query = $('#filter').serialize()
            newurl = url + '?' + query;
            window.history.pushState({path:url },'?',newurl);

            $.ajax({
                type: "GET",
                url: globals.url,
                data : $('#filter').serialize(),

                success: function (data) {
                 
                    $(cont).animate({'opacity': 1}, 300);
                    
                    $(cont).html(data.content);
                    // $('.select-wrap-filter').html(data.select_filter);
                    $('.products__count').html(data.count);

                    $.ajax({
                        url: '/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart-variation.min.js',
                        dataType: "script",
                    });




                  
                }
            });

        }, 400)
        
    }


    $(document).on('change', '#filter', filter);

    $(document).on('change', '#sort', function(){

    var val = $(this).val();

    $('#sorting').val(val);

    filter();
    });

    $(document).on('click', '.products-sort__list a', function(){

        var val = $(this).attr('data-key');

        $('#sorting').val(val);

        filter();

        $('.products-sort').removeClass('side-panel--open');
    });


    /**
    * 

    update_cart_qty

    */
    
    $(document).on('click', ' .quantity__button--minus', function (e) {

        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $(document).on('click', ' .quantity__button--plus', function (e) {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });

    $(document).on('change', '.woocommerce-cart-form input', function(e){

        var val = $(this).val();
        var key = $(this).parent().attr('data-key');

        var products = [];
        $('.shopping-cart__products-list li').each(function(){
            var product_id = $(this).find('.order-card__delete').attr('data-product_id')   ;
            var qty = $(this).find('input').val();
            products.push([product_id,qty]);
        });


        $.ajax({
            type: "GET",
            url: woocommerce_params.ajax_url,
            data: {
                action : 'set_cart_item_qty',
                key:key,
                qty:val,
                products:products
            },

            success: function (data) {

                $('.subtot').html(data.data.subtotal)
                $('.tot').html(data.data.total)
                $('.cart_count').html(data.data.cart_qty)
                $('.cart_count2').html(data.data.cart_qty2)
                $('.tax_tot').html(data.data.tax_total)

                $( document.body ).trigger( 'wc_fragment_refresh' );

                ajax_mini_cart_update();
            }
        });
    });


    $(document).on('change', '.basket input', function(){

        var val = $(this).val();
        var key = $(this).parent().attr('data-key');

        var products = [];
        $('.basket-cart__products-list li').each(function(){
            var product_id = $(this).find('.order-card__delete').attr('data-product_id')   ;
            var qty = $(this).find('input').val();
            products.push([product_id,qty]);
        });


        $.ajax({
            url: woocommerce_params.ajax_url,
            data:{
                products:products,
                action:'update_cart',
            },
            success:function(data){

                $( document.body ).trigger( 'wc_fragment_refresh' );

                // $('.cart_count').html(data.data.cart_qty);

                $('.cart-wrap .container-sm').html(data);
                ajax_mini_cart_update();

                $(document.body).trigger("update_checkout");

                console.log(data);
            }
        })

    })

    function ajax_mini_cart_update() {
        
        $.ajax({
            url:globals.url,
            data:{

                action:'update_mini_cart',
            },
            success:function(data){

                $('.basket').html(data);

            }
        })
    }



    var files = []
    $(".drop-zone").each(function() {

        $(this).dropzone({
            url: globals.upload,
            maxFiles: 10,
            previewsContainer: this.querySelector('.drop-zone__preview'),
            addRemoveLinks: true,
            url: globals.upload,
            maxFiles: 10,
            maxFilesize: 10, // MB
            //   uploadMultiple: true,
            acceptedFiles: ".jpg, .jpeg, .png, .gif, .pdf",
    
    
            init: function() {
    
                this.on("success", function(file, data) {
    
                    files.push(data)
    
                    $('[name="media_ids"]').val(files.join(','))
    
                });
    
                let fraction = this.element.querySelector('.drop-zone__fraction');
                let submitBtn = this.element.closest('form').querySelector('[type="submit"], .form__submit');
                let dt = new DataTransfer();
                const numberOfFilesHandler = () => {
                    fraction.innerText = dt.files.length + '/10';
                    this.element.classList.toggle('drop-zone--has-files', dt.files.length > 0)
            
                    if(dt.files.length > 10) {
                        submitBtn.setAttribute('disabled', true);
                    } else {
                        submitBtn.removeAttribute('disabled');
                    }
    
                    if(dt.files.length === 0) {
                        let messageText = this.element.closest('form').querySelector('.message-text');
    
                        if(messageText) {
                            messageText.innerHTML = '';
                        }
                    }
                }
            
                this.on("addedfile", file => {
                    dt.items.add(file)
    
                    numberOfFilesHandler();
                })
            
                this.on("removedfile", file => {
                    dt.items.remove(file)
                    numberOfFilesHandler();
                })
            },
    
    
    
        });
    })

    /**
     * shipping
     */


    $(document).on('change', '.shipping_method', function (e) {
        var method = $(this).val();
        $.ajax({

            url: globals.url,
            data: {
                action: 'set_shipping',
                method: method,

            },
            success: function (data) {

                $('.shipp').html(data.shipping);
                $('.tot').html(data.total)
                $(document.body).trigger('update_checkout');


            }
        });
    })



    /*
    *
    Ajax Review
    */

    $(document).on('click', '#loadmore', function(e){

        event.preventDefault();

        var button = $( '#loadmore' ),
        paged = button.data( 'paged' ),
        maxPages = button.data( 'max_pages' );

        $.ajax({
            type : 'GET',
            url : globals.url,
            data : {
                paged : paged,
                action : 'loadmore'
            },
            success : function( data ){
 
                paged++;

                $('.reviews-list').append( data );
 
                if( paged == maxPages ) {
                    button.remove();
                }

                window.locomotivePageScroll.update();
 
            }
 
        });

    })



});