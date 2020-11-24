window.last_chat_call = 0;
window.is_send = false;
// Chat Messenger
function Interval(fn, time) {
    let timer = false;
    this.start = function () {
        if (!this.isRunning())
            timer = setInterval(fn, time);
    };
    this.stop = function () {
        clearInterval(timer);
        timer = false;
    };
    this.isRunning = function () {
        return timer !== false;
    };
}

function chat_request_mode(){
    $('#btn_open_private_conversation').attr('data-ajax-params',$('#btn_open_private_conversation').attr('data-ajax-params') + '&source=notification');
    $('#btn_open_private_conversation').trigger('click');
    $('#chat_message_form').hide();
    $('#chat_request_btns').removeClass('hide');
}

function LoadWorker( path, cb_func ){
    $.ajax({
        type: 'POST',
        dataType : "json",
        contentType: "application/json; charset=utf-8",
        url: window.ajax + path,
        success: function(response){
            if (response == null) {
                return;
            }
            if( response.status === 200 ) {
                cb_func(response);
            }
        },
        error: function(request,error) {
            console.log( error );
        }
    });
}
let current_notification_number = 0;

function _get_notifications(){
    if(typeof window.start_up !== undefined){
        if(window.start_up === "3"){
            LoadWorker('profile/get_notifications', function( obj ){
                var notification = obj.notifications;
                if (typeof notification !== 'undefined') {
                    if (notification > 0) {
                        $('.notification_badge').removeClass('hide').show().html(notification);
                        $( '#notificationbtn' ).attr( 'data-ajax-params','');

                        if(notification != current_notification_number) {
                            var promise = document.querySelector('#notification-sound').play();

                            if (promise !== undefined) {
                                promise.then(function() {
                                    // Autoplay started!

                                }).catch(function() {
                                    // Autoplay was prevented.
                                });
                            }

                            current_notification_number = notification;
                        }

                    } else {
                        $('.notification_badge').addClass('hide').hide();
                        $( '#notificationbtn' ).attr( 'data-ajax-params','seen=true');
                        current_notification_number = 0;
                    }
                } else {
                    current_notification_number = 0;
                    $('.notification_badge').addClass('hide').hide();
                }
                var chatnotification = obj.chatnotifications;
                if (typeof chatnotification !== 'undefined') {
                    if (chatnotification > 0) {
                        $('.chat_badge').removeClass('hide').show().html(chatnotification);
                    } else {
                        $('.chat_badge').addClass('hide').hide();
                    }
                } else {
                    $('.chat_badge').addClass('hide').hide();
                }

                if(obj.is_call == 0 && typeof obj.audio_calls == 0 && ($('#re-calling-modal').length > 0 || $('#re-talking-modal').length > 0)){
                    Wo_PlayVideoCall('stop');
                    $( '#re-calling-modal' ).remove();
                    $( '.modal-overlay' ).remove();
                    $( 'body' ).removeClass( "modal-open" );
                }


                var videochatnotification = obj.calls;
                if ( videochatnotification == 200 && $('#re-calling-modal').length == 0 && $('#re-talking-modal').length == 0) {
                    if ($('#calling-modal').length == 0) {
                        $('body').append(obj.calls_html);
                        if (!$('#re-calling-modal').hasClass('calling')) {
                            $('#re-calling-modal').modal({dismissible: false});
                            $('#re-calling-modal').modal('open');
                            Wo_PlayVideoCall('play');
                        }
                        document.title = 'New video call..';
                        setTimeout(function () {
                            $('.modal').modal('close');
                            $('#re-calling-modal').addClass('calling');
                            Wo_PlayVideoCall('stop');
                            document.title = document_title;
                            setTimeout(function () {
                                $( '#re-calling-modal' ).remove();
                                $( '.modal-overlay' ).remove();
                                $( 'body' ).removeClass( "modal-open" );
                            }, 3000);
                            $( '#re-calling-modal' ).remove();
                            $('.modal-overlay.in').hide();
                        }, 40000);
                    }
                }

                var audiochatnotification = obj.audio_calls;
                if ( audiochatnotification == 200 && $('#re-calling-modal').length == 0 && $('#re-talking-modal').length == 0) {
                    if ($('#calling-modal').length == 0) {
                        $('body').append(obj.audio_calls_html);
                        if (!$('#re-calling-modal').hasClass('calling')) {
                            $('#re-calling-modal').modal({dismissible: false});
                            $('#re-calling-modal').modal('open');
                            Wo_PlayVideoCall('play');
                        }
                        document.title = 'New audio call..';
                        setTimeout(function () {
                            //console.log('i execute but not close');
                            if( obj.is_audio_call == 0 ) {
                                $('.modal').modal('close');
                                $('#re-calling-modal').addClass('calling');
                                Wo_PlayVideoCall('stop');
                                document.title = document_title;
                                setTimeout(function () {
                                    $('#re-calling-modal').remove();
                                    $('.modal-overlay').remove();
                                    $('body').removeClass("modal-open");
                                }, 3000);
                                $('#re-calling-modal').remove();
                                $('.modal-overlay.in').hide();
                            }
                        }, 40000);
                    }
                }
            });
        }
    }
}

