<?php
Class Sms extends Aj{

    public function generate_lock_pro_video_link() {
        global $config;
        $amount =  intval( $config->lock_pro_video_fee ) . '00';
        $url = '';
        try {
            $self_url = $config->uri;
            $payment_url = WebToPay::getPaymentUrl();

            $request = WebToPay::buildRequest(array(
                'projectid'     => $config->paysera_project_id,
                'sign_password' => $config->paysera_password,
                'orderid'       => rand(1111,4444),
                'amount'        => $amount,
                'currency'      => $config->currency,
                'country'       => 'TR',
                'accepturl'     => $self_url.'/aj/sms/unlock_private_photo_success?mode=lock_pro_video',
                'cancelurl'     => $self_url.'/aj/sms/unlock_private_photo_cancel?mode=lock_pro_video',
                'callbackurl'   => $self_url.'/aj/sms/unlock_private_photo_callback?mode=lock_pro_video',
                'test'          => ($config->paysera_test_mode == 'test') ? 1 : 0,
            ));

            $url = $payment_url . '?data='. $request['data'] . '&sign=' . $request['sign'];
            header('location: ' . $url);
            exit();
        }
        catch (WebToPayException $e) {
            echo $e->getMessage();
        }
    }
    public function lock_pro_video_success(){
        global $config,$db;
        try {
            $response = WebToPay::checkResponse($_GET, array(
                'projectid'     => $config->paysera_project_id,
                'sign_password' => $config->paysera_password,
            ));

            if ($response['type'] !== 'macro') {
                die('Only macro payment callbacks are accepted');
            }

            $amount = 0;
            $price = intval( $response['amount'] ) / 100;
            if ((int)$price == (int)self::Config()->lock_pro_video_fee) {
                $amount = (int)self::Config()->lock_pro_video_fee;
                if ((int)$response['status'] == 1){
                    $updated    = $db->where('id', self::ActiveUser()->id)->update('users', array('lock_pro_video' => 0));
                    if ($updated) {
                        $db->insert('payments', array(
                            'user_id' => self::ActiveUser()->id,
                            'amount' => $price,
                            'type' => 'lock_pro_video',
                            'pro_plan' => '0',
                            'credit_amount' => '0',
                            'via' => 'Paysera SMS payment'
                        ));
                        $_SESSION[ 'userEdited' ] = true;
                        header('Location: ' . $config->uri . '/ProSuccess?paymode=unlock');
                        exit();
                    } else {
                        exit(__('Error While update Unlock video uploading charging'));
                    }
                }
            }
        } catch (Exception $e) {
            echo get_class($e) . ': ' . $e->getMessage();
        }
    }
    public function lock_pro_video_cancel(){
        global $config;
        header('Location: ' . $config->uri);
        exit();
    }
    public function lock_pro_video_callback(){
        $this->lock_pro_video_success();
    }


    public function generate_unlock_private_photo_link() {
        global $config;
        $amount =  intval( $config->lock_private_photo_fee ) . '00';
        $url = '';
        try {
            $self_url = $config->uri;
            $payment_url = WebToPay::getPaymentUrl();

            $request = WebToPay::buildRequest(array(
                'projectid'     => $config->paysera_project_id,
                'sign_password' => $config->paysera_password,
                'orderid'       => rand(1111,4444),
                'amount'        => $amount,
                'currency'      => $config->currency,
                'country'       => 'TR',
                'accepturl'     => $self_url.'/aj/sms/unlock_private_photo_success?mode=unlock_private_photo',
                'cancelurl'     => $self_url.'/aj/sms/unlock_private_photo_cancel?mode=unlock_private_photo',
                'callbackurl'   => $self_url.'/aj/sms/unlock_private_photo_callback?mode=unlock_private_photo',
                'test'          => ($config->paysera_test_mode == 'test') ? 1 : 0,
            ));

            $url = $payment_url . '?data='. $request['data'] . '&sign=' . $request['sign'];
            header('location: ' . $url);
            exit();
        }
        catch (WebToPayException $e) {
            echo $e->getMessage();
        }
    }
    public function unlock_private_photo_success(){
        global $config,$db;
        try {
            $response = WebToPay::checkResponse($_GET, array(
                'projectid'     => $config->paysera_project_id,
                'sign_password' => $config->paysera_password,
            ));

            if ($response['type'] !== 'macro') {
                die('Only macro payment callbacks are accepted');
            }

            $amount = 0;
            $price = intval( $response['amount'] ) / 100;
            if ((int)$price == (int)self::Config()->lock_private_photo_fee) {
                $amount = (int)self::Config()->lock_private_photo_fee;
                if ((int)$response['status'] == 1){
                    $updated    = $db->where('id', self::ActiveUser()->id)->update('users', array('lock_private_photo' => 0));
                    if ($updated) {
                        $db->insert('payments', array(
                            'user_id' => self::ActiveUser()->id,
                            'amount' => $price,
                            'type' => 'unlock_private_photo',
                            'pro_plan' => '0',
                            'credit_amount' => '0',
                            'via' => 'Paysera SMS payment'
                        ));
                        $_SESSION[ 'userEdited' ] = true;
                        header('Location: ' . $config->uri . '/ProSuccess?paymode=unlock');
                        exit();
                    } else {
                        exit(__('Error While update Unlock private photo charging'));
                    }
                }
            }
        } catch (Exception $e) {
            echo get_class($e) . ': ' . $e->getMessage();
        }
    }
    public function unlock_private_photo_cancel(){
        global $config;
        header('Location: ' . $config->uri);
        exit();
    }
    public function unlock_private_photo_callback(){
        $this->unlock_private_photo_success();
    }


    public function generate_credit_link() {
        global $config;
        $amount = 0;
        if(isset($_GET['price']) && !empty($_GET['price'])){
            $amount = intval( Secure($_GET['price']) );
        }
        $url = '';
        try {
            $self_url = $config->uri;
            $payment_url = WebToPay::getPaymentUrl();

            $request = WebToPay::buildRequest(array(
                'projectid'     => $config->paysera_project_id,
                'sign_password' => $config->paysera_password,
                'orderid'       => rand(1111,4444),
                'amount'        => $amount,
                'currency'      => $config->currency,
                'country'       => 'TR',
                'accepturl'     => $self_url.'/aj/sms/credit_success?mode=credit',
                'cancelurl'     => $self_url.'/aj/sms/credit_cancel?mode=credit',
                'callbackurl'   => $self_url.'/aj/sms/credit_callback?mode=credit',
                'test'          => ($config->paysera_test_mode == 'test') ? 1 : 0,
            ));

            $url = $payment_url . '?data='. $request['data'] . '&sign=' . $request['sign'];
            header('location: ' . $url);
            exit();
        }
        catch (WebToPayException $e) {
            echo $e->getMessage();
        }
    }
    public function credit_success(){
        global $config,$db;
        try {
            $response = WebToPay::checkResponse($_GET, array(
                'projectid'     => $config->paysera_project_id,
                'sign_password' => $config->paysera_password,
            ));

            if ($response['type'] !== 'macro') {
                die('Only macro payment callbacks are accepted');
            }

            $amount = 0;
            $price = intval( $response['amount'] ) / 100;
            if ((int)$price == (int)self::Config()->bag_of_credits_price) {
                $amount = (int)self::Config()->bag_of_credits_amount;
            } else if ((int)$price == (int)self::Config()->box_of_credits_price) {
                $amount = (int)self::Config()->box_of_credits_amount;
            } else if ((int)$price == (int)self::Config()->chest_of_credits_price) {
                $amount = (int)self::Config()->chest_of_credits_amount;
            }
            if ((int)$response['status'] == 1){
                $user = $db->objectBuilder()->where('id', self::ActiveUser()->id)->getOne('users', array('balance'));
                $newbalance = $user->balance + $amount;
                $updated    = $db->where('id', self::ActiveUser()->id)->update('users', array('balance' => $newbalance));
                if ($updated) {
                    RegisterAffRevenue(self::ActiveUser()->id,$price);
                    $db->insert('payments', array(
                        'user_id' => self::ActiveUser()->id,
                        'amount' => $price,
                        'type' => 'CREDITS',
                        'pro_plan' => '0',
                        'credit_amount' => $amount,
                        'via' => 'Paysera SMS payment'
                    ));
                    $_SESSION[ 'userEdited' ] = true;
                    header('Location: ' . $config->uri . '/ProSuccess');
                    exit();
                } else {
                    exit(__('Error While update balance after charging'));
                }
            }

        } catch (Exception $e) {
            echo get_class($e) . ': ' . $e->getMessage();
        }
    }
    public function credit_cancel(){
        global $config;
        header('Location: ' . $config->uri);
        exit();
    }
    public function credit_callback(){
        $this->credit_success();
    }

    public function generate_pro_link() {
        global $config;
        $amount = 0;
        if(isset($_GET['price']) && !empty($_GET['price'])){
            $amount = intval( Secure($_GET['price']) );
        }
        $url = '';
        try {
            $self_url = $config->uri;
            $payment_url = WebToPay::getPaymentUrl();

            $request = WebToPay::buildRequest(array(
                'projectid'     => $config->paysera_project_id,
                'sign_password' => $config->paysera_password,
                'orderid'       => rand(1111,4444),
                'amount'        => $amount,
                'currency'      => $config->currency,
                'country'       => 'TR',
                'accepturl'     => $self_url.'/aj/sms/pro_success?mode=membarship',
                'cancelurl'     => $self_url.'/aj/sms/pro_cancel?mode=membarship',
                'callbackurl'   => $self_url.'/aj/sms/pro_callback?mode=membarship',
                'test'          => ($config->paysera_test_mode == 'test') ? 1 : 0,
            ));

            $url = $payment_url . '?data='. $request['data'] . '&sign=' . $request['sign'];
            header('location: ' . $url);
            exit();
        }
        catch (WebToPayException $e) {
            echo $e->getMessage();
        }
    }
    public function pro_success(){
        global $config,$db;
        try {
            $response = WebToPay::checkResponse($_GET, array(
                'projectid'     => $config->paysera_project_id,
                'sign_password' => $config->paysera_password,
            ));

            if ($response['type'] !== 'macro') {
                die('Only macro payment callbacks are accepted');
            }
            $membershipType = 0;
            $price = intval( $response['amount'] ) / 100;
            if ((int)$price === (int)self::Config()->weekly_pro_plan) {
                $membershipType = "1";
            } else if ((int)$price === (int)self::Config()->monthly_pro_plan) {
                $membershipType = "2";
            } else if ((int)$price === (int)self::Config()->yearly_pro_plan) {
                $membershipType = "3";
            } else if ((int)$price === (int)self::Config()->lifetime_pro_plan) {
                $membershipType = "4";
            }
            if ((int)$response['status'] == 1){
                $protime  = time();
                $is_pro   = "1";
                $pro_type = $membershipType;
                $updated  = $db->where('id', self::ActiveUser()->id)->update('users', array(
                    'pro_time' => $protime,
                    'is_pro' => $is_pro,
                    'pro_type' => $membershipType
                ));
                if ($updated) {
                    RegisterAffRevenue(self::ActiveUser()->id,$price);
                    $db->insert('payments', array(
                        'user_id' => self::ActiveUser()->id,
                        'amount' => $price,
                        'type' => 'PRO',
                        'pro_plan' => $membershipType,
                        'credit_amount' => '0',
                        'via' => 'Paysera SMS payment'
                    ));
                    $_SESSION[ 'userEdited' ] = true;
                    header('Location: ' . $config->uri . '/ProSuccess?mode=pro');
                    exit();
                } else {
                    exit(__('Error While update balance after charging'));
                }
            }

        } catch (Exception $e) {
            echo get_class($e) . ': ' . $e->getMessage();
        }
    }
    public function pro_cancel(){
        global $config;
        header('Location: ' . $config->uri);
        exit();
    }
    public function pro_callback(){
        $this->pro_success();
    }
}
