(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD (Register as an anonymous module)
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var pluses = /\+/g;

    function encode(s) {
        return config.raw ? s : encodeURIComponent(s);
    }

    function decode(s) {
        return config.raw ? s : decodeURIComponent(s);
    }

    function stringifyCookieValue(value) {
        return encode(config.json ? JSON.stringify(value) : String(value));
    }

    function parseCookieValue(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape...
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }

        try {
            // Replace server-side written pluses with spaces.
            // If we can't decode the cookie, ignore it, it's unusable.
            // If we can't parse the cookie, ignore it, it's unusable.
            s = decodeURIComponent(s.replace(pluses, ' '));
            return config.json ? JSON.parse(s) : s;
        } catch(e) {}
    }

    function read(s, converter) {
        var value = config.raw ? s : parseCookieValue(s);
        return $.isFunction(converter) ? converter(value) : value;
    }

    var config = $.cookie = function (key, value, options) {

        // Write

        if (arguments.length > 1 && !$.isFunction(value)) {
            options = $.extend({}, config.defaults, options);

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
            }

            return (document.cookie = [
                encode(key), '=', stringifyCookieValue(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path    ? '; path=' + options.path : '',
                options.domain  ? '; domain=' + options.domain : '',
                options.secure  ? '; secure' : ''
            ].join(''));
        }

        // Read

        var result = key ? undefined : {},
            // To prevent the for loop in the first place assign an empty array
            // in case there are no cookies at all. Also prevents odd result when
            // calling $.cookie().
            cookies = document.cookie ? document.cookie.split('; ') : [],
            i = 0,
            l = cookies.length;

        for (; i < l; i++) {
            var parts = cookies[i].split('='),
                name = decode(parts.shift()),
                cookie = parts.join('=');

            if (key === name) {
                // If second argument (value) is a function it's a converter...
                result = read(cookie, value);
                break;
            }

            // Prevent storing a cookie that we couldn't decode.
            if (!key && (cookie = read(cookie)) !== undefined) {
                result[name] = cookie;
            }
        }

        return result;
    };

    config.defaults = {};

    $.removeCookie = function (key, options) {
        // Must not alter options, thus extending a fresh object...
        $.cookie(key, '', $.extend({}, options, { expires: -1 }));
        return !$.cookie(key);
    };

}));
/*done*/
function Wo_progressIconLoader(e) {e.each(function(){return progress_icon_elem=$(this).find("i.progress-icon"),default_icon=progress_icon_elem.attr("data-icon"),hide_back=!1,1==progress_icon_elem.hasClass("hidde")&&(hide_back=!0),1==$(this).find("i.fa-spinner").length?(progress_icon_elem.removeClass("fa-spinner").removeClass("fa-spin").addClass("fa-"+default_icon),1==hide_back&&progress_icon_elem.hide()):progress_icon_elem.removeClass("fa-"+default_icon).addClass("fa-spinner fa-spin").show(),!0})}function Wo_StartBar(){$(".loader").css("display","block")}function Wo_FinishBar(){$(".loader").css("display","none")}$(document).ready(function(){$(".nav-footer-toggle").on("click",function(e){e.preventDefault(),$(this).parent().toggleClass("Wide-Footer"),$(".nav-footer-toggle i").toggleClass("fa-arrow-circle-up fa-arrow-circle-down")})});
/*done*/
function Wo_CheckForCallAnswer(id) {
    $.get(window.ajax + 'chat/check_for_answer?id='+id , function (data1) {
        if (data1.status == 200) {
            //console.log('Wo_CheckForCallAnswer : 200');
            clearTimeout(checkcalls);
            $('#calling-modal').find('.modal-title').html('<i class="fa fa fa-video-camera"></i> ' + data1.text_answered);
            $('#calling-modal').find('.modal-body p').text(data1.text_please_wait);
            setTimeout(function () {
                window.location.href = data1.url;
            }, 1000);
            return false;
        } else if (data1.status == 400) {
            //console.log('Wo_CheckForCallAnswer : 400');
            clearTimeout(checkcalls);
            Wo_PlayAudioCall('stop');
            $('#calling-modal').find('.modal-title').html('<i class="fa fa fa-times"></i> ' + data1.text_call_declined);
            $('#calling-modal').find('.modal-body p').text(data1.text_call_declined_desc);
        }
        checkcalls = setTimeout(function () {
            Wo_CheckForCallAnswer(id);
        }, 2000);
    });
}
/*done*/
function Wo_CheckForAudioCallAnswer(id) {
    $.get(window.ajax + 'chat/check_for_audio_answer?id='+id, function (data1) {
        if (data1.status == 200) {
            //console.log('Wo_CheckForAudioCallAnswer : 200');
            clearTimeout(checkcalls);
            $('#calling-modal').find('.modal-title').html('<i class="fa fa fa-phone"></i> ' + data1.text_answered);
            $('#calling-modal').find('.modal-body p').text(data1.text_please_wait);
            Wo_PlayAudioCall('stop');
            setTimeout(function () {
                $( '#calling-modal' ).remove();
                $( '.modal-overlay' ).remove();
                $( 'body' ).removeClass( "modal-open" );
                $('body').append(data1.calls_html);
                $('#re-talking-modal').modal({dismissible: false});
                $('#re-talking-modal').modal('open');
            }, 3000);
        } else if (data1.status == 400) {
            //console.log('Wo_CheckForAudioCallAnswer : 400');
            clearTimeout(checkcalls);
            Wo_PlayAudioCall('stop');
            $('#calling-modal').find('.modal-title').html('<i class="fa fa fa-times"></i> ' + data1.text_call_declined);
            $('#calling-modal').find('.modal-body p').text(data1.text_call_declined_desc);
        } else {
            checkcalls = setTimeout(function () {
                Wo_CheckForAudioCallAnswer(id);
            }, 2000);
        }
    });
}
/*done*/
function Wo_AnswerCall(id, url, type) {
    type1 = 'video';
    if (type == 'video') {
        type1 = 'video';
    } else if (type == 'audio') {
        type1 = 'audio';
    }
    Wo_progressIconLoader($('#re-calling-modal').find('.answer-call'));
    $.get(window.ajax + 'chat/answer_call?id='+id+'&type='+type1, function (data) {
        Wo_PlayVideoCall('stop');
        if (type1 == 'video') {
            if (data.status == 200) {
                //console.log('Wo_AnswerCall video');
                window.location.href = url;
            }
        } else {
            //console.log('Wo_AnswerCall audio');
            $('#re-calling-modal').remove();
            $('.modal-overlay').remove();
            $('body').removeClass( "modal-open" );
            $('body').append(data.calls_html);
            $('#re-talking-modal').modal({dismissible: false});
            $('#re-talking-modal').modal('open');
        }
        Wo_progressIconLoader($('#re-calling-modal').find('.answer-call'));
    });
}
/*done*/
function Wo_DeclineCall(id, url, type) {
    type1 = 'video';
    if (type == 'video') {
        type1 = 'video';
    } else if (type == 'audio') {
        type1 = 'audio';
    }
    Wo_progressIconLoader($('#re-calling-modal').find('.decline-call'));
    $.get(window.ajax + 'chat/decline_call?id='+id+'&type='+type1, function (data) {
        if (data.status == 200) {
            //console.log('Wo_DeclineCall : 200');
            Wo_PlayVideoCall('stop');
            $( '#re-calling-modal' ).remove();
            $( '.modal-overlay' ).remove();
            $( 'body' ).removeClass( "modal-open" );
            document.title = document_title;
        }
    });
}
/*done*/
function Wo_CloseCall(id) {
    Wo_progressIconLoader($('#re-talking-modal').find('.decline-call'));
    $.get(window.ajax + 'chat/close_call?id='+id, function (data) {
        if (data.status == 200) {
            //console.log('Wo_CloseCall : 200');
            $( '#re-talking-modal' ).remove();
            $( '.modal-overlay' ).remove();
            $( 'body' ).removeClass( "modal-open");
        }
    });
}
/*done*/
function Wo_CancelCall() {
    Wo_progressIconLoader($('#calling-modal').find('.cancel-call'));
    $.get(window.ajax + 'chat/cancel_call', function (data) {
        if (data.status == 200) {
            //console.log('Wo_CancelCall : 200');
            Wo_PlayAudioCall('stop');
            $( '#calling-modal' ).remove();
            $( '.modal-overlay' ).remove();
            $( 'body' ).removeClass( "modal-open" );
        }
    });
}
/*done*/
function Wo_GenerateVideoCall(user_id1) {
    let user_id2 = $('#vxd').val();
    $.get( window.ajax + 'chat/create_new_video_call?new=true&user_id1='+user_id1+'&user_id2='+user_id2, function(data, status){
        if( data.status == 200 ){
            //console.log('Wo_GenerateVideoCall : 200');
            $('body').append(data.html);
            $('#calling-modal').modal({dismissible: false});
            $('#calling-modal').modal('open');
            $('#message_box').modal('close');
            checkcalls = setTimeout(function () {
                Wo_CheckForCallAnswer(data.id);
            }, 2000);
            setTimeout(function() {
                $('#calling-modal').find('.modal-title').html('<i class="fa fa fa-video-camera"></i> ' + data.text_no_answer);
                $('#calling-modal').find('.modal-body p').text(data.text_please_try_again_later);
                clearTimeout(checkcalls);
                Wo_PlayAudioCall('stop');
            }, 43000);
            Wo_PlayAudioCall('play');
        }
    });

}
/*done*/
function Wo_GenerateVoiceCall(user_id1) {
    let user_id2 = $('#vxd').val();
    $.get( window.ajax + 'chat/create_new_audio_call?new=true&user_id1='+user_id1+'&user_id2='+user_id2, function(data) {
        if (data.status == 200) {
            //console.log('Wo_GenerateVoiceCall : 200');
            $('body').append(data.html);
            $('#calling-modal').modal({dismissible: false});
            $('#calling-modal').modal('open');
            $('#message_box').modal('close');
            checkcalls = setTimeout(function () {
                Wo_CheckForAudioCallAnswer(data.id);
            }, 2000);
            setTimeout(function() {
                $('#calling-modal').find('.modal-title').html('<i class="fa fa fa-phone"></i> ' + data.text_no_answer);
                $('#calling-modal').find('.modal-body p').text(data.text_please_try_again_later);
                clearTimeout(checkcalls);
                Wo_PlayAudioCall('stop');
            }, 43000);
            Wo_PlayAudioCall('play');
        }
    });
}
/*done*/
function Wo_PlayAudioCall(type) {
    var content = document.getElementById('calling-sound');
    if (!content){
        return;
    }

    if (type == 'play') {
        var promise = document.getElementById('calling-sound').play();
        if (promise !== undefined) {
            promise.then(function(){
                // Autoplay started!
            }).catch(function() {
                // Autoplay was prevented.
            });
        }
        playmusic_ = setTimeout(function() {
            Wo_PlayAudioCall('play');
        }, 100);
    } else {
        clearTimeout(playmusic_);
        document.getElementById('calling-sound').pause();
    }
}
/*done*/
function Wo_PlayVideoCall(type) {
    var content = document.getElementById('video-calling-sound');
    if (!content){
        return;
    }
    if (type == 'play') {
        var promise = document.getElementById('video-calling-sound').play();
        if (promise !== undefined) {
            promise.then(function() {
                // Autoplay started!
            }).catch(function() {
                // Autoplay was prevented.
            });
        }
        playmusic = setTimeout(function() {
            Wo_PlayVideoCall('play');
        }, 100);
    } else {
        clearTimeout(playmusic);
        document.getElementById('video-calling-sound').pause();
    }
}