function _get_conversation_list(accepted){
    if(accepted === null){
        accepted = 1;
    }
    if(typeof accepted === "undefined"){
        accepted = 1;
    }

    let chat_search_online = $('#chat_search_online').prop('checked');
    LoadWorker('chat/get_conversation_list/'+chat_search_online+'?accepted='+accepted, function( obj ){
        let conversations = obj.conversations;
        let OnlineUsers = obj.OnlineUsers;
        if (typeof conversations !== 'undefined') {
            if (conversations !== "") {
                $('#m_conversation').html(conversations);
            }else{
                $('#m_conversation').html('');
            }
        }
        let onlines = $('.m_conversation li[data-online="1"]').length;
        if( onlines > 0 ){
            $('.chat_count').removeClass('hide').show().html(onlines);
        }else{
            $('.chat_count').html('').addClass('hide').hide();
        }
        // if (typeof OnlineUsers !== 'undefined') {
        //     if($('#m_conversation').html() === ''){
        //         $('.chat_count').html('').addClass('hide').hide();
        //     }else {
        //         if (OnlineUsers > 0) {
        //             $('.chat_count').removeClass('hide').show().html(OnlineUsers);
        //         } else {
        //             $('.chat_count').addClass('hide').hide();
        //         }
        //     }
        // }
        if(typeof obj.requests !== 'undefined'){
            $('#requests_count').html(obj.requests);
        }
    });
}

function _get_chat_conversation(id){
    // if( $('#btn_chat_f_send').hasClass('hide') ){
    //     return true;
    // }
    let lastmsg = $('.messages:last').attr('data-lastid');
    let url = 'chat/get_chat_conversation/' + id;
    if( typeof lastmsg !== "undefined"){
        url = url + '/' + lastmsg;
    }
    LoadWorker(url, function( obj ){
        let conversations = obj.conversations;

        if (typeof obj.time !== 'undefined') {
            $('#time').val(obj.time);
        }
        if (typeof conversations !== 'undefined') {
            if (conversations !== "") {
                let last_existing_id = $( '.messages:last' ).attr('data-lastid');
                let last_get_id = $( conversations ).last().attr('data-lastid');
                if( typeof lastmsg == "undefined"){
                    $('.chat_body_content').empty();
                }

               $('.chat_body_content').append(conversations).imagesLoaded().then(function () {

                   $(".messages[data-msgid]").each(function(){
                       var data = $(this).attr('data-msgid');
                       $('.messages[data-msgid="'+data+'"]').not(':last').remove();
                   });


                   $('.seen').remove();
                   if( $('.seen').length == 0 ) {
                       if ($('.message[data-messageid="' + obj.lastseenid + '"]').parent().parent().parent().hasClass('messages--sent')) {
                           $('.message[data-messageid="' + obj.lastseenid + '"]').parent().after('<div class="seen time ajax-time" data-seen="" title=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#03A9F4" d="M0.41,13.41L6,19L7.41,17.58L1.83,12M22.24,5.58L11.66,16.17L7.5,12L6.07,13.41L11.66,19L23.66,7M18,7L16.59,5.58L10.24,11.93L11.66,13.34L18,7Z" /></svg></div>');
                       }
                   }
                   if (typeof last_existing_id !== typeof undefined && last_existing_id !== "undefined") {
                       if( last_existing_id !== last_get_id ){
                           var scrollHeight = $(".chat_body_content")[0].scrollHeight;
                           var scrollTop = $('.chat_body_content').scrollTop();
                           var innerHeight = $('.chat_body_content').innerHeight();
                           var totalHeight = scrollTop + innerHeight;
                           if (totalHeight >= scrollHeight) {
                               $( '#message_box' ).find( '.chat_body_content' ).stop().animate({scrollTop:$( '.chat_body_content' )[0].scrollHeight}, 500, 'swing', function() {});
                               //console.log('end reached');
                           } else if (scrollHeight - innerHeight < totalHeight) {
                               $( '#message_box' ).find( '.chat_body_content' ).stop().animate({scrollTop:$( '.chat_body_content' )[0].scrollHeight}, 500, 'swing', function() {});
                           } else if (scrollTop <= 0) {
                               //console.log('Top reached');
                           } else {
                               //console.log('middle');
                           }
                       }
                   }else{
                       $( '#message_box' ).find( '.chat_body_content' ).stop().animate({scrollTop:$( '.chat_body_content' )[0].scrollHeight}, 500, 'swing', function() {});
                   }
                   $('#dt_emoji').trigger('focus');
               });



            }else{
                $('.seen').remove();
                if ($('.message[data-messageid="' + obj.lastseenid + '"]').parent().parent().parent().hasClass('messages--sent')) {
                    $('.message[data-messageid="' + obj.lastseenid + '"]').parent().after('<div class="seen time ajax-time" data-seen="" title=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#03A9F4" d="M0.41,13.41L6,19L7.41,17.58L1.83,12M22.24,5.58L11.66,16.17L7.5,12L6.07,13.41L11.66,19L23.66,7M18,7L16.59,5.58L10.24,11.93L11.66,13.34L18,7Z" /></svg></div>');
                }
            }
        }
    });
}

