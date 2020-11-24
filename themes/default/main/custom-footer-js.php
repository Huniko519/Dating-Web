<div id="max_swap_modal" class="modal dt_swipe_modal_max">
    <div class="modal-content">
		<img src="<?php echo $theme_url;?>assets/img/max-swipe-alert.svg" alt="<?php echo __('Close'); ?>">
        <div id="max_swap_modal_container"></div>
    </div>
    <div class="modal-footer">
        <a href="<?php echo $site_url;?>/pro" data-ajax="/pro" class="prema"><span style="margin-left: 9px;"><?php echo __( 'Premium' );?></span></a>
        <a href="javascript:void(0);" class="modal-close waves-effect btn-flat"><?php echo __('Close'); ?></a>
    </div>
</div>

<div id="chat_declined_modal" class="modal">
    <div class="modal-content">
        <div id="chat_declined_modal_container"></div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0);" class="modal-close waves-effect btn-flat"><?php echo __('Close'); ?></a>
    </div>
</div>

<script>
    var Wo_Delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    function Wo_ChatSticker(self){
        if (!self) {
            return false;
        }

        $( '#gify_box' ).modal("close");
        $('.lds-facebook').removeClass('hide');
        $('#btn_chat_f_send').addClass('hide');


        let id = $( this ).attr( 'data-id' );
        let form = $("#chat_message_form");
        let url = window.ajax + form.attr('action');
        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize() + '&gifurl=' + $(self).attr('data-gif'),
            success: function (data) {

                if (window._get_chatConversationsInterval) {
                    window._get_chatConversationsInterval.start();
                }
                let el = $( '#dt_emoji' ).emojioneArea();
                el.data( 'emojioneArea' ).setText('');
                if( typeof el.data( 'emojioneArea' ).editor !== "undefined" ){
                    el.data( 'emojioneArea' ).editor.focus();
                }

                _get_chat_conversation(data.to);
                $('#btn_chat_f_send').removeClass('hide');
                $('.lds-facebook').addClass('hide');
            }
        });

    }

    function GetGifyChat(keyword){
        Wo_Delay(function(){
            let offset = Math.floor(Math.random() * 100) + 1;
            $.ajax({
                url: 'https://api.giphy.com/v1/gifs/search?',
                type: 'GET',
                dataType: 'json',
                data: {q:keyword,api_key:'<?php echo $config->giphy_api;?>',limit:24,offset: offset},
            })
            .done(function(data) {
                if (data.meta.status == 200 && data.data.length > 0) {
                    $('#gifylist').empty();
                    for (var i = 0; i < data.data.length; i++) {
                        appended = true;
                        if (appended == true) {
                            appended = false;
                            $('#gifylist').append($('<img alt="gif" src="'+data.data[i].images.fixed_height_small.url+'" data-gif="' + data.data[i].images.fixed_height.url + '" onclick="Wo_ChatSticker(this)" autoplay loop>'));
                            appended = true;
                        }
                    }
                }
                else{
                    $('#gifylist').html('<p class="no_chat_gifs_found"><i class="fa fa-frown-o"></i> <?php echo __('No result found'); ?></p>');
                }
            })
            .fail(function() {
                console.log("error");
            })
        },1000);
    }

    function Wo_GetChatStickers(keyword){
        if (!keyword) {
            return false;
        }
        var chat_gif_loading =  '\
  <div class="sk-circle">\
    <div class="sk-circle1 sk-child"></div>\
    <div class="sk-circle2 sk-child"></div>\
    <div class="sk-circle3 sk-child"></div>\
    <div class="sk-circle4 sk-child"></div>\
    <div class="sk-circle5 sk-child"></div>\
    <div class="sk-circle6 sk-child"></div>\
    <div class="sk-circle7 sk-child"></div>\
    <div class="sk-circle8 sk-child"></div>\
    <div class="sk-circle9 sk-child"></div>\
    <div class="sk-circle10 sk-child"></div>\
    <div class="sk-circle11 sk-child"></div>\
    <div class="sk-circle12 sk-child"></div>\
  </div>';
        $('#chat-box-stickers-cont').html(chat_gif_loading);
        Wo_Delay(function(){
            $.ajax({
                url: 'https://api.giphy.com/v1/gifs/search?',
                type: 'GET',
                dataType: 'json',
                data: {q:keyword,api_key:'<?php echo $config->giphy_api;?>',limit:15},
            })
                .done(function(data) {
                    if (data.meta.status == 200 && data.data.length > 0) {
                        $('#chat-box-stickers-cont').empty();
                        for (var i = 0; i < data.data.length; i++) {
                            appended = true;
                            if (appended == true) {
                                appended = false;
                                $('#chat-box-stickers-cont').append($('<img alt="gif" src="'+data.data[i].images.fixed_height_small.url+'" data-gif="' + data.data[i].images.fixed_height.url + '" onclick="Wo_ChatSticker(this)" autoplay loop>'));
                                appended = true;
                            }
                        }
                    }
                    else{
                        $('#chat-box-stickers-cont').html('<p class="no_chat_gifs_found"><i class="fa fa-frown-o"></i> <?php echo __('No result found'); ?></p>');
                    }
                })
                .fail(function() {
                    console.log("error");
                })
        },1000);
    }

    function interest_chipsUpdate(e, data) {
        var chipsData = M.Chips.getInstance($('.interest_chips')).chipsData;
        var len = chipsData.length;
        var chipsValue = "";
        var i;
        for (i = 0; i < len; i++) { 
            chipsValue += chipsData[i].tag + ",";
        }

        document.getElementsByName("interest")[0].value = chipsValue;
    }
    function deleteimage(img){
        var src = $(img).parent().parent().find('.fancybox-image').attr('src'); // Looks for the *fancyboxed* image
        var url = window.ajax + '/profile/delete_avater';
        var formData = new FormData();
            formData.append("id", $(img).attr('data-id') );
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType:false,
            cache: false,
            processData:false,
            success: function(data){
                if(data.status == 200) {
                    parent.$.fancybox.close();
                    $("#ajaxRedirect").attr("data-ajax",'/' + window.loggedin_user);
                    $("#ajaxRedirect").click();
                }
            },
            error: function (data) {
                M.toast({html: data.responseJSON.message});
            },
        });
    }
    function deleteimageadmin(img,user){
        var src = $(img).parent().parent().find('.fancybox-image').attr('src'); // Looks for the *fancyboxed* image
        var url = window.ajax + '/profile/delete_avater_admin';
        var formData = new FormData();
        formData.append("id", $(img).attr('data-id') );
        formData.append("uid", user );
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType:false,
            cache: false,
            processData:false,
            success: function(data){
                if(data.status == 200) {
                    parent.$.fancybox.close();
                    $("#ajaxRedirect").attr("data-ajax",'/@' + data.userData.username);
                    $("#ajaxRedirect").click();
                }
            },
            error: function (data) {
                M.toast({html: data.responseJSON.message});
            },
        });
    }

    function privateimage(img){
        var src = $(img).parent().parent().find('.fancybox-image').attr('src'); // Looks for the *fancyboxed* image
        var url = window.ajax + '/profile/private_avater';
        var formData = new FormData();
            formData.append("id", $(img).attr('data-id') );

        var chat_gif_loading =  '<div class="qdt_lbox_prvtLoader"><svg width="120" height="30" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg"><circle cx="15" cy="15" r="15"> <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite" /> <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite" /> </circle> <circle cx="60" cy="15" r="9" fill-opacity="0.3"> <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite" /> <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite" /> </circle> <circle cx="105" cy="15" r="15"> <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite" /> <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite" /></circle></svg></div>';
        $('.fancybox-content img.fancybox-image').after(chat_gif_loading);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType:false,
            cache: false,
            processData:false,
            success: function(data){
                if(data.status == 200) {
                    $('.sk-circle').remove();
                    parent.$.fancybox.close();
                    if(data.lock_private_photo == true){
                        var lock_private_photo_fee = '<?php echo $config->lock_private_photo_fee;?>';
                        $('.payment_modalx').modal('open');
                        //console.log('fuck you son of bitch ' + lock_private_photo_fee);
                    }else{
                        $("#ajaxRedirect").attr("data-ajax",'/' + window.loggedin_user);
                        $("#ajaxRedirect").click();
                    }
                }
            },
            error: function (data) {
                M.toast({html: data.responseJSON.message});
            },
        });
    }
    function unprivateimage(img){
        var src = $(img).parent().parent().find('.fancybox-image').attr('src'); // Looks for the *fancyboxed* image
        var url = window.ajax + '/profile/unprivate_avater';
        var formData = new FormData();
            formData.append("id", $(img).attr('data-id') );

        var chat_gif_loading =  '<div class="qdt_lbox_prvtLoader"><svg width="120" height="30" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg"><circle cx="15" cy="15" r="15"> <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite" /> <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite" /> </circle> <circle cx="60" cy="15" r="9" fill-opacity="0.3"> <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite" /> <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite" /> </circle> <circle cx="105" cy="15" r="15"> <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite" /> <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite" /></circle></svg></div>';
        $('.fancybox-content img.fancybox-image').after(chat_gif_loading);

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType:false,
            cache: false,
            processData:false,
            success: function(data){
                if(data.status == 200) {
                    $('.sk-circle').remove();
                    parent.$.fancybox.close();
                    $("#ajaxRedirect").attr("data-ajax",'/' + window.loggedin_user);
                    $("#ajaxRedirect").click();
                }
            },
            error: function (data) {
                M.toast({html: data.responseJSON.message});
            },
        });
    }

    var stripe_array = [];
    function SH_lock_pro_video_StripeRequest(argument) {
        if ($("#lock_pro_video_stripe_name").val() != '' && $("#lock_pro_video_stripe_email").val() != '' && $("#lock_pro_video_stripe_number").val() != '' && $("#lock_pro_video_stripe_month").val() != '' && $("#lock_pro_video_stripe_year").val() != '' && $("#lock_pro_video_stripe_cvc").val() != '') {
            var script = document.createElement('script');
            script.src = 'https://js.stripe.com/v2/';
            script.type = 'text/javascript';
            script.onload = script.onreadystatechange = function() {
                Stripe.setPublishableKey('<?php echo $config->stripe_id;?>');

                $('#lock_pro_video_stripe_button').attr('disabled', 'true');
                $('#lock_pro_video_stripe_button').text("<?php echo __('Please wait..');?>");
                stripe_array['stripe_name'] = $('#lock_pro_video_stripe_name').val();
                stripe_array['stripe_email'] = $('#lock_pro_video_stripe_email').val();
                stripe_array['stripe_number'] = $('#lock_pro_video_stripe_number').val();
                stripe_array['stripe_month'] = $('#lock_pro_video_stripe_month').val();
                stripe_array['stripe_year'] = $('#lock_pro_video_stripe_year').val();
                stripe_array['stripe_cvc'] = $('#lock_pro_video_stripe_cvc').val();
                stripe_array['amount'] = '<?php echo (int)$config->lock_pro_video_fee;?>';
                Stripe.createToken({
                    number: $('#lock_pro_video_stripe_number').val(),
                    exp_month: $('#lock_pro_video_stripe_month').val(),
                    exp_year: $('#lock_pro_video_stripe_year').val(),
                    cvc: $('#lock_pro_video_stripe_cvc').val()
                }, SH_lock_pro_video_StripeResponseHandler);
            };
            let head  = document.getElementsByTagName('head')[0];
            head.appendChild(script);

        }
        else{
            $('#lock_pro_video_stripe_alert').html("<?php echo __('Please check your details');?>");
        }
    }
    function SH_lock_pro_video_StripeResponseHandler(status, response) {
        if (response.error) {
            $('#lock_pro_video_stripe_alert').html(response.error.message);
            $('#lock_pro_video_stripe_button').removeAttr('disabled');
            $('#lock_pro_video_stripe_button').text("<?php echo __('Pay');?>");
        } else {
            stripe_array['token'] = response.id;

            $.post(window.ajax + 'stripe/handle', {
                stripeToken: stripe_array['token'],
                stripe_name: stripe_array['stripe_name'],
                stripe_email: stripe_array['stripe_email'],
                stripe_number: stripe_array['stripe_number'],
                stripe_month: stripe_array['stripe_month'],
                stripe_year: stripe_array['stripe_year'],
                stripe_cvc: stripe_array['stripe_cvc'],
                amount: stripe_array['amount'],
                description: '<?php echo __( "Unlock Video upload feature");?>',
                price: stripe_array['amount'],
                payType: 'lock_pro_video'
            }, function (data) {
                if (data.status == 200) {
                    //$('#credit_amount').html(data.credit_amount);
                    //document.location = window.site_url + data.location;
                    $("#btnProSuccess").attr("data-ajax", data.location);
                    $("#btnProSuccess").click();
                } else {
                    $('.modal-body').html('<i class="fa fa-spin fa-spinner"></i> <?php echo __('Payment declined');?> ');
                }
            });
        }
    }


    function SH_unlock_photo_private_StripeRequest(argument) {
        if ($("#unlock_photo_private_stripe_name").val() != '' && $("#unlock_photo_private_stripe_email").val() != '' && $("#unlock_photo_private_stripe_number").val() != '' && $("#unlock_photo_private_stripe_month").val() != '' && $("#unlock_photo_private_stripe_year").val() != '' && $("#unlock_photo_private_stripe_cvc").val() != '') {
            var script = document.createElement('script');
            script.src = 'https://js.stripe.com/v2/';
            script.type = 'text/javascript';
            script.onload = script.onreadystatechange = function() {
                Stripe.setPublishableKey('<?php echo $config->stripe_id;?>');

                $('#unlock_photo_private_stripe_button').attr('disabled', 'true');
                $('#unlock_photo_private_stripe_button').text("<?php echo __('Please wait..');?>");
                stripe_array['stripe_name'] = $('#unlock_photo_private_stripe_name').val();
                stripe_array['stripe_email'] = $('#unlock_photo_private_stripe_email').val();
                stripe_array['stripe_number'] = $('#unlock_photo_private_stripe_number').val();
                stripe_array['stripe_month'] = $('#unlock_photo_private_stripe_month').val();
                stripe_array['stripe_year'] = $('#unlock_photo_private_stripe_year').val();
                stripe_array['stripe_cvc'] = $('#unlock_photo_private_stripe_cvc').val();
                stripe_array['amount'] = '<?php echo (int)$config->lock_private_photo_fee;?>';
                Stripe.createToken({
                    number: $('#unlock_photo_private_stripe_number').val(),
                    exp_month: $('#unlock_photo_private_stripe_month').val(),
                    exp_year: $('#unlock_photo_private_stripe_year').val(),
                    cvc: $('#unlock_photo_private_stripe_cvc').val()
                }, SH_unlock_photo_private_StripeResponseHandler);
            };
            let head  = document.getElementsByTagName('head')[0];
            head.appendChild(script);

        }
        else{
            $('#unlock_photo_private_stripe_alert').html("<?php echo __('Please check your details');?>");
        }
    }
    function SH_unlock_photo_private_StripeResponseHandler(status, response) {
        if (response.error) {
            $('#unlock_photo_private_stripe_alert').html(response.error.message);
            $('#unlock_photo_private_stripe_button').removeAttr('disabled');
            $('#unlock_photo_private_stripe_button').text("<?php echo __('Pay');?>");
        } else {
            stripe_array['token'] = response.id;

            $.post(window.ajax + 'stripe/handle', {
                stripeToken: stripe_array['token'],
                stripe_name: stripe_array['stripe_name'],
                stripe_email: stripe_array['stripe_email'],
                stripe_number: stripe_array['stripe_number'],
                stripe_month: stripe_array['stripe_month'],
                stripe_year: stripe_array['stripe_year'],
                stripe_cvc: stripe_array['stripe_cvc'],
                amount: stripe_array['amount'],
                description: '<?php echo __( "Unlock Private photo feature");?>',
                price: stripe_array['amount'],
                payType: 'unlock_private_photo'
            }, function (data) {
                if (data.status == 200) {
                    //$('#credit_amount').html(data.credit_amount);
                    //document.location = window.site_url + data.location;
                    $("#btnProSuccess").attr("data-ajax", data.location);
                    $("#btnProSuccess").click();
                } else {
                    $('.modal-body').html('<i class="fa fa-spin fa-spinner"></i> <?php echo __('Payment declined');?> ');
                }
            });
        }
    }

    function SH_StripeRequest(argument) {
        if ($("#stripe_name").val() != '' && $("#stripe_email").val() != '' && $("#stripe_number").val() != '' && $("#stripe_month").val() != '' && $("#stripe_year").val() != '' && $("#stripe_cvc").val() != '' && $("#wallet_amount").val() != '') {
            var script = document.createElement('script');
            script.src = 'https://js.stripe.com/v2/';
            script.type = 'text/javascript';
            script.onload = script.onreadystatechange = function() {
                Stripe.setPublishableKey('<?php echo $config->stripe_id;?>');

                $('#stripe_button').attr('disabled', 'true');
                $('#stripe_button').text("<?php echo __('Please wait..');?>");
                stripe_array['stripe_name'] = $('#stripe_name').val();
                stripe_array['stripe_email'] = $('#stripe_email').val();
                stripe_array['stripe_number'] = $('#stripe_number').val();
                stripe_array['stripe_month'] = $('#stripe_month').val();
                stripe_array['stripe_year'] = $('#stripe_year').val();
                stripe_array['stripe_cvc'] = $('#stripe_cvc').val();
                stripe_array['amount'] = getPrice();
                Stripe.createToken({
                    number: $('#stripe_number').val(),
                    exp_month: $('#stripe_month').val(),
                    exp_year: $('#stripe_year').val(),
                    cvc: $('#stripe_cvc').val()
                }, SH_StripeResponseHandler);
            };
            let head  = document.getElementsByTagName('head')[0];
            head.appendChild(script);

        }
        else{
            $('#stripe_alert').html("<?php echo __('Please check your details');?>");
        }
    }
    function SH_StripeResponseHandler(status, response) {
        if (response.error) {
            $('#stripe_alert').html(response.error.message);
            $('#stripe_button').removeAttr('disabled');
            $('#stripe_button').text("<?php echo __('Pay');?>");
        } else {
            stripe_array['token'] = response.id;

            $.post(window.ajax + 'stripe/handle', {
                stripeToken: stripe_array['token'],
                stripe_name: stripe_array['stripe_name'],
                stripe_email: stripe_array['stripe_email'],
                stripe_number: stripe_array['stripe_number'],
                stripe_month: stripe_array['stripe_month'],
                stripe_year: stripe_array['stripe_year'],
                stripe_cvc: stripe_array['stripe_cvc'],
                amount: stripe_array['amount'],
                description: getDescription(),
                price: stripe_array['amount'],
                payType: 'credits'
            }, function (data) {
                if (data.status == 200) {
                    $('#credit_amount').html(data.credit_amount);
                    //document.location = window.site_url + data.location;
                    $("#btnProSuccess").attr("data-ajax", data.location);
                    $("#btnProSuccess").click();
                } else {
                    $('.modal-body').html('<i class="fa fa-spin fa-spinner"></i> <?php echo __('Payment declined');?> ');
                }
            });
        }
    }

    function SH_StripeRequestPro(argument) {
        if ($("#stripe_name").val() != '' && $("#stripe_email").val() != '' && $("#stripe_number").val() != '' && $("#stripe_month").val() != '' && $("#stripe_year").val() != '' && $("#stripe_cvc").val() != '' && $("#wallet_amount").val() != '') {
            var script = document.createElement('script');
            script.src = 'https://js.stripe.com/v2/';
            script.type = 'text/javascript';
            script.onload = script.onreadystatechange = function() {
                Stripe.setPublishableKey('<?php echo $config->stripe_id;?>');

                $('#stripe_button_pro').attr('disabled', 'true');
                $('#stripe_button_pro').text("<?php echo __('Please wait..');?>");
                stripe_array['stripe_name'] = $('#stripe_name').val();
                stripe_array['stripe_email'] = $('#stripe_email').val();
                stripe_array['stripe_number'] = $('#stripe_number').val();
                stripe_array['stripe_month'] = $('#stripe_month').val();
                stripe_array['stripe_year'] = $('#stripe_year').val();
                stripe_array['stripe_cvc'] = $('#stripe_cvc').val();
                stripe_array['amount'] = getPrice();
                Stripe.createToken({
                    number: $('#stripe_number').val(),
                    exp_month: $('#stripe_month').val(),
                    exp_year: $('#stripe_year').val(),
                    cvc: $('#stripe_cvc').val()
                }, SH_StripeResponseHandlerPro);
            };
            let head  = document.getElementsByTagName('head')[0];
            head.appendChild(script);

        }
        else{
            $('#stripe_alert').html("<?php echo __('Please check your details');?>");
        }
    }
    function SH_StripeResponseHandlerPro(status, response) {
        if (response.error) {
            $('#stripe_alert').html(response.error.message);
            $('#stripe_button_pro').removeAttr('disabled');
            $('#stripe_button_pro').text("<?php echo __('Pay');?>");
        } else {
            stripe_array['token'] = response.id;

            $.post(window.ajax + 'stripe/handle', {
                stripeToken: stripe_array['token'],
                stripe_name: stripe_array['stripe_name'],
                stripe_email: stripe_array['stripe_email'],
                stripe_number: stripe_array['stripe_number'],
                stripe_month: stripe_array['stripe_month'],
                stripe_year: stripe_array['stripe_year'],
                stripe_cvc: stripe_array['stripe_cvc'],
                amount: stripe_array['amount'],
                description: getDescription(),
                price: stripe_array['amount'],
                payType: 'membership'
            }, function (data) {
                if (data.status == 200) {
                    $('.prem').hide();
                    $("#btnProSuccess").attr("data-ajax", data.location);
                    $("#btnProSuccess").click();
                } else {
                    $('.modal-body').html('<i class="fa fa-spin fa-spinner"></i> <?php echo __('Payment declined');?> ');
                }
            });
        }
    }

    function custom_footer_js(page_name){
        <?php if( isset( $_SESSION['JWT'] ) ){ ?>
            if( window.current_page === "myprofile" ){
            $.fancybox.defaults.btnTpl.del = '<button data-fancybox-del class="fancybox-button fancybox-button--del" title="Delete"  onClick="javascript:deleteimage(this)" >' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>'  +
                '</button>';
            $.fancybox.defaults.btnTpl.prvt = '<button data-fancybox-prvt class="fancybox-button fancybox-button--prvt" title="Make it private"  onClick="javascript:privateimage(this)" >' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>'  +
                '</button>';
            $.fancybox.defaults.btnTpl.remove_prvt = '<button data-fancybox-remove-prvt class="fancybox-button fancybox-button--remove-prvt" title="Make it public"  onClick="javascript:unprivateimage(this)" >' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 9.9-1"></path></svg>'  +
                '</button>';
            }else{
                $.fancybox.defaults.btnTpl.del = '';
                $.fancybox.defaults.btnTpl.prvt = '';
                $.fancybox.defaults.btnTpl.remove_prvt = '';
            }
            if( page_name == '' ){
                page_name = window.current_page;
            }
            if ( window.isadmin === "1" ){
                if( window.current_page === "profile" ){
                    $.fancybox.defaults.btnTpl.del = '<button data-fancybox-del class="fancybox-button fancybox-button--del" title="Delete"  onClick="javascript:deleteimageadmin(this,<?php echo $profile->id;?>)" >' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>'  +
                        '</button>';
                }
            }
        <?php } ?>



        $("#avater_profile_img2").fancybox();
        $("#avater_profile_img").fancybox();
        $.fancybox.defaults.hash = false;
        $('[data-fancybox="gallery"]').fancybox({
            beforeShow: function(){
                // fancybox is open, run myFunct()


                $('body').addClass('fancybox-show-toolbar');
                $('body').addClass('fancybox-show-infobar');
                $('body').addClass('fancybox-show-nav');

                $('.fancybox-button--del').attr('data-id', this.opts.id);

                if(typeof this.opts.private !== "undefined"){

                    if( this.opts.private === true ){
                        $('.fancybox-button--remove-prvt').show();
                        $('.fancybox-button--prvt').hide();

                        $('.fancybox-button--remove-prvt').attr('data-id', this.opts.id);
                    }else{
                        $('.fancybox-button--remove-prvt').hide();
                        $('.fancybox-button--prvt').show();

                        $('.fancybox-button--prvt').attr('data-id', this.opts.id);
                    }

                    if( this.opts.avater === true ){
                        $('.fancybox-button--remove-prvt').hide();
                        $('.fancybox-button--prvt').hide();
                    }

                }
            },
            loop: true,
            video: {
                controls: 0
            },
            afterClose: function(){
                // fancybox is closed, run myOtherFunct()
            },
            closeExisting: false,
            buttons : [
                'prvt',
                'remove_prvt',
                'del',
                'zoom',
                'slideShow',
                'thumbs',
                'close'
            ]
        });


        $('.sidenav').sidenav();
    	$('.parallax').parallax();

        $(document).ready(function(){
		    $('.dt_tstm_usr .carousel.carousel-slider,.carousel.carousel-slider').carousel({fullWidth: true,indicators: true});
        });
		setInterval(function(){
			$('.dt_tstm_usr .carousel.carousel-slider').carousel('next');
		}, 7000);


        var dropdown_trigger = document.getElementsByClassName('dropdown-trigger');
        if (dropdown_trigger !== undefined) {
            try{
                $('.dropdown-trigger').dropdown();
            } catch(e) {}
        }

       //
        $('.modal').modal();
        $('select').formSelect();

        $("select").trigger('contentChanged');
		$('.tooltipped').tooltip();
		$('.collapsible').collapsible();

        var maxdate1 = new Date();
            maxdate1.setDate(maxdate1.getDate());

        $('#start_date').datepicker({
            container: 'body',
            format: 'yyyy-mm-dd',
            maxDate: maxdate1
        });

        var maxdate = new Date();
            maxdate.setDate(maxdate.getDate() - 6574);

        // Basic Info Step 2
        var dt = $('.user_bday').datepicker({
            yearRange: [1947, 2010],
            container: 'body',
            format: 'yyyy-mm-dd',
            maxDate: maxdate
        });
        if(typeof dt[0] !== "undefined") {
            if (dt[0].value !== '0000-00-00' || dt[0].value !== '') {
                $('.user_bday').datepicker('setDate', dt[0].value);
            } else {
                var d = new Date();
                d.setDate(d.getDate() - 6574);
                $('.user_bday').datepicker('setDate', d);
            }
        }
        if (typeof dt[0] !== "undefined" && dt[0].value == '') {
            var dat = new Date();
            dat.setDate(dat.getDate() - 6574);
            $('.datepicker').datepicker('setDate', dat);
        }
        // Settings
		$('.interest_chips').chips({
			placeholder: '<?php echo __('Enter a tag, then hit enter');?>',
			secondaryPlaceholder: '<?php echo __('+Tag, Hit enter to add more');?>',
			onChipDelete: function (e, data) { interest_chipsUpdate(e, data) },
        	onChipAdd: function (e, data) { interest_chipsUpdate(e, data) }
        });
        if ( $('#interest_entry_profile').length ){
			var chips = $('#interest_entry_profile').val();
			var chips_array = chips.split(',');
			var i;
			for (i = 0; i < chips_array.length; i++) { 
				$('.interest_chips').chips('addChip', {tag: chips_array[i]});
			}
		}
    	jQuery(document).ready(function() {jQuery('.custom_fixed_element').theiaStickySidebar({additionalMarginTop: 10});});
        $("form").submit(function(e) {
            var form = $(this);
            var url = window.ajax + form.attr('action') + window.maintenance_mode;
            var button_text = form.find(':submit span').text();

            form.find(':submit').addClass( 'disabled' );
            form.find(':submit span').text( '<?php echo __( 'Loading...' );?>' );

            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                success: function(data){
                    form.find(':submit').removeClass( 'disabled' );
                    form.find(':submit span').text( button_text );
                    if( typeof data.message !== "undefined" ){
                        form.find( '.alert-danger' ).html( '' ).hide();
                        form.find( '.alert-success' ).html( data.message ).fadeIn( "fast" );
                        setTimeout(function() {
                            form.find( '.alert-success' ).fadeOut( "fast" );
                        }, 3000);
                    }else{
                        if(form.attr('action') === '/Useractions/verifyphone'){
                            form.find('.alert-danger').html("<?php echo __('Error while sending an SMS, please try again later.');?>").fadeIn("fast");
                        }else {
                            form.find('.alert-danger').html("<?php echo __('Error while submitting form.');?>").fadeIn("fast");
                        }
                        form.find( '.alert-success' ).html( '' ).hide();
                        setTimeout(function() {
                            form.find( '.alert-danger' ).fadeOut( "fast" );
                        }, 3000);
                    }
                    if( typeof(data.updateDom) !== 'undefined' ){
                        if( typeof(data.updateDom.selector) !== 'undefined' && typeof(data.updateDom.attributes) !== 'undefined' ){
                            $.each(data.updateDom.attributes, function(index, value) {
                                //console.log(data.updateDom.selector,index,value);
                                $(data.updateDom.selector).attr(index,value);
                            });
                        }
                    }
                    if ( typeof(data.cookies) !== 'undefined' ){
                        var date = new Date();
                            date.setTime(date.getTime()+(10 * 365 * 24 * 60 * 60 * 1000 ) );
                            $.each(data.cookies, function(index, value) {
                                document.cookie = index + "=" + value + "; expires=" + date.toGMTString() + "; path=/";
                            });
                    }
                    if ( typeof(data.remove_cookies) !== 'undefined' ){
                        $.each(data.remove_cookies, function(index, value) {
                            document.cookie = index+"=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/";
                        });
                    }
                    if( typeof(data.url) !== 'undefined' ){
                        form.find(':submit').addClass( 'disabled' );
                        setTimeout(function() {
                            window.location = data.url;
                        }, 2000);
                    }
                    if( typeof(data.ajaxRedirect) !== 'undefined' ){
                        form.find(':submit').addClass( 'disabled' );
                        setTimeout(function() {
                            $("#ajaxRedirect").attr("data-ajax", data.ajaxRedirect);
                            $("#ajaxRedirect").click();
                        }, 1000);
                    }
                    M.updateTextFields();
                    $("html, body").animate({ scrollTop: 0 }, 150);
                },
                error: function (data) {
                    if( data.responseJSON.status == 600 ){
                        window.location = data.responseJSON.url;
                    }else{
                        form.find( '.alert-success' ).html( '' ).hide();
                        form.find( '.alert-danger' ).html( data.responseJSON.message ).fadeIn( "fast" );
                        setTimeout(function() {
                            form.find( '.alert-danger' ).fadeOut( "fast" );
                        }, 5000);

                        form.find(':submit').removeClass( 'disabled' );
                        form.find(':submit span').text( button_text );
                    }
                },
            });

            e.preventDefault();
        });

        // stripe
        (function($){
            $(function(){
                var handler = null;
                $( document ).on( 'click', '#stripe_credit_btn', function(e) {
                    if( handler !== null ) {
                        handler.open({
                            name: '<?php echo $config->site_name;?>',
                            description: getDescription(),
                            currency: '<?php echo $config->currency;?>',
                            amount: getPrice() * 100,
                            opened: function () {
                                $('#stripe_credit').addClass('disabled');
                                $('#stripe_credit').attr('disabled', true);
                            },
                            closed: function () {
                                //document.location = window.site_url + '/credit';
                                $('#stripe_credit').removeClass('disabled');
                                $('#stripe_credit').attr('disabled', false);
                            }
                        });
                        e.preventDefault();
                    }
                });
                $( document ).on( 'click', '#stripe_creditc', function(e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    if (typeof StripeCheckout == 'undefined'){
                        $('#stripe_credit').addClass('disabled');
                        $('#stripe_credit').attr('disabled', true);
                        var script = document.createElement('script');
                            script.src = 'https://checkout.stripe.com/checkout.js';
                            script.type = 'text/javascript';
                            script.onload = script.onreadystatechange = function() {
                                if ( !this.readyState || this.readyState == "loaded" || this.readyState == "complete" ) {
                                    if (typeof StripeCheckout !== 'undefined'){
                                        handler = StripeCheckout.configure({
                                            key: '<?php echo $config->stripe_id;?>',
                                            image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                                            locale: 'english',
                                            token: function (token) {
                                                $.post(window.ajax + 'stripe/handle', {
                                                    stripeToken: token.id,
                                                    description: getDescription(),
                                                    price: getPrice(),
                                                    payType: 'credits'
                                                }, function (data) {
                                                    if (data.status == 200) {
                                                        $('#credit_amount').html(data.credit_amount);
                                                        //document.location = window.site_url + data.location;
                                                        $("#btnProSuccess").attr("data-ajax", data.location);
                                                        $("#btnProSuccess").click();
                                                    } else {
                                                        $('.modal-body').html('<i class="fa fa-spin fa-spinner"></i> <?php echo __('Payment declined');?> ');
                                                    }
                                                });
                                            }
                                        });
                                        $('#stripe_credit_btn').trigger('click');
                                    }
                                }
                            }
                            let head  = document.getElementsByTagName('head')[0];
                                head.appendChild(script);
                    }else{
                        $('#stripe_credit_btn').trigger('click');
                    }
                });
                $( document ).on( 'click', '#stripe_pro_btn', function(e) {
                    if( handler !== null ) {
                        handler.open({
                            name: '<?php echo $config->site_name;?>',
                            description: getDescription(),
                            currency: '<?php echo $config->currency;?>',
                            amount: getPrice() * 100,
                            opened: function () {
                                $('#stripe_pro').addClass('disabled');
                                $('#stripe_pro').attr('disabled', true);
                            },
                            closed: function () {
                                $('#stripe_pro').removeClass('disabled');
                                $('#stripe_pro').attr('disabled', false);
                            }
                        });
                        e.preventDefault();
                    }
                });
                $( document ).on( 'click', '#stripe_pro', function(e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    if (typeof StripeCheckout == 'undefined'){
                        $('#stripe_pro').addClass('disabled');
                        $('#stripe_pro').attr('disabled', true);
                        var script = document.createElement('script');
                        script.src = 'https://checkout.stripe.com/checkout.js';
                        script.type = 'text/javascript';
                        script.onload = script.onreadystatechange = function() {
                            if ( !this.readyState || this.readyState == "loaded" || this.readyState == "complete" ) {
                                if (typeof StripeCheckout !== 'undefined'){
                                    handler = StripeCheckout.configure({
                                        key: '<?php echo $config->stripe_id;?>',
                                        image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                                        locale: 'english',
                                        token: function (token) {
                                            $.post(window.ajax + 'stripe/handle', {
                                                stripeToken: token.id,
                                                description: getDescription(),
                                                price: getPrice(),
                                                payType: 'membership'
                                            }, function (data) {
                                                if (data.status == 200) {
                                                    $("#btnProSuccess").attr("data-ajax", data.location);
                                                    $("#btnProSuccess").click();

                                                } else {
                                                    $('.modal-body').html('<i class="fa fa-spin fa-spinner"></i> <?php echo __('Payment declined');?> ');
                                                }
                                            });
                                        }
                                    });
                                    $('#stripe_pro_btn').trigger('click');
                                }
                            }
                        }
                        let head  = document.getElementsByTagName('head')[0];
                        head.appendChild(script);
                    }else{
                        $('#stripe_pro_btn').trigger('click');
                    }
                });

            });
        })(jQuery);
    }
    custom_footer_js();
    $(window).on("popstate", function (event) {
        $(window).unbind('popstate');
        location.reload();
    });

    //$(window).on("load",function(){
        var doc = document.documentElement;
        doc.setAttribute('data-useragent', navigator.userAgent);
    //});

    $(document).on('click', '#night_mode_toggle', function(event) {
        mode = $(this).attr('data-mode');
        if (mode == 'night') {
            $('head').append('<link rel="stylesheet" href="<?php echo $theme_url;?>assets/css/night.css?<?php echo rand(1111,4444); ?>" id="night-mode-css">');
            $('#night_mode_toggle').attr('data-mode', 'day');
			$('#night_mode_toggle span').html($('#night_mode_toggle').attr('data-light-text'));
			$('#night_mode_toggle svg').html('<path fill="currentColor" d="M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,2L14.39,5.42C13.65,5.15 12.84,5 12,5C11.16,5 10.35,5.15 9.61,5.42L12,2M3.34,7L7.5,6.65C6.9,7.16 6.36,7.78 5.94,8.5C5.5,9.24 5.25,10 5.11,10.79L3.34,7M3.36,17L5.12,13.23C5.26,14 5.53,14.78 5.95,15.5C6.37,16.24 6.91,16.86 7.5,17.37L3.36,17M20.65,7L18.88,10.79C18.74,10 18.47,9.23 18.05,8.5C17.63,7.78 17.1,7.15 16.5,6.64L20.65,7M20.64,17L16.5,17.36C17.09,16.85 17.62,16.22 18.04,15.5C18.46,14.77 18.73,14 18.87,13.21L20.64,17M12,22L9.59,18.56C10.33,18.83 11.14,19 12,19C12.82,19 13.63,18.83 14.37,18.56L12,22Z" />');

        } else {
            $('#night-mode-css').remove();
            $('#night_mode_toggle').attr('data-mode', 'night');
			$('#night_mode_toggle span').html($('#night_mode_toggle').attr('data-night-text'));
			$('#night_mode_toggle svg').html('<path fill="currentColor" d="M17.75,4.09L15.22,6.03L16.13,9.09L13.5,7.28L10.87,9.09L11.78,6.03L9.25,4.09L12.44,4L13.5,1L14.56,4L17.75,4.09M21.25,11L19.61,12.25L20.2,14.23L18.5,13.06L16.8,14.23L17.39,12.25L15.75,11L17.81,10.95L18.5,9L19.19,10.95L21.25,11M18.97,15.95C19.8,15.87 20.69,17.05 20.16,17.8C19.84,18.25 19.5,18.67 19.08,19.07C15.17,23 8.84,23 4.94,19.07C1.03,15.17 1.03,8.83 4.94,4.93C5.34,4.53 5.76,4.17 6.21,3.85C6.96,3.32 8.14,4.21 8.06,5.04C7.79,7.9 8.75,10.87 10.95,13.06C13.14,15.26 16.1,16.22 18.97,15.95M17.33,17.97C14.5,17.81 11.7,16.64 9.53,14.5C7.36,12.31 6.2,9.5 6.04,6.68C3.23,9.82 3.34,14.64 6.35,17.66C9.37,20.67 14.19,20.78 17.33,17.97Z" />');
        }
        $.post(window.site_url + '?mode=' + mode);
    });
	
	$(document).on('click', '#night_mode_toggle_sidebar', function(event) {
        mode = $(this).attr('data-mode');
        if (mode == 'night') {
            $('head').append('<link rel="stylesheet" href="<?php echo $theme_url;?>assets/css/night.css?<?php echo rand(1111,4444); ?>" id="night-mode-css">');
            $('#night_mode_toggle_sidebar').attr('data-mode', 'day');
			$('#night_mode_toggle_sidebar span').html($('#night_mode_toggle_sidebar').attr('data-light-text'));
			$('#night_mode_toggle_sidebar svg').html('<path fill="currentColor" d="M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,2L14.39,5.42C13.65,5.15 12.84,5 12,5C11.16,5 10.35,5.15 9.61,5.42L12,2M3.34,7L7.5,6.65C6.9,7.16 6.36,7.78 5.94,8.5C5.5,9.24 5.25,10 5.11,10.79L3.34,7M3.36,17L5.12,13.23C5.26,14 5.53,14.78 5.95,15.5C6.37,16.24 6.91,16.86 7.5,17.37L3.36,17M20.65,7L18.88,10.79C18.74,10 18.47,9.23 18.05,8.5C17.63,7.78 17.1,7.15 16.5,6.64L20.65,7M20.64,17L16.5,17.36C17.09,16.85 17.62,16.22 18.04,15.5C18.46,14.77 18.73,14 18.87,13.21L20.64,17M12,22L9.59,18.56C10.33,18.83 11.14,19 12,19C12.82,19 13.63,18.83 14.37,18.56L12,22Z" />');

        } else {
            $('#night-mode-css').remove();
            $('#night_mode_toggle_sidebar').attr('data-mode', 'night');
			$('#night_mode_toggle_sidebar span').html($('#night_mode_toggle_sidebar').attr('data-night-text'));
			$('#night_mode_toggle_sidebar svg').html('<path fill="currentColor" d="M17.75,4.09L15.22,6.03L16.13,9.09L13.5,7.28L10.87,9.09L11.78,6.03L9.25,4.09L12.44,4L13.5,1L14.56,4L17.75,4.09M21.25,11L19.61,12.25L20.2,14.23L18.5,13.06L16.8,14.23L17.39,12.25L15.75,11L17.81,10.95L18.5,9L19.19,10.95L21.25,11M18.97,15.95C19.8,15.87 20.69,17.05 20.16,17.8C19.84,18.25 19.5,18.67 19.08,19.07C15.17,23 8.84,23 4.94,19.07C1.03,15.17 1.03,8.83 4.94,4.93C5.34,4.53 5.76,4.17 6.21,3.85C6.96,3.32 8.14,4.21 8.06,5.04C7.79,7.9 8.75,10.87 10.95,13.06C13.14,15.26 16.1,16.22 18.97,15.95M17.33,17.97C14.5,17.81 11.7,16.64 9.53,14.5C7.36,12.31 6.2,9.5 6.04,6.68C3.23,9.82 3.34,14.64 6.35,17.66C9.37,20.67 14.19,20.78 17.33,17.97Z" />');
        }
        $.post(window.site_url + '?mode=' + mode);
    });
    </script>