<?php
global $config;
$stripe = array(
    'secret_key' => $config->stripe_secret,
    'publishable_key' => $config->stripe_id
);
\Stripe\Stripe::setApiKey($stripe[ 'secret_key' ]);
Class Stripe extends Aj {
    public function handle() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $data = array();
        if (empty($_POST[ 'stripeToken' ])) {
            return array(
                'status' => 400,
                'message' => __('No Token')
            );
        }
        if (empty($_POST[ 'description' ])) {
            return array(
                'status' => 400,
                'message' => __('No description')
            );
        }
        if (empty($_POST[ 'payType' ])) {
            return array(
                'status' => 400,
                'message' => __('No payType')
            );
        }
        $product        = Secure($_POST[ 'description' ]);
        $realprice      = Secure($_POST[ 'price' ]);
        $price          = Secure($_POST[ 'price' ]) * 100;
        $amount         = 0;
        $currency       = strtolower(self::Config()->currency);
        $payType        = Secure($_POST[ 'payType' ]);
        $membershipType = 0;
        $token          = $_POST[ 'stripeToken' ];
        if ($payType == 'credits') {
            if ($realprice == self::Config()->bag_of_credits_price) {
                $amount = self::Config()->bag_of_credits_amount;
            } else if ($realprice == self::Config()->box_of_credits_price) {
                $amount = self::Config()->box_of_credits_amount;
            } else if ($realprice == self::Config()->chest_of_credits_price) {
                $amount = self::Config()->chest_of_credits_amount;
            }
        } else if ($payType == 'membership') {
            if ($realprice == self::Config()->weekly_pro_plan) {
                $membershipType = 1;
            } else if ($realprice == self::Config()->monthly_pro_plan) {
                $membershipType = 2;
            } else if ($realprice == self::Config()->yearly_pro_plan) {
                $membershipType = 3;
            } else if ($realprice == self::Config()->lifetime_pro_plan) {
                $membershipType = 4;
            }
        } else if ($payType == 'unlock_private_photo') {
            if ((int)$realprice == (int)self::Config()->lock_private_photo_fee) {
                $amount = (int)self::Config()->lock_private_photo_fee;
            }
        } else if ($payType == 'lock_pro_video'){
            if ((int)$realprice == (int)self::Config()->lock_pro_video_fee) {
                $amount = (int)self::Config()->lock_pro_video_fee;
            }
        }
        try {
            $customer = \Stripe\Customer::create(array(
                'source' => $token
            ));
            $charge   = \Stripe\Charge::create(array(
                'customer' => $customer->id,
                'amount' => $price,
                'currency' => $currency
            ));
            if ($charge) {
                $user               = $db->objectBuilder()->where('id', self::ActiveUser()->id)->getOne('users', array(
                    'balance'
                ));
                $data[ 'status' ]   = 200;
                $data[ 'message' ]  = __('Payment successfully');
                $data[ 'location' ] = '/ProSuccess';
                if ($payType == 'credits') {
                    $newbalance = $user->balance + $amount;
                    $updated    = $db->where('id', self::ActiveUser()->id)->update('users', array(
                        'balance' => $newbalance
                    ));
                    if ($updated) {
                        RegisterAffRevenue(self::ActiveUser()->id,$price / 100);
                        $db->insert('payments', array(
                            'user_id' => self::ActiveUser()->id,
                            'amount' => $price / 100,
                            'type' => 'CREDITS',
                            'pro_plan' => '0',
                            'credit_amount' => $amount,
                            'via' => 'Stripe'
                        ));
                        $_SESSION[ 'userEdited' ] = true;
                        $data[ 'credit_amount' ]  = (int) $newbalance;
                        return $data;
                    } else {
                        return array(
                            'status' => 400,
                            'message' => __('Error While update balance after charging')
                        );
                    }
                } else if ($payType == 'membership') {
                    $data[ 'location' ] = '/ProSuccess?mode=pro';
                    $protime            = time();
                    $is_pro             = "1";
                    $pro_type           = $membershipType;
                    $updated            = $db->where('id', self::ActiveUser()->id)->update('users', array(
                        'pro_time' => $protime,
                        'is_pro' => $is_pro,
                        'pro_type' => $pro_type
                    ));
                    if ($updated) {
                        RegisterAffRevenue(self::ActiveUser()->id,$price / 100);
                        $db->insert('payments', array(
                            'user_id' => self::ActiveUser()->id,
                            'amount' => $price / 100,
                            'type' => 'PRO',
                            'pro_plan' => $membershipType,
                            'credit_amount' => '0',
                            'via' => 'Stripe'
                        ));
                        $_SESSION[ 'userEdited' ] = true;
                        SuperCache::cache('pro_users')->destroy();
                    } else {
                        return array(
                            'status' => 400,
                            'message' => __('Error While update balance after charging')
                        );
                    }
                } else if ($payType == 'unlock_private_photo') {
                    $updated    = $db->where('id', self::ActiveUser()->id)->update('users', array('lock_private_photo' => 0));
                    if ($updated) {
                        $db->insert('payments', array(
                            'user_id' => self::ActiveUser()->id,
                            'amount' => $price /100,
                            'type' => 'unlock_private_photo',
                            'pro_plan' => '0',
                            'credit_amount' => '0',
                            'via' => 'Stripe'
                        ));
                        $_SESSION[ 'userEdited' ] = true;
                        header('Location: ' . self::Config()->uri . '/ProSuccess?paymode=unlock');
                        exit();
                    } else {
                        exit(__('Error While update Unlock private photo charging'));
                    }
                } else if ($payType == 'lock_pro_video') {
                    $updated    = $db->where('id', self::ActiveUser()->id)->update('users', array('lock_pro_video' => 0));
                    if ($updated) {
                        $db->insert('payments', array(
                            'user_id' => self::ActiveUser()->id,
                            'amount' => $price /100,
                            'type' => 'lock_pro_video',
                            'pro_plan' => '0',
                            'credit_amount' => '0',
                            'via' => 'Stripe'
                        ));
                        $_SESSION[ 'userEdited' ] = true;
                        header('Location: ' . self::Config()->uri . '/ProSuccess?paymode=unlock');
                        exit();
                    } else {
                        exit(__('Error While update Unlock private photo charging'));
                    }
                }
                return $data;
            } else {
            }
        }
        catch (Exception $e) {
            return array(
                'status' => 400,
                'message' => $e->getMessage()
            );
        }
    }
}