function old_get_chat_conversation(id){
    let url = 'chat/get_chat_conversation/' + id
    let lastmsg = $('.messages:last').attr('data-lastid');
    LoadWorker(url, function( obj ){
        let conversations = obj.conversations;
        if (typeof conversations !== 'undefined') {
            if (conversations !== "") {
                $('.seen:not(:last)').remove();
                let last_existing_id = $( '.messages:last' ).attr('data-lastid');
                let last_get_id = $( conversations ).last().attr('data-lastid');
                $('.chat_body_content').empty().html(conversations).imagesLoaded().then(function () {
                    $('.seen:not(:last)').remove();

                    if (typeof last_existing_id !== typeof undefined && last_existing_id !== "undefined") {
                        if( last_existing_id !== last_get_id ){
                            var scrollHeight = $(".chat_body_content")[0].scrollHeight;
                            var scrollTop = $('.chat_body_content').scrollTop();
                            var innerHeight = $('.chat_body_content').innerHeight();
                            var totalHeight = scrollTop + innerHeight;
                            if (totalHeight >= scrollHeight) {
                                $( '#message_box' ).find( '.chat_body_content' ).stop().animate({scrollTop:$( '.chat_body_content' )[0].scrollHeight}, 500, 'swing', function() {});
                                //console.log('end reached');
                            } else if (scrollHeight - innerHeight < totalHeight) {
                                $( '#message_box' ).find( '.chat_body_content' ).stop().animate({scrollTop:$( '.chat_body_content' )[0].scrollHeight}, 500, 'swing', function() {});
                            } else if (scrollTop <= 0) {
                                //console.log('Top reached');
                            } else {
                                //console.log('middle');
                            }
                        }
                    }else{
                        $( '#message_box' ).find( '.chat_body_content' ).stop().animate({scrollTop:$( '.chat_body_content' )[0].scrollHeight}, 500, 'swing', function() {});
                    }
                    $('#dt_emoji').trigger('focus');
                });

            }
        }
    });
}

function load_chat_conversation_list( search, is_online ){
    let response = "";
    let formData = new FormData();
        formData.append( 'search_text', decodeURIComponent( search ) );
        formData.append( 'is_online', is_online );

    let url = window.ajax + '/chat/search';
    let currentRequest = null;
    currentRequest = $.ajax({
        url: url,
        type: "POST",
        async: false,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000,
        dataType: false,
        beforeSend : function()    {
            if(currentRequest != null) {
                currentRequest.abort();
            }
        },
        success: function(result) {
            if( result.status === 200 ){
                response = result.message;
            }
        }
    });
    return response;
}

function send_chat_message(msg){
    $('.lds-facebook').removeClass('hide');
    $('#btn_chat_f_send').addClass('hide');
    let lastmsg = $('.messages:last').attr('data-lastid');
    let form = $("#chat_message_form");
    let url = window.ajax + form.attr('action');
    if( msg == $('#dt_emoji').val() ){
        msg = '';
    }
    msg = encodeURIComponent(msg);
    $.ajax({
        type: 'POST',
        url: url,
        data: form.serialize() + msg,
        success: function (data) {
            if(typeof data.need_recharge !== "undefined"){
                $( '#buy_chat_credits' ).modal("open");
                $('#btn_chat_f_send').removeClass('hide');
                $('.lds-facebook').hide();
                return;
            }

            let el = $( '#dt_emoji' ).emojioneArea();
            if(typeof el.data( 'emojioneArea' ).editor !== "undefined"){
                el.data( 'emojioneArea' ).setText('');
                el.data( 'emojioneArea' ).editor.focus();
            }else{
                $('#dt_emoji').text('');
                $('#dt_emoji').focus();
            }
            $('#message_box').find('.chat_body_content').stop().animate({scrollTop: $('.chat_body_content')[0].scrollHeight}, 500, 'swing', function () {
            });
            $('#btn_chat_f_send').removeClass('hide');
            $('.lds-facebook').addClass('hide');

            window.last_chat_call = data.msg;

            window.is_send = true;

            //if(window.internet_speed > 50) {
                _get_chat_conversation(data.to);
            //}
            window.is_send = false;
        },
        error: function (data) {
            if( data.responseJSON.blacklist == true ){
                $( '.chat_foot' ).remove();
                $( '#navigateBack' ).trigger('click');
            }

            if( data.responseJSON.declined == true || data.responseJSON.spam == true ){
                $( '.chat_foot' ).remove();

                $('#chat_declined_modal').modal();
                $('#chat_declined_modal #chat_declined_modal_container').html(data.responseJSON.message);
                $('#chat_declined_modal').modal('open');
            }

            if( data.responseJSON.spam == true ){
                $( '.chat_foot' ).remove();

                $('#chat_declined_modal').modal();
                $('#chat_declined_modal #chat_declined_modal_container').html(data.responseJSON.message);
                $('#chat_declined_modal').modal('open');
            }
        }
    });
}