function SendMessages() {
    if(window.email_notification == '0'){
        return;
    }
    $.get(window.ajax + 'useractions/send_mails', {});
}

function loadScript(src, callback){
	var s,
		r,
		t;
	r = false;
	s = document.createElement('script');
	s.type = 'text/javascript';
	s.src = src;
	s.onload = s.onreadystatechange = function() {
	if ( !r && (!this.readyState || this.readyState == 'complete') )
	{
		r = true;
		callback();
	}
	};
	t = document.getElementsByTagName('script')[0];
	t.parentNode.insertBefore(s, t);
}

function logout(){
	document.cookie = 'JWT=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/';
	window.location = window.site_url;
}

function verify_email_code( thisx ){
    var vl = $(thisx);
    $.get( window.ajax + 'useractions/get_email_verification_code', function(data, status){
        if( data.status == 200 ){
            if( vl.val() == data.code ){
                var data = {
                    'verified': '1',
                    'active': '1',
                    'start_up': '3'
                };

                $.get( window.ajax + 'profile/set_data', data );

                setTimeout(function(){
                    window.location = window.site_url;
                }, 1000);

            }else{
                M.toast({html: "Wrong verification email code, try again later."});
                vl.focus();
            }
        }else{
            M.toast({html: "Wrong verification email code, try again later."});
        }
    });
}

