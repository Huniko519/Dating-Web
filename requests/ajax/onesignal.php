<?php
Class Onesignal extends Aj {
    public function update_user_device_id() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 200,
                'message' => __('Forbidden')
            );
        }
        if (empty($_GET[ 'id' ])) {
            return array(
                'status' => 200,
                'message' => __('No Content')
            );
        } else {
            $id = Secure($_GET[ 'id' ]);
            if ($id != self::ActiveUser()->web_device_id) {
                $updated = $db->where('id', self::ActiveUser()->id)->update('users', array(
                    'web_device_id' => $id
                ));
                if ($updated) {
                    $_SESSION[ 'userEdited' ] = true;
                    return array(
                        'status' => 200
                    );
                }
            }
        }
    }
    public function remove_user_device_id() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 200,
                'message' => __('Forbidden')
            );
        }
        if (!empty(self::ActiveUser()->web_device_id)) {
            $updated = $db->where('id', self::ActiveUser()->id)->update('users', array(
                'web_device_id' => ''
            ));
            if ($updated) {
                $_SESSION[ 'userEdited' ] = true;
                return array(
                    'status' => 200
                );
            }
        }
    }
}