function callback_open_conversation( data ){
    if( data.status == 200 ){
        if( data.accepted === 0){
            //$('#chat_message_form').hide();
            $('#chat_message_form').html('');
            $('#chat_message_form').removeAttr('method');
            $('#chat_message_form').removeAttr('action');
            $('#chat_request_btns').removeClass('hide');
        }else{
            $('#chat_message_form').show();
            $('#chat_request_btns').addClass('hide');
        }

        if( typeof data.declined !== "undefined"){
            if( data.declined === false ){
                $('#rts_vsdhjh98').val(0);
            }else{
                $('#rts_vsdhjh98').val(1);
            }
        }

        if( typeof data.last_decline !== "undefined"){
            if( data.last_decline > 0 ){
                $('#timestamp').val(data.last_decline);
            }else{
                $('#timestamp').val(0);
            }
        }

        if( typeof data.last_decline_message !== "undefined"){
            if( data.last_decline_message !== '' ){
                $('#last_decline_message').val(data.last_decline_message);
            }else{
                $('#last_decline_message').val('');
            }
        }



        $('#vxd').val(data.to.id);
        $('#dfgetevxd').val(data.receiver);
        let cssId = 'emojionearea';
        if (!document.getElementById(cssId)) {
            let head  = document.getElementsByTagName('head')[0];
            let link  = document.createElement('link');
            let script = document.createElement('script');
            script.src = window.theme_url + 'assets/js/emojionearea.min.js';
            script.type = 'text/javascript';
            script.onload = script.onreadystatechange = function() {
                if ( !this.readyState || this.readyState === "loaded" || this.readyState === "complete" ) {
                    $("#dt_emoji").emojioneArea({
                        events: {
                            keyup: function(editor, event) {
                                let emojioneArea = this;
                                if (event.which === 13 && !event.shiftKey) {
                                    send_chat_message( $( '#dt_emoji' ).data( 'emojioneArea' ).getText() );
                                    emojioneArea.setText('');
                                    emojioneArea.hidePicker();
                                    emojioneArea.editor.focus();
                                    event.preventDefault();
                                }
                            }
                        },
                        search: false,
                        recentEmojis: false,
                        filtersPosition: "bottom",
                        tones: false,
                        autocomplete: true,
                        filters: {flags : false}
                    });
                    setTimeout(function(){
                        if($( '#dt_emoji' ).length) {
                            $('#dt_emoji').data('emojioneArea').setText('');
                            $('#dt_emoji').trigger('focus');
                        }
                    }, 1000);
                    script.onload = script.onreadystatechange = null;
                    head.removeChild(script);
                    $('#dt_emoji').removeClass('hide');
                    $('.chat_f_send').removeClass('hide');
                }
            }
            link.id   = cssId;
            link.rel  = 'stylesheet';
            link.type = 'text/css';
            link.href = window.theme_url + 'assets/css/emojionearea.min.css';
            link.media = 'all';
            head.appendChild(link);
            head.appendChild(script);
        }
        if (window._get_conversationListInterval) {
            window._get_conversationListInterval.stop();
        }

        $( '#loader' ).css( 'display', 'block' );
        $( '.msg_chat' ).removeClass( 'hide' );
        $( '.msg_list' ).hide();
        $( '.msg_chat' ).show();
        $('#chatfromuser').attr('href', window.site_url + '/@' + data.to.username );

        $('#btn_chat_accept_message').attr('data-route1', '@' + data.to.username );
        $('#btn_chat_decline_message').attr('data-route1', '@' + data.to.username );

        $('.chat_participant .c_avatar img').attr( 'src', data.to.avater.avater );
        $('.chat_participant .c_name .name').html( data.to.full_name );
        $('.chat_participant .c_name .last_seen').html( $.timeago(data.to.lastseen_date) );
        $('.chat_participant .c_name .last_seen').attr( 'title', data.to.lastseen_date );
        $('#to_message').attr( 'value', data.receiver);
        $( '.chat_body_content' ).html( data.messages ).imagesLoaded().then(function(){
            $('#message_box').removeClass('open_list').addClass('open_chat');
            let body = $( '#message_box' ).find( '.chat_body_content' );
                body.stop().animate({scrollTop:$( '.chat_body_content' )[0].scrollHeight}, 500, 'swing', function() {});
        });
        _get_chat_conversation(data.to.id);
        window._get_chatConversationsInterval = new Interval(function () {
            _get_chat_conversation(data.to.id);
        }, window.worker_updateDelay);
        window._get_chatConversationsInterval.start();

    }else{
        M.toast({html: data.message});
    }
}