function verify_sms_code( thisx ){
    var vl = $(thisx);
    $.get( window.ajax + 'useractions/get_sms_verification_code', function(data, status){
        if( data.status == 200 ){
            if( vl.val() == data.code ){

                var data = {
                    'verified': 1,
                    'active': 1,
                    'phone_verified': 1,
                    'start_up': 3
                };

                $.get( window.ajax + 'profile/set_data', data );

                setTimeout(function(){
                    window.location = window.site_url;
                }, 1000);

            }else{
                M.toast({html: "Wrong verification sms code, try again later."});
                vl.val('');
                vl.focus();
            }
        }else{
            M.toast({html: "Wronge verification sms code, try again later."});
        }
    });
}

function callback_open_gift_model( data ){
    if( data.status == 200 ){
        $('#modal_gifts').modal({
            onOpenEnd: function(){
                $('#gifts_container').html(data.gifts);
            },
            onCloseEnd: function(){

            }
        }).modal("open");
    }else{
        M.toast({html: data.message});
    }
}

function callback_like( data ){
    if (typeof data.maxswaps !== "undefined"){
        $('#max_swap_modal').modal();
        $('#max_swap_modal #max_swap_modal_container').html(data.hours);
        $('#max_swap_modal').modal('open');
        return;
    }

	if( data.status == 200 ) {

        $( '#like_btn' ).addClass( 'lk_active' );

        $('.dislike_text').html(data.dislike_text);
        $('#like_btn').attr('data-ajax-post', '/useractions/remove_like');
        $('#like_btn').attr('data-ajax-callback', 'callback_remove_like');
        $('#dislike_btn').attr('data-ajax-post', '/useractions/dislike');
        $('#dislike_btn').attr('data-ajax-callback', 'callback_dislike');
        $('.like_text').html(data.like_text);
        $('#like_btn').attr('data-replace-text', data.liked_text);
        $('.like_text' + data.userid).html(data.like_text);
        $('.like_text' + data.userid).parent().attr('disabled', true);
        if ($('.random_user_item').length == 0) {
            $('#btn_load_more_random_users').trigger('click');
        }
	}else{
		M.toast({html: data.message});
	}
}

function callback_like_interest( data ){
    if (typeof data.maxswaps !== "undefined"){
        $('#max_swap_modal').modal();
        $('#max_swap_modal #max_swap_modal_container').html(data.hours);
        $('#max_swap_modal').modal('open');
        return;
    }

    if( data.status == 200 ){
        $( '.dislike_text' ).html( data.dislike_text );
        $( '#like_btn'+ data.userid  ).attr( 'data-ajax-post','/useractions/remove_like');
        $( '#like_btn'+ data.userid  ).attr( 'data-ajax-callback','callback_remove_like_interest');
        $( '.like_text'+ data.userid ).html( data.like_text );
    }else{
        M.toast({html: data.message});
    }
}

function callback_msg_request( data ){
    if( data.status == 200 ){
        $('#m_conversation').html(data.conversations);
        $('#m_conversation_search').html('');
        $('.chat_count').hide().addClass('hide');

        if (window._get_conversationListInterval) {
            window._get_conversationListInterval.stop();
        }
        if (window._get_chatConversationsInterval) {
            window._get_chatConversationsInterval.stop();
        }

        let r = 0;
        let accepted = $('.msg_requests').attr('data-accepted');

        if(accepted !== 'requests'){
            $('.msg_requests').html($('.msg_requests').attr('data-text-msg-request'));
            $('.msg_requests').attr('data-accepted','requests');
            r = 1;
            $('#requests_count').show();
        }else{
            $('.msg_requests').html($('.msg_requests').attr('data-text-all-conversation'));
            $('.msg_requests').attr('data-accepted','all');
            $('#requests_count').hide().html('');
        }
        _get_conversation_list(r);
        if (window._get_chatConversationsInterval) {
            window._get_chatConversationsInterval.stop();
        }
        window._get_conversationListInterval = new Interval(function () {
            _get_conversation_list(r);
        }, window.worker_updateDelay);
        window._get_conversationListInterval.start();

    }
}

function callback_remove_like_interest( data ){
    if( data.status == 200 ){
        $( '#like_btn'+ data.userid ).attr( 'data-ajax-post','/useractions/like');
        $( '#like_btn'+ data.userid ).attr( 'data-ajax-callback','callback_like_interest');
        $( '.like_text'+ data.userid ).html( data.like_text );
    }else{
        M.toast({html: data.message});
    }
}

function callback_like_matches( data ){
    if( data.status == 200 ){
        $( '.dislike_text' ).html( data.dislike_text );
        $( '#like_btn'+ data.userid  ).attr( 'data-ajax-post','/useractions/remove_like');
        $( '#like_btn'+ data.userid  ).attr( 'data-ajax-callback','callback_remove_like_matches');
        $( '.like_text'+ data.userid ).html( data.like_text );
    }else{
        M.toast({html: data.message});
    }
}

function callback_unmatches( data ){
    if( data.status == 200 ){
        $('.match-page[data-matches-page-uid="'+data.userid+'"]').remove();
        if( $('.match-page[data-matches-page-uid]').length === 0 ){
            $('#matches_container').html('<h5 class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9,4A4,4 0 0,1 13,8A4,4 0 0,1 9,12A4,4 0 0,1 5,8A4,4 0 0,1 9,4M9,6A2,2 0 0,0 7,8A2,2 0 0,0 9,10A2,2 0 0,0 11,8A2,2 0 0,0 9,6M9,13C11.67,13 17,14.34 17,17V20H1V17C1,14.34 6.33,13 9,13M9,14.9C6.03,14.9 2.9,16.36 2.9,17V18.1H15.1V17C15.1,16.36 11.97,14.9 9,14.9M15,4A4,4 0 0,1 19,8A4,4 0 0,1 15,12C14.53,12 14.08,11.92 13.67,11.77C14.5,10.74 15,9.43 15,8C15,6.57 14.5,5.26 13.67,4.23C14.08,4.08 14.53,4 15,4M23,17V20H19V16.5C19,15.25 18.24,14.1 16.97,13.18C19.68,13.62 23,14.9 23,17Z"></path></svg>'+$('#matches_container').attr('data-nomore')+'</h5>');
            $('#btn_load_more_matches').remove();
        }
    }else{
        M.toast({html: data.message});
    }
}

