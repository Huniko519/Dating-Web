<?php
Class Shared extends Aj {
    public function contact() {
        global $site_url;
        $error      = '';
        $msg        = '';
        $first_name = '';
        $last_name  = '';
        $message    = '';
        $email      = '';
        $send       = false;
        if (isset($_POST) && !empty($_POST)) {
            if (isset($_POST[ 'email' ]) && empty($_POST[ 'email' ])) {
                $error .= '<p>• ' . __('Missing E-mail') . '.</p>';
            }
            if (!filter_var($_POST[ 'email' ], FILTER_VALIDATE_EMAIL)) {
                $error .= '<p>• ' . __('This E-mail is invalid') . '.</p>';
            }
            if (isset($_POST[ 'message' ]) && empty($_POST[ 'message' ])) {
                $error .= '<p>• ' . __('Missing message') . '.</p>';
            }
            if (isset($_POST[ 'email' ]) && !empty($_POST[ 'email' ])) {
                $email = ucfirst(Secure($_POST[ 'email' ]));
            }
            if (isset($_POST[ 'first_name' ]) && !empty($_POST[ 'first_name' ])) {
                $first_name = ucfirst(Secure($_POST[ 'first_name' ]));
            }
            if (isset($_POST[ 'last_name' ]) && !empty($_POST[ 'last_name' ])) {
                $last_name = ucfirst(Secure($_POST[ 'last_name' ]));
            }
            if (isset($_POST[ 'message' ]) && !empty($_POST[ 'message' ])) {
                $message = ucfirst(Secure($_POST[ 'message' ]));
            }
            if ($error == '') {
                $body = $first_name . ' ' . $last_name . '<br>';
                $body .= Secure($_POST[ 'email' ]) . '<hr>';
                $body .= $message;
                try {
                    $send = SendEmail(self::config()->siteEmail, self::Config()->site_name . ' ' . __('Thank you for contacting us'), $body);
                }
                catch (Exception $e) {
                    return array(
                        'status' => 400,
                        'message' => $e->getMessage()
                    );
                }
                if ($send) {
                    $msg .= '<p>• ' . __('message sent successfully') . '.</p>';
                    return array(
                        'status' => 200,
                        'message' => $msg,
                        //'ajaxRedirect' => '/'
                        'url' => $site_url
                    );
                } else {
                    $error .= '<p>• ' . __('can not send message') . '.</p>';
                }
            }
            if ($error !== '') {
                return array(
                    'status' => 400,
                    'message' => $error
                );
            }
        }
    }
}