function open_private_conversation( data ) {
    if( data.status == 200 ) {
        if( data.mode == 'credits' ) {
            $( '#buy_chat_credits' ).modal("open");
        }

        if( data.mode == 'chat' ) {
            $( '#loader' ).css( 'display', 'block' );
            $( '.msg_chat' ).removeClass( 'hide' );
            $( '.msg_list' ).hide();
            $( '.chat_body_content').empty();
            $( '#message_box' ).removeClass( 'hide' );
            $( '#navigateBack' ).addClass( 'hide' );
            $( '#message_box' ).addClass( 'modal' );
            $( '#message_box').modal({
                dismissible: false,
                onOpenEnd: function(){

                    callback_open_conversation(data);
                },
                onCloseEnd: function(){
                    if( $('.chat_body_content').html() !== '' ) {
                        $.get(window.ajax + 'chat/createNewConversation', {receiver_id: $('#to_message').val()}, function (data, status) {});
                    }
                    if (window._get_chatConversationsInterval) {
                        window._get_chatConversationsInterval.stop();
                    }
                    $( '#navigateBack' ).removeClass( 'hide' );
                    $( '.msg_chat' ).addClass( 'hide' );
                    $( '.msg_list' ).show();
                }
            }).modal("open");
        }

    }else{
        $( '.chat_foot' ).remove();
        $('#chat_declined_modal').modal();
        $('#chat_declined_modal #chat_declined_modal_container').html(data.message);
        $('#chat_declined_modal').modal('open');

    }
}

(function($){
    $(function(){
        $(window).on('load',function() {
            _get_notifications();
            window._get_notificationsInterval = new Interval(function () {
                _get_notifications();
            }, window.worker_updateDelay);
            window._get_notificationsInterval.start();

            window._updateuserlastseen = new Interval(function () {
                $.get( window.ajax + 'chat/record_user_lastseen' ,function(data, status){
                    if (data.can_send == 1) {
                        SendMessages();
                    }
                });
            }, 60000);
            window._updateuserlastseen.start();
        });

        $( document ).on( 'keyup', '#dt_emoji', function(e){
            if (e.which === 13 && !e.shiftKey) {
                send_chat_message( $('#dt_emoji').val() );
                $(this).val('');
                $(this).focus();
                e.preventDefault();
            }
        });

        $(document).on('click','#btn_chat_accept_message',function(e){
            e.preventDefault();
            window.current_route1 = $(this).attr('data-route1');
            window.current_route2 = $(this).attr('data-route2');
            let route = '/' +window.current_route1 + '/' + window.current_route2;
            if(window.current_route1 !== '' && window.current_route2 !== ''){
                $.get( window.ajax + 'chat/accept_chat_request?route='+route, function(data, status){
                    if( data.status == 200 ){
                        //window.location = window.site_url + '/' + window.current_route1 + '?accepted';
                        window.history.pushState({state:'new'},'', window.site_url + '/' + window.current_route1 + '?accepted');
                        $('#chat_request_btns').addClass('hide');
                        $('#chat_message_form').attr('action','/chat/send_message');
                        $('#chat_message_form').attr('method','POST');
                        $('#chat_message_form').replaceWith(data.form).show();
                        $('#to_message').val($('#dfgetevxd').val());

                        $('#dt_emoji').addClass('hide');

                        $("#dt_emoji").emojioneArea({
                            events: {
                                keyup: function(editor, event) {
                                    let emojioneArea = this;
                                    if (event.which === 13 && !event.shiftKey) {
                                        send_chat_message( $( '#dt_emoji' ).data( 'emojioneArea' ).getText() );
                                        emojioneArea.setText('');
                                        emojioneArea.hidePicker();
                                        emojioneArea.editor.focus();
                                        event.preventDefault();
                                    }
                                }
                            },
                            search: false,
                            recentEmojis: false,
                            filtersPosition: "bottom",
                            tones: false,
                            autocomplete: true,
                            filters: {flags : false}
                        });
                        setTimeout(function(){
                            if($( '#dt_emoji' ).length) {
                                $('#dt_emoji').data('emojioneArea').setText('');
                                $('#dt_emoji').trigger('focus');
                            }
                        }, 1000);
                        //script.onload = script.onreadystatechange = null;
                        //head.removeChild(script);
                        $('#dt_emoji').removeClass('hide');
                        $('.chat_f_send').removeClass('hide');

                    }else{
                        M.toast({html: data.message});
                    }
                });
            }

            return false;
        });
        $(document).on('click','#btn_chat_decline_message',function(e){
            e.preventDefault();
            window.current_route1 = $(this).attr('data-route1');
            window.current_route2 = $(this).attr('data-route2');
            let route = '/' + window.current_route1 + '/' + window.current_route2;
            if(window.current_route1 !== '' && window.current_route2 !== ''){
                $.get( window.ajax + 'chat/decline_chat_request?route='+route, function(data, status){
                    if( data.status == 200 ){
                        $('#message_box').modal('close');
                        window.location = window.site_url + '/' + window.current_route1;
                        //window.history.pushState({state:'new'},'', window.site_url + '/' + window.current_route1);
                    }else{
                        M.toast({html: data.message});
                    }
                });
            }
            ;
            return false;
        });

        $( document ).on( 'click', '#messenger_opener', function(e){
            $('.msg_chat').hide();
            $('.msg_list').show();
            $('#m_conversation').html('');
            $('#m_conversation_search').html('');
            $('.chat_count').hide().addClass('hide');
            let message_box = $( '#message_box' );
                message_box.removeClass( 'hide' );
                message_box.addClass( 'modal' );
                message_box.modal({
                    // dismissible: false,
                    onOpenEnd: function(){
                        _get_conversation_list();
                        if (window._get_chatConversationsInterval) {
                            window._get_chatConversationsInterval.stop();
                        }
                        window._get_conversationListInterval = new Interval(function () {
                            _get_conversation_list();
                        }, window.worker_updateDelay);
                        window._get_conversationListInterval.start();
                    },
                    onCloseEnd: function(){
                        if (window._get_conversationListInterval) {
                            window._get_conversationListInterval.stop();
                        }
                        if (window._get_chatConversationsInterval) {
                            window._get_chatConversationsInterval.stop();
                        }
                        $('#message_box').removeClass('open_chat').addClass('open_list');
                        $('body').css({'overflow':'auto'});
                    }
                }).modal("open");
        });
        $( document ).on( 'click', '#navigateBack', function(e){
            if (!window._get_conversationListInterval.isRunning()) {
                window._get_conversationListInterval.start();
            }
            if (window._get_chatConversationsInterval) {
                window._get_chatConversationsInterval.stop();
            }
            _get_conversation_list();
            $( '.msg_chat' ).addClass( 'hide' );
            $( '.msg_list' ).show();
            e.preventDefault();
            setTimeout(function(){
                $('#message_box').removeClass('open_chat').addClass('open_list');
            }, 100);
        });
        $( document ).on( 'input', '#chat_search', function(e){
            let chat_search_online = $( '#chat_search_online' ).prop( 'checked' );
            let input_lenght = $( this ).val().length;
            let conversation_list = "";
            let m_conversation = $( '#m_conversation' ), m_conversation_search = $( '#m_conversation_search' );
            if( input_lenght > 0 ){
                $('#search-loader').removeClass('hide');
                conversation_list = load_chat_conversation_list( $( this ).val(), chat_search_online );
                m_conversation.hide();
                m_conversation_search.show();
                m_conversation_search.html( conversation_list );
                setTimeout(function(){
                    $('#search-loader').addClass('hide');
                },300);
            }else{
                m_conversation.show();
                m_conversation_search.hide();
            }
        });
		$('.chat_stts_dropd').dropdown({
			closeOnClick: false,
			alignment: 'right'
		});
		$( document ).on( 'change', '#chat_go_online', function(e){
            //let chat_go_online = $(this).prop('checked');
            let url = window.ajax + 'chat/chat_change_online';
            $.ajax({
                type: 'POST',
                url: url,
                data: null,
                success: function (data) {
                    if( data.status === 200 ){

                    }
                }
            });
            e.preventDefault();
        });
		$( document ).on( 'change', '#chat_search_online', function(e){
            $( '#chat_search' ).trigger( 'input' );
        });
		$( document ).on( 'click', '#btn_reset_chat_search', function(e){
            $( '#chat_search' ).val( "" );
            $( '#m_conversation_search' ).show();
            $( '#m_conversation_search' ).html("");
            $( '#m_conversation' ).show();
            $( '#reset_chat_search' ).addClass( 'hide' );
        });

		$.fn.imagesLoaded = function () {
            let $imgs = this.find('img[src!=""]');
            if (!$imgs.length) {return $.Deferred().resolve().promise();}
            let dfds = [];
            //$imgs.each(function(){
            let i;
            for ( i = $imgs.length - 1 ; i >= 0; i--) {
                //console.log($imgs[i]);
                let dfd = $.Deferred();
                dfds.push(dfd);
                let img = new Image();
                let source = $($imgs[i]).attr('data-src');
                img.onload = function () {
                    $('.chat_body_content').find('img[data-src="' + img.src + '"]').attr('src', source);
                    dfd.resolve();
                }
                img.onerror = function () {
                    dfd.resolve();
                }
                img.src = $($imgs[i]).attr('data-src');
            }
            //});
            $('.chat_body_content').animate({scrollTop: 9999999999999999}, 500);
            return $.when.apply($,dfds);
        };
        $( document ).on( 'click', '#btn_load_prev_chat_message', function(e) {
            e.preventDefault();
            let first_existing_id = $('.message:first').attr('data-messageid');
            let from = $( '#to_message' ).val();

            let path = '/chat/get_prev_messages/'+from+'/'+first_existing_id;
            $.ajax({
                type: 'POST',
                dataType : "json",
                contentType: "application/json; charset=utf-8",
                url: window.ajax + path,
                success: function(response){
                    if( response.status === 200 ) {
                        if( response.conversations !== '' ) {
                            $('.chat_body_content').prepend(response.conversations);
                        }else{
                            $('#btn_load_prev_chat_message').html($('#btn_load_prev_chat_message').attr('data-lang-nomore')).attr('disabled',true);
                            $('.chat_body_content').css({'padding-top':'50px'});
                        }
                    }
                },
                error: function(request,error) {
                    //console.log( error );
                }
            });

        });

        $('.chat_body_content').on('scroll', function() {
            var scrollHeight = $(".chat_body_content")[0].scrollHeight;
            var scrollTop = $('.chat_body_content').scrollTop();
            var innerHeight = $('.chat_body_content').innerHeight();
            var totalHeight = scrollTop + innerHeight;
            if (totalHeight >= scrollHeight) {
                $('#btn_load_prev_chat_message').addClass('hide');
            } else if (scrollHeight - innerHeight < totalHeight) {
            } else if (scrollTop <= 0) {
                $('#btn_load_prev_chat_message').removeClass('hide');
            } else {
                $('#btn_load_prev_chat_message').addClass('hide');
            }
        });
        $( document ).on( 'click', '#btn_chat_f_send', function(e){
            send_chat_message( '' );
            $('#dt_emoji').text('');
            $( '#dt_emoji' ).data( 'emojioneArea' ).setText('');
            $( '#dt_emoji' ).data( 'emojioneArea' ).editor.focus();
            e.preventDefault();
        });

        $( document ).on( 'click', '#chat_message_upload_media' , function(e){
            let declined = $( '#rts_vsdhjh98' ).val();
            if( declined == 1 ){
                //qbizns
                $('.chat_foot').remove();
                var difference = $('#time').val() - $('#timestamp').val();
                var daysDifference = 24 - Math.floor(difference/60/60);
                let msg = $('#last_decline_message').val();
                $('#chat_declined_modal').modal();
                $('#chat_declined_modal #chat_declined_modal_container').html(msg.replace(/HH/g, daysDifference));
                $('#chat_declined_modal').modal('open');
                return;
            }else {
                document.getElementById('chat_message_upload_media_file').click();
                return;
            }

        });

        $( document ).on( 'change', '#chat_message_upload_media_file', function(e){
            var countFiles = $(this)[0].files.length;
            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

            if(countFiles > 1) {
                M.toast({html: 'Please select Four Images only.'});
            } else if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {

                let from = $( '#to_message' ).val();
                let formData = new FormData();
                formData.append("media0", $(this)[0].files[0],$(this)[0].files[0].value );
                formData.append( 'to' , from );

                $('.lds-facebook').removeClass('hide');
                $('#btn_chat_f_send').addClass('hide');

                $( '.chat_message_upload_media_imgprogress' ).removeClass( 'hide' );
                $( '.chat_message_upload_media_imgstatus' ).removeClass( 'hide' );
                $.ajax({
                    xhr: function() {
                        let xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt){
                            if (evt.lengthComputable) {
                                let percentComplete = evt.loaded / evt.total;
                                percentComplete = parseInt(percentComplete * 100);
                                //console.log( 'prog: ' + percentComplete + '%');
                                $( '#chat_message_upload_media_imgstatus' ).html( percentComplete + '%');
                                $( '.chat_message_upload_media_imgdeterminate' ).css({'width': percentComplete + '%'});
                                if (percentComplete === 100) {
                                    $( '.chat_message_upload_media_imgprogress' ).addClass( 'hide' );
                                    $( '.chat_message_upload_media_imgstatus' ).addClass( 'hide' );
                                    $( '#chat_message_upload_media_imgstatus' ).html( '' );
                                }
                            }
                        }, false);
                        return xhr;
                    },
                    url: window.ajax + '/chat/upload_media',
                    type: "POST",
                    async: true,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    timeout: 60000,
                    dataType: false,
                    success: function(result) {
                        $('#btn_chat_f_send').removeClass('hide');
                        $('.lds-facebook').addClass('hide');

                        if( result.status === 200 ){
                            let el = $( '#dt_emoji' ).emojioneArea();
                            el.data( 'emojioneArea' ).setText('');
                            if( typeof el.data( 'emojioneArea' ).editor !== "undefined" ){
                                el.data( 'emojioneArea' ).editor.focus();
                            }
                            _get_chat_conversation(from);
                        }
                    }
                });

            }else{
                M.toast({html: 'Please select only Images.'});
            }
        });

        $( document ).on( 'click', '#deletechatconversations', function(e){
            let form = $("#chat_message_form");
            let url = window.ajax + 'chat/delete_messages';
            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                success: function (data) {
                    let message_box = $('#message_box');
                    if( data.status === 200 ){
                        message_box.modal("close");
                        message_box.removeClass('open_chat').addClass('open_list');
                    }
                }
            });
            e.preventDefault();
        });

        $( document ).on( 'click', '.stiker_chat', function(e){
            $( '#stiker_box' ).modal("close");
            $('.lds-facebook').removeClass('hide');
            $('#btn_chat_f_send').addClass('hide');


            let id = $( this ).attr( 'data-id' );
            let form = $("#chat_message_form");
            let url = window.ajax + form.attr('action');
            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize() + '&sticker=' + id,
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
            e.preventDefault();
        });

        $( document ).on( 'click', '#chat_message_upload_stiker', function(e){
            let declined = $( '#rts_vsdhjh98' ).val();
            if( declined == 1 ){
                //qbizns
                $('.chat_foot').remove();
                var difference = $('#time').val() - $('#timestamp').val();
                var daysDifference = 24 - Math.floor(difference/60/60);
                let msg = $('#last_decline_message').val();
                $('#chat_declined_modal').modal();
                $('#chat_declined_modal #chat_declined_modal_container').html(msg.replace(/HH/g, daysDifference));
                $('#chat_declined_modal').modal('open');
                return;
            }

            let stickerbox = $( '#stiker_box' );
                stickerbox.removeClass( 'hide' );
                stickerbox.addClass( 'modal' );
                stickerbox.modal({
                    onOpenEnd: function(){
                        $.ajax({
                            xhr: function() {
                                let xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt){
                                    if (evt.lengthComputable) {
                                        let percentComplete = evt.loaded / evt.total;
                                        percentComplete = parseInt(percentComplete * 100);
                                        //console.log(percentComplete);
										$( '.stiker_imgprogress' ).removeClass( 'hide' );
                                        $( '.stiker_imgdeterminate' ).css({'width': percentComplete + '%'});
                                        if (percentComplete === 100) {
                                            $( '.stiker_imgprogress' ).addClass( 'hide' );
                                            $( '.stiker_imgstatus' ).addClass( 'hide' );
                                        }
                                    }
                                }, false);
                                return xhr;
                            },
                            url: window.ajax + 'chat/get_stickers',
                            async: true,
                            cache: false,
                            contentType: false,
                            processData: false,
                            timeout: 60000,
                            dataType: false,
                            success: function(result) {
                                if( result.status === 200 ){
                                    $( '#stikerlist' ).html(result.stickers);
                                }
                            }
                        });
                        if (window._get_chatConversationsInterval) {
                            window._get_chatConversationsInterval.stop();
                        }
                    }
                }).modal("open");
        });


        $( document ).on( 'click', '#chat_message_gify', function(e){
            let declined = $( '#rts_vsdhjh98' ).val();
            if( declined == 1 ){
                //qbizns
                $('.chat_foot').remove();
                var difference = $('#time').val() - $('#timestamp').val();
                var daysDifference = 24 - Math.floor(difference/60/60);
                let msg = $('#last_decline_message').val();
                $('#chat_declined_modal').modal();
                $('#chat_declined_modal #chat_declined_modal_container').html(msg.replace(/HH/g, daysDifference));
                $('#chat_declined_modal').modal('open');
                return;
            }

            let gify_box = $( '#gify_box' );
            gify_box.removeClass( 'hide' );
            gify_box.addClass( 'modal' );
            gify_box.modal({
                onOpenEnd: function(){
                    $('#gify_search').focus();
                    if (window._get_chatConversationsInterval) {
                        window._get_chatConversationsInterval.stop();
                    }
                }
            }).modal("open");
        });

        $( document ).on( 'input', '#gify_search', function(e){
            let input_lenght = $( this ).val().length;
            let gify_list = "";
            if( input_lenght > 0 ){
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
                $('#gifylist').html(chat_gif_loading);
                GetGifyChat($( this ).val());
            }
        });

        $( document ).on( 'click', '#reload_gifs', function(e){
            let search = $( '#gify_search' ).val();
            if(search == ''){
                search = 'random'
            }
            GetGifyChat(search);
        });



    });
})(jQuery);