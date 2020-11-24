<?php
Class Statistics extends Worker {
	function get_notifications() {
		$data                  = array();
        $notifications = LoadEndPointResource( 'notifications' );
        if ($notifications) {
            $data['notifications'] = $notifications->getUnreadNotifications();
        }
		$messages = LoadEndPointResource( 'messages' );
		if ($messages) {
			$data['chatnotifications'] = $messages->getUnreadMessages();
		}
		return $data;
	}
}