function callback_remove_like_matches( data ){
    if( data.status == 200 ){
        $( '#like_btn'+ data.userid ).attr( 'data-ajax-post','/useractions/like');
        $( '#like_btn'+ data.userid ).attr( 'data-ajax-callback','callback_like_matches');
        $( '.like_text'+ data.userid ).html( data.like_text );
        window.location.reload();
    }else{
        M.toast({html: data.message});
    }
}

function callback_remove_like( data ){
    if( data.status == 200 ){
        $( '#like_btn' ).removeClass( 'lk_active' );
        $( '#like_btn' ).attr( 'data-ajax-post','/useractions/like');
        $( '#like_btn' ).attr( 'data-ajax-callback','callback_like');
        $( '.like_text' ).html( data.like_text );
    }else{
        M.toast({html: data.message});
    }
}

function callback_liked_remove_like( data ){
    if( data.status == 200 ){
        $('[data-liked-uid="'+data.userid+'"]').remove();
    }else{
        M.toast({html: data.message});
    }
}

function callback_dislike( data ){

    if (typeof data.maxswaps !== "undefined"){
        if( typeof data.source !== "undefined"){
            if(data.source == 1){
                return;
            }
        }

        // $('#max_swap_modal').modal();
        // $('#max_swap_modal #max_swap_modal_container').html(data.hours);
        // $('#max_swap_modal').modal('open');
        return;
    }

	if( data.status == 200 ){
        $( '#dislike_btn' ).addClass( 'dk_active' );
        //window.swaps = window.swaps + 1;
        // if (typeof data.maxswaps !== "undefined"){
        //     $('#section_match_users').remove();
        //     $('#max_swipes_reached').removeClass('hide');
        //     $('#w_message').html(data.hours);
        //     return false;
        // }
		$( '.like_text' ).html( data.like_text );
        $( '#dislike_btn' ).attr( 'data-ajax-post','/useractions/remove_dislike');
        $( '#dislike_btn' ).attr( 'data-ajax-callback','callback_remove_dislike');
        $( '#like_btn' ).attr( 'data-ajax-post','/useractions/like');
        $( '#like_btn' ).attr( 'data-ajax-callback','callback_like');
        $( '#dislike_btn' ).attr( 'data-replace-text', data.disliked_text );
		$( '.dislike_text' ).html( data.dislike_text );
        $( '._dislike_text' + data.userid ).attr('disabled',true);
        if($( '.random_user_item').length == 0 ){
            $('#btn_load_more_random_users').trigger('click');
        }
	}else{
		M.toast({html: data.message});
	}
}

function callback_remove_dislike( data ){
    if( data.status == 200 ){
        $( '#dislike_btn' ).removeClass( 'dk_active' );
        $( '#dislike_btn' ).attr( 'data-ajax-post','/useractions/dislike');
        $( '#dislike_btn' ).attr( 'data-ajax-callback','callback_dislike');
        $( '.dislike_text' ).html( data.dislike_text );
    }else{
        M.toast({html: data.message});
    }
}

function callback_disliked_remove_dislike( data ){
    if( data.status == 200 ){
        $('[data-disliked-uid="'+data.userid+'"]').remove();
    }else{
        M.toast({html: data.message});
    }
}

function callback_block( data ){
	if( data.status == 200 ){
		$( '.block_text' ).attr( 'data-ajax-post', '/useractions/unblock' );
		$( '.block_text' ).attr( 'data-ajax-callback', 'callback_unblock' );
        setTimeout(function() {
            $("#ajaxRedirect").attr("data-ajax", '/find-matches');
            $("#ajaxRedirect").click();
        }, 2500);
	}else{
		
	}
}

function callback_unblock( data ){
	if( data.status == 200 ){
		$( '.block_text' ).attr( 'data-ajax-post', '/useractions/block' );
		$( '.block_text' ).attr( 'data-ajax-callback', 'callback_block' );
	}else{
		
	}
}

function callback_unblock_hide( data ){
	if( data.status == 200 ){
		$( '#blocked_user_'+data.id ).fadeOut( "slow" );
		M.toast({html: data.message});
	}else{
		M.toast({html: data.message});
	}
}

