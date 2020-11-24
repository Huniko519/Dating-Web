<?php
Class Paypal extends Aj {
    public function generate_link() {
        global $config;
        if (empty($_POST[ 'amount' ])) {
            return array(
                'status' => 400,
                'message' => __('No amount passed')
            );
        }
        if (!is_numeric($_POST[ 'amount' ])) {
            return array(
                'status' => 400,
                'message' => __('Amount is not number')
            );
        }
        if (empty($_POST[ 'description' ])) {
            return array(
                'status' => 400,
                'message' => __('No description passed')
            );
        }
        if (empty($_POST[ 'mode' ])) {
            return array(
                'status' => 400,
                'message' => __('There is no mode set for this call')
            );
        }
        $product   = Secure($_POST[ 'description' ]);
        $price     = Secure($_POST[ 'amount' ]);
        $mode      = Secure($_POST[ 'mode' ]);
        $ReturnUrl = self::Config()->uri . '/aj/paypal/payment_success?userid=' . auth()->id . '&paymode=' . $mode . '&price=' . $price . '&product=' . urlencode($product);
        $CancelUrl = self::Config()->uri . '/aj/paypal/payment_cenceled?userid=' . auth()->id . '&paymode=' . $mode . '&price=' . $price . '&product=' . urlencode($product);
        try {
            $link = PayUsingPayPal($product, $price, $mode, $ReturnUrl, $CancelUrl);
            if ($link[ 'type' ] == 'SUCCESS') {
                return array(
                    'status' => 200,
                    'message' => __('Link generated successfully'),
                    'location' => $link[ 'url' ]
                );
            }
        }
        catch (Exception $e) {
            return array(
                'status' => 400,
                'message' => $e->getMessage(),
                'ReturnUrl' => $ReturnUrl,
                'CancelUrl' => $CancelUrl
            );
        }
    }
    public function payment_success() {
        global $config, $db;
        $mode           = 'credits';
        $userid         = 0;
        $price          = 0;
        $product        = '';
        $amount         = 0;
        $membershipType = 0;
        $token          = null;
        $PayerID        = null;
        $paymentId      = null;
        if (isset($_REQUEST[ 'paymentId' ]) && isset($_REQUEST[ 'PayerID' ])) {
            $mode      = Secure($_REQUEST[ 'paymode' ]);
            $userid    = Secure($_REQUEST[ 'userid' ]);
            $price     = Secure($_REQUEST[ 'price' ]);
            $product   = Secure($_REQUEST[ 'product' ]);
            $PayerID   = Secure($_REQUEST[ 'PayerID' ]);
            $paymentId = Secure($_REQUEST[ 'paymentId' ]);
            $token     = Secure($_REQUEST[ 'token' ]);
            if (!is_array(PayPalCheckPayment($paymentId, $PayerID))) {
                if ($mode == 'credits') {
                    if ($price == self::Config()->bag_of_credits_price) {
                        $amount = self::Config()->bag_of_credits_amount;
                    } else if ($price == self::Config()->box_of_credits_price) {
                        $amount = self::Config()->box_of_credits_amount;
                    } else if ($price == self::Config()->chest_of_credits_price) {
                        $amount = self::Config()->chest_of_credits_amount;
                    }
                } else if ($mode == 'premium-membarship') {
                    if ($price == self::Config()->weekly_pro_plan) {
                        $membershipType = 1;
                    } else if ($price == self::Config()->monthly_pro_plan) {
                        $membershipType = 2;
                    } else if ($price == self::Config()->yearly_pro_plan) {
                        $membershipType = 3;
                    } else if ($price == self::Config()->lifetime_pro_plan) {
                        $membershipType = 4;
                    }
                } else if ($mode == 'unlock_private_photo') {
                    if ((int)$price == (int)self::Config()->lock_private_photo_fee) {
                        $amount = (int)self::Config()->lock_private_photo_fee;
                    }
                } else if ($mode == 'lock_pro_video'){
                    if ((int)$price == (int)self::Config()->lock_pro_video_fee) {
                        $amount = (int)self::Config()->lock_pro_video_fee;
                    }
                }
                if ($userid !== self::ActiveUser()->id) {
                    exit(__('Transaction user not match current active user'));
                }
                $user = $db->objectBuilder()->where('id', $userid)->getOne('users', array(
                    'balance'
                ));
                if ($mode == 'credits') {
                    $newbalance = $user->balance + $amount;
                    $updated = $db->where('id', $userid)->update('users', array(
                        'balance' => $newbalance
                    ));
                    if ($updated) {
                        RegisterAffRevenue(self::ActiveUser()->id, $price);
                        $db->insert('payments', array(
                            'user_id' => $userid,
                            'amount' => $price,
                            'type' => 'CREDITS',
                            'pro_plan' => '0',
                            'credit_amount' => $amount,
                            'via' => 'Paypal'
                        ));
                        $_SESSION['userEdited'] = true;
                        header('Location: ' . $config->uri . '/ProSuccess');
                        exit();
                    } else {
                        exit(__('Error While update balance after charging'));
                    }

                } else if ($mode == 'lock_pro_video') {
                    $updated    = $db->where('id', self::ActiveUser()->id)->update('users', array('lock_pro_video' => 0));
                    if ($updated) {
                        $db->insert('payments', array(
                            'user_id' => self::ActiveUser()->id,
                            'amount' => $price,
                            'type' => 'lock_pro_video',
                            'pro_plan' => '0',
                            'credit_amount' => '0',
                            'via' => 'Paypal'
                        ));
                        $_SESSION[ 'userEdited' ] = true;
                        header('Location: ' . $config->uri . '/ProSuccess?paymode=unlock');
                        exit();
                    } else {
                        exit(__('Error While update Unlock private photo charging'));
                    }
                } else if ($mode == 'unlock_private_photo') {
                    $updated    = $db->where('id', self::ActiveUser()->id)->update('users', array('lock_private_photo' => 0));
                    if ($updated) {
                        $db->insert('payments', array(
                            'user_id' => self::ActiveUser()->id,
                            'amount' => $price,
                            'type' => 'unlock_private_photo',
                            'pro_plan' => '0',
                            'credit_amount' => '0',
                            'via' => 'Paypal'
                        ));
                        $_SESSION[ 'userEdited' ] = true;
                        header('Location: ' . $config->uri . '/ProSuccess?paymode=unlock');
                        exit();
                    } else {
                        exit(__('Error While update Unlock private photo charging'));
                    }
                } else if ($mode == 'premium-membarship') {
                    $protime  = time();
                    $is_pro   = "1";
                    $pro_type = $membershipType;
                    $updated  = $db->where('id', $userid)->update('users', array(
                        'pro_time' => $protime,
                        'is_pro' => $is_pro,
                        'pro_type' => $pro_type
                    ));
                    if ($updated) {
                        RegisterAffRevenue(self::ActiveUser()->id,$price);
                        $db->insert('payments', array(
                            'user_id' => $userid,
                            'amount' => $price,
                            'type' => 'PRO',
                            'pro_plan' => $membershipType,
                            'credit_amount' => '0',
                            'via' => 'Paypal'
                        ));
                        $_SESSION[ 'userEdited' ] = true;
                        SuperCache::cache('pro_users')->destroy();
                        header('Location: ' . $config->uri . '/ProSuccess?paymode=pro');
                        exit();
                    } else {
                        exit(__('Error While update balance after charging'));
                    }
                }
            }
        } else {
            header('Location: ' . $config->uri . '/find-matches');
            exit();
        }
    }
    public function payment_cenceled() {
        global $config;
        header('Location: ' . $config->uri . '/payment-canceled');
        exit();
    }
}