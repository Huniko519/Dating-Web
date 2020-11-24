<!-- onesignal -->
    <link rel="manifest" href="<?php echo $theme_url;?>assets/js/OneSignalSDKFiles/manifest.json">
    <script src="<?php echo $config->uri; ?>/OneSignalSDKWorker.js" async='async'></script>
    <script>
        var push_user_id = '';
        var my_id = '<?php echo auth()->web_device_id;?>';
        var OneSignal = window.OneSignal || [];
            OneSignal.push(["init", {
                appId: "<?php echo $config->push_id;?>",
                allowLocalhostAsSecureOrigin: true,
                autoRegister: true, /* Set to true to automatically prompt visitors */
                notifyButton: {
                    enable: true /* Set to false to hide */
                },
                persistNotification: false,
            }]);
            OneSignal.push(function () {
                OneSignal.getUserId(function(userId) {
                    push_user_id = userId;
                    if (userId != my_id) {
                        $.get( window.ajax + 'onesignal/update_user_device_id', { id:push_user_id } );
                    }
                });
                OneSignal.on('subscriptionChange', function (isSubscribed) {
                    if (isSubscribed == false) {
                        $.get( window.ajax + 'onesignal/remove_user_device_id', {} );
                    } else {
                        $.get( window.ajax + 'onesignal/update_user_device_id', { id:push_user_id } );
                    }
                });

                OneSignal.on('notificationDisplay', function (event) {
                    console.warn('OneSignal notification displayed:', event);
                /*
                {
                    "id": "ce31de29-e1b0-4961-99ee-080644677cd7",
                    "heading": "OneSignal Test Message",
                    "content": "This is an example notification.",
                    "url": "https://onesignal.com?_osp=do_not_open",
                    "icon": "https://onesignal.com/images/notification_logo.png"
                }
                */
                });

                //
                // OneSignal.sendSelfNotification(
                //     /* Title (defaults if unset) */
                //     "OneSignal Web Push Notification",
                //     /* Message (defaults if unset) */
                //     "Action buttons increase the ways your users can interact with your notification.",
                //     /* URL (defaults if unset) */
                //     'https://example.com/?_osp=do_not_open',
                //     /* Icon */
                //     'https://onesignal.com/images/notification_logo.png',
                //     {
                //         /* Additional data hash */
                //         notificationType: 'news-feature'
                //     },
                //     [{ /* Buttons */
                //         /* Choose any unique identifier for your button. The ID of the clicked button is passed to you so you can identify which button is clicked */
                //         id: 'like-button',
                //         /* The text the button should display. Supports emojis. */
                //         text: 'Like',
                //         /* A valid publicly reachable URL to an icon. Keep this small because it's downloaded on each notification display. */
                //         icon: 'http://i.imgur.com/N8SN8ZS.png',
                //         /* The URL to open when this action button is clicked. See the sections below for special URLs that prevent opening any window. */
                //         url: 'https://example.com/?_osp=do_not_open'
                //     },
                //     {
                //         id: 'read-more-button',
                //         text: 'Read more',
                //         icon: 'http://i.imgur.com/MIxJp1L.png',
                //         url: 'https://example.com/?_osp=do_not_open'
                //     }]
                // );


            });




    </script>