function callback_report( data ){
	if( data.status == 200 ){
		$( '.report_text' ).attr( 'data-ajax-post', '/useractions/unreport' );
		$( '.report_text' ).attr( 'data-ajax-callback', 'callback_unreport' );
		$( '.report_text' ).html( data.report_text );
		M.toast({html: data.message});
	}else{
		M.toast({html: data.message});
	}
}

function callback_unreport( data ){
	if( data.status == 200 ){
        $( '.report_text' ).removeAttr( 'data-ajax-post' );
        $( '.report_text' ).removeAttr( 'data-ajax-callback' );
        $( '.report_text' ).removeAttr( 'data-ajax-params' );
		$( '.report_text' ).html( '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#444" d="M13,14H11V10H13M13,18H11V16H13M1,21H23L12,2L1,21Z"></path></svg>' );
        $( '.report_text' ).addClass('modal-trigger');
        $( '.report_text' ).attr('href','#modal_report');
		M.toast({html: data.message});
	}else{
		M.toast({html: data.message});
	}
}

function callback_show_notifications( data ) {
    $( '.dt_notifs' ).remove();
    if (data.status == 200) {
    	$( '.notification_badge' ).addClass('hide');
        $( '.dt_notifis_prnt' ).empty().html(data.notifications);
        $( '#notificationbtn' ).attr( 'data-ajax-params','seen=true');
    }
}

function callback_load_more_random_users( data ) {
    if( data.status == 200 ) {
        let button = $('#btn_load_more_random_users');
        let container = $('#random_users_container');
        let template = $('#random-user-item');
        init_load_more(data,button,container,template);
        if( $('.random_user_item').length == 0 ){
            $('#dt_ltst_users').remove();
        }
    }else{
        M.toast({html: data.message});
    }
}

function callback_load_more_gifts_users( data ) {
    if( data.status == 200 ) {
        let button = $('#btn_load_more_gifts_users');
        let container = $('#likes_users_container');
        let template = $('#random-user-item');
        init_load_more(data,button,container,template);
        // if( $('.random_user_item').length == 0 ){
        //     $('#dt_ltst_users').remove();
        // }
    }else{
        M.toast({html: data.message});
    }
}

function callback_load_more_success_stories( data ) {
    if( data.status == 200 ) {
        let button = $('#btn_load_more_success_stories');
        let container = $('#success_stories_container');
        let template = $('#success_story_item');
        init_load_more(data,button,container,template);
        if( $('.success_story_item').length == 0 ){
            $('#dt_ltst_users').remove();
        }
    }else{
        M.toast({html: data.message});
    }
}

function callback_load_more_articles( data ) {
    if( data.status == 200 ) {
        let button = $('#btn_load_more_articles');
        let container = $('#articles_container');
        let template = $('#success_story_item');
        init_load_more(data,button,container,template);
        if( $('.success_story_item').length == 0 ){
            $('#dt_ltst_users').remove();
        }
    }else{
        M.toast({html: data.message});
    }
}

function callback_load_more_likes_users( data ) {
    if( data.status == 200 ) {
        let button = $('#btn_load_more_likes_users');
        let container = $('#likes_users_container');
        let template = $('#likes-user-item');
        init_load_more(data,button,container,template);
    }else{
        M.toast({html: data.message});
    }
}

function callback_load_more_liked_users( data ) {
    if( data.status == 200 ) {
        let button = $('#btn_load_more_liked_users');
        let container = $('#liked_users_container');
        let template = $('#liked-user-item');
        init_load_more(data,button,container,template);
    }else{
        M.toast({html: data.message});
    }
}

function callback_load_more_disliked_users( data ) {
    if( data.status == 200 ) {
        let button = $('#btn_load_more_blocked_users');
        let container = $('#blocked_users_container');
        let template = $('#disliked-user-item');
        init_load_more(data,button,container,template);
    }else{
        M.toast({html: data.message});
    }
}

function callback_load_more_blocked_users( data ) {
    if( data.status == 200 ) {
        let button = $('#btn_load_more_disliked_users');
        let container = $('#disliked_users_container');
        let template = $('#disliked-user-item');
        init_load_more(data,button,container,template);
    }else{
        M.toast({html: data.message});
    }
}

function callback_load_more_visits( data ) {
    if( data.status == 200 ) {
        let button = $('#btn_load_more_visits');
        let container = $('#visits_container');
        let template = $('#visits-item');
        init_load_more(data,button,container,template);
    }else{
        M.toast({html: data.message});
    }
}

function callback_load_more_interest( data ) {
    if( data.status == 200 ) {
        let button = $('#btn_load_more_interest');
        let container = $('#interest_container');
        let template = $('#interest-item');
        init_load_more(data,button,container,template);
    }else{
        M.toast({html: data.message});
    }
}

function callback_load_more_matches( data ) {
    if( data.status == 200 ) {
        let button = $('#btn_load_more_matches');
        let container = $('#matches_container');
        let template = $('#matches-item');
        init_load_more(data,button,container,template);
    }else{
        M.toast({html: data.message});
    }
}

function callback_load_more_search_users( result ) {
    window.ajaxsend = true;
    var btn_text = $('#btn_load_more_search_users').html();
    $('#btn_load_more_search_users').removeAttr('data-ajax-params');
    $('#btn_load_more_search_users').css( {'display':'block'} ).show();
    $('#_load_more').remove();
    if (result.status == 200) {
        $('#dt_ltst_users').remove();
        $('.dt_home_match_user').remove();
        $('#latest_user').removeClass('hide');
        $('#home_filters_close').trigger('click');
        let button = $('#btn_load_more_search_users');
        let container = $('#search_users_container');
        let dtemplateHtml = '';
        let listHtml = '';

        button.removeClass('hide');
        let params = button.attr('data-ajax-params' );
        let search = result.page ;
        let replacement = "_where=" + encodeURI(result.post) +"&page=" + search;
        button.attr('data-ajax-params', replacement);
        if (result.html.length == 0) {
            if(container.html() == '' ){
                $('#search_users_container').html('<h5 class="empty_state">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">' +
                    '        <path fill="currentColor" d="M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21M19.75,3.19L18.33,4.61C20.04,6.3 21,8.6 21,11H23C23,8.07 21.84,5.25 19.75,3.19M1,11H3C3,8.6 3.96,6.3 5.67,4.61L4.25,3.19C2.16,5.25 1,8.07 1,11Z" /></svg> ' +
                    button.attr('data-lang-nomore') +
                    '</h5>');
                button.hide();
            }else{
                button.html(button.attr('data-lang-nomore'));
            }
        } else {
            button.html(button.attr('data-lang-more'));
            container.append(result.html);
        }
    } else{
        if(typeof data.message !== undefined) {
            M.toast({html: data.message});
        }
    }
}

function callback_load_more_match_users( data ) {
    let avaters_container = $('#avaters_item_container');
    let container = $('#match_item_container');
    let button = $('#btn_load_more_match_users');
        button.attr('data-ajax-params', 'page=' + data.page);
    if( data.status == 200 ) {
        if( data.html !== '' ){
            $('#btn_load_more_match_users1').attr('id', 'btn_load_more_match_users');
            avaters_container.append(data.html_imgs);

            // var found = {};
            // $('[data-id]').each(function(){
            //     var $this = $(this);
            //     if(found[$this.data('id')]){
            //         $this.remove();
            //         console.log('doplicate found');
            //     }
            //     else{
            //         found[$this.data('id')] = true;
            //     }
            // });

            container.append(data.html);
            var matched = $(".usr_thumb");
            if( matched.length === 0 ) {
                //console.log('defsddf');
            }
            $('.mtc_usrd_content').hide();
            $('.mtc_usrd_content:first').show();
            $('.usr_thumb:first').addClass('isActive');
            $('.usr_thumb').hide();
            $('.usr_thumb:lt(8)').show();

        }else{
            button.attr( 'data-ajax-post',null);
            button.attr( 'data-ajax-params',null);
            button.attr( 'data-ajax-callback',null);
            button.attr( 'disabled',true);
            button.css( {'text-transform':'initial'} );
            button.html( button.attr( 'data-lang-nomore') );
        }
    }
    return true;


    // if( data.status == 200 ) {
    //     $('.mtc_usr_details').removeClass('hide');
    //     let button = $('#btn_load_more_match_users');
    //     let avaters_container = $('#avaters_item_container');
    //     let avaters_item_templates = $('#match-users-avaters-item');
    //     let avaters_itemtemplateHtml = avaters_item_templates.html().trim();
    //     let avaters_itemdtemplateHtml = '';
    //     let avaters_itemlistHtml = '';
    //
    //     let container = $('#match_item_container');
    //     let template = $('#match-users-item');
    //     let templateHtml = template.html().trim();
    //     let dtemplateHtml = '';
    //     let listHtml = '';
    //     button.attr('data-ajax-params', 'page=' + data.page);
    //     if (data.list.length == 0) {
    //         button.attr( 'data-ajax-post',null);
    //         button.attr( 'data-ajax-params',null);
    //         button.attr( 'data-ajax-callback',null);
    //         button.attr( 'disabled',true);
    //         button.css( {'text-transform':'initial'} );
    //         button.html( button.attr( 'data-lang-nomore') );
    //     } else {
    //         let first = true;
    //         for (let key in data.list) {
    //             if (data.list.hasOwnProperty(key)) {
    //                 if( first ){
    //                     data.list[key].first = true;
    //                     first = false;
    //                 }else{
    //                     data.list[key].first = false;
    //                 }
    //                 avaters_itemdtemplateHtml = avaters_itemtemplateHtml.interpolate(data.list[key]);
    //                 dtemplateHtml = templateHtml.interpolate(data.list[key]);
    //                 avaters_itemlistHtml += avaters_itemdtemplateHtml;
    //                 listHtml += dtemplateHtml;
    //             }
    //         }
    //         avaters_container.append(avaters_itemlistHtml);
    //         container.append(listHtml);
    //         var matched = $(".usr_thumb");
    //         if( matched.length === 0 ) {
    //             //console.log('defsddf');
    //         }
    //         $('.mtc_usrd_content').hide();
    //         $('.mtc_usrd_content:first').show();
    //         $('.usr_thumb:first').addClass('isActive');
    //         $('.usr_thumb').hide();
    //         $('.usr_thumb:lt(8)').show();
    //     }
    //     if( $('.mtc_usrd_content').length === 0 ){ $('#section_match_users').hide(); }else{ $('#section_match_users').show(); }
    //
    // }else{
    //     M.toast({html: data.message});
    // }
}

function getCookies(name) {
    cookies = document.cookie;
    r = cookies.split(';').reduce(function(acc, item){
        let c = item.split('='); //'nome=Marcelo' transform in Array[0] = 'nome', Array[1] = 'Marcelo'
        c[0] = c[0].replace(' ', ''); //remove white space from key cookie
        acc[c[0]] = c[1]; //acc == accumulator, he accomulates all data, on ends, return to r variable
        return acc; //here do not return to r variable, here return to accumulator
    },[]);
}

function callback_hot( data ){
    window.ajaxsend = true;
    if( data.status == 200 ) {
        $( '#like_btn' ).addClass( 'lk_active' );
        $('.dislike_text').html(data.dislike_text);
        $('#like_btn').attr('data-ajax-post', '/useractions/remove_like');
        $('#like_btn').attr('data-ajax-callback', 'callback_remove_like');
        $('#dislike_btn').attr('data-ajax-post', '/useractions/dislike');
        $('#dislike_btn').attr('data-ajax-callback', 'callback_dislike');
        $('.like_text').html(data.like_text);
        $('#like_btn').attr('data-replace-text', data.liked_text);
        $('.like_text' + data.userid).html(data.like_text);
        $('.like_text' + data.userid).parent().attr('disabled', true);
        // if ($('.random_user_item').length == 0) {
        //     $('#btn_load_more_random_users').trigger('click');
        // }
        // if($('#avaters_item_container .usr_thumb').length < 2 ){
        //     $("#btnHotRedirect").click();
        // }
    }else{
        M.toast({html: data.message});
    }
}

function callback_not( data ){
    if( data.status == 200 ) {
        $( '#like_btn' ).addClass( 'lk_active' );
        $('.dislike_text').html(data.dislike_text);
        $('#like_btn').attr('data-ajax-post', '/useractions/remove_like');
        $('#like_btn').attr('data-ajax-callback', 'callback_remove_like');
        $('#dislike_btn').attr('data-ajax-post', '/useractions/dislike');
        $('#dislike_btn').attr('data-ajax-callback', 'callback_dislike');
        $('.like_text').html(data.like_text);
        $('#like_btn').attr('data-replace-text', data.liked_text);
        $('.like_text' + data.userid).html(data.like_text);
        $('.like_text' + data.userid).parent().attr('disabled', true);
        // if ($('.random_user_item').length == 0) {
        //     $('#btn_load_more_random_users').trigger('click');
        // }
        // if($('#avaters_item_container .usr_thumb').length < 2 ){
        //     $("#btnHotRedirect").click();
        // }
    }else{
        M.toast({html: data.message});
    }
}

function _startTimer(duration, display) {
    var start = Date.now(),
        diff,
        minutes,
        seconds;
    function timer() {
        diff = duration - (((Date.now() - start) / 1000) | 0);
        minutes = (diff / 60) | 0;
        seconds = (diff % 60) | 0;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;
        display.html(minutes + ":" + seconds);
        if (diff <= 0) {
            start = Date.now() + 1000;
            display.parent().html(display.parent().attr('data-message-expire'));
        }
    };
    timer();
    window.tm = setInterval(timer, 1000);
}

function remove_conversationlist_active(){
    $('.m_con_item').removeClass('active');
}

function callback_add_friend(data){
    $("#ajaxRedirect").attr("data-ajax", data.ajaxRedirect);
    $("#ajaxRedirect").click();
}