<?php
Class Profile extends Aj {
    public function approve_story(){
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $storyid            = Secure($_POST['storyid']);
        $story_to_userid    = Secure($_POST['storyuserid']);
        $storyuserid        = Secure($_POST['story_to_userid']);

        if( self::ActiveUser()->id == $story_to_userid ) {
            $story = $db->where('id', $storyid)->getOne('success_stories', array('quote'));
            $saved = $db->where('id', $storyid)->where('user_id', $storyuserid)->where('story_user_id', $story_to_userid)->update('success_stories', array(
                'status' => 1
            ));
            if ($saved) {
                $Notification = LoadEndPointResource('Notifications');
                if ($Notification) {
                    $Notification->createNotification(self::ActiveUser()->web_device_id, self::ActiveUser()->id, $storyuserid, 'approve_story', '', '/story/' . $storyid. '_'. url_slug($story['quote']));
                }
                return array(
                    'status' => 200,
                    'message' => __('Story approved successfully.'),
                    'url' => self::Config()->uri . '/story/' . $storyid. '_'. url_slug($story['quote'])
                );
            } else {
                return array(
                    'status' => 400,
                    'message' => __('Forbidden')
                );
            }
        }else{
            return array(
                'status' => 400,
                'message' => __('Forbidden')
            );
        }
    }
    public function disapprove_story(){
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $storyid            = Secure($_POST['storyid']);
        $story_to_userid    = Secure($_POST['storyuserid']);
        $storyuserid        = Secure($_POST['story_to_userid']);

        if( self::ActiveUser()->id == $story_to_userid ) {
            $story = $db->where('id', $storyid)->getOne('success_stories', array('quote'));
            $saved = $db->where('id', $storyid)->where('user_id', $storyuserid)->where('story_user_id', $story_to_userid)->update('success_stories', array(
                'status' => 0
            ));
            if ($saved) {
                $Notification = LoadEndPointResource('Notifications');
                if ($Notification) {
                    $Notification->createNotification(self::ActiveUser()->web_device_id, self::ActiveUser()->id, $storyuserid, 'disapprove_story', '', '/story/' . $storyid. '_'. url_slug($story['quote']));
                }
                return array(
                    'status' => 200,
                    'message' => __('Story disapproved successfully.')
                );
            } else {
                return array(
                    'status' => 400,
                    'message' => __('Forbidden')
                );
            }
        }else{
            return array(
                'status' => 400,
                'message' => __('Forbidden')
            );
        }
    }
    public function add_new_story(){
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $selected_user  = Secure($_POST['selected_user']);
        $story_date     = Secure($_POST['story_date']);
        $quote          = Secure($_POST['quote']);
        $story          = Secure(base64_decode($_POST['story']));

        $is_user_exist  = $db->where('username', $selected_user)->getOne('users','id');

        if( $is_user_exist['id'] !== null && $is_user_exist['id'] > 0 ){

            $exist = $db->where('user_id',self::ActiveUser()->id)->where('story_user_id',$is_user_exist['id'])->getOne('success_stories','id');
            if( $exist['id'] !== null && $exist['id'] > 0 ){
                return array(
                    'status' => 400,
                    'message' => __('You have previous story with this user')
                );
            }
            $saved = $db->insert('success_stories',array(
                'user_id' => self::ActiveUser()->id,
                'story_user_id' => $is_user_exist['id'],
                'quote' => $quote,
                'description' => $story,
                'story_date' => $story_date,
                'status' => 0,
                'created_at' => time()
            ));
            if($saved) {
                $Notification = LoadEndPointResource('Notifications');
                if ($Notification) {
                    $Notification->createNotification(self::ActiveUser()->web_device_id, self::ActiveUser()->id, $is_user_exist['id'], 'create_story', '', '/@' . self::ActiveUser()->username . '/story/' . $saved);
                }
                return array(
                    'status' => 200,
                    'message' => str_replace('{0}', $selected_user, __("Thank you for your story, we have sent the story to {0}, once approved your story will be published."))
                );
            }else{
                return array(
                    'status' => 400,
                    'message' => __('Forbidden')
                );
            }
        }else{
            return array(
                'status' => 400,
                'message' => __('No user found with this name')
            );
        }

    }
    public function unprivate_avater(){
        global $db, $_UPLOAD, $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error = '';
        $media_id = '';
        if (isset($_POST)) {
            if (isset($_POST['id']) && !empty($_POST['id'])) {
                $media_id = (int)Secure($_POST['id']);
            } else {
                $error .= '<p>• ' . __('Missing `id` parameter.') . '</p>';
            }
        }
        if ($error == '') {

            $exist = $db->where('user_id', self::ActiveUser()->id)->where('id', $media_id)->getOne('mediafiles');
            if(!$exist){
                return array(
                    'status' => 400,
                    'message' => 'Media Not exist'
                );
            }
            if ($exist[ 'file' ] == self::ActiveUser()->avater->full) {
                return array(
                    'status' => 400,
                    'message' => __('You can not delete your profile image, but you can change it first.')
                );
            }
            $id = $db->where('user_id', self::ActiveUser()->id)->where('id', $media_id)->get('mediafiles', 1, array('*'));
            if ($id[0]['id'] > 0) {
                $db->where('id', $id[0]['id'])->update('mediafiles', array('is_private' => 0, 'private_file' => ''));
                $avater_file = str_replace('_full.', '_avatar.', $id[0]['private_file']);
                if($id[0]['is_video'] == 0) {
                    DeleteFromToS3($id[0]['private_file']);
                    DeleteFromToS3($avater_file);
                }
            }
            return array(
                'status' => 200,
                'message' => __('File deleted successfully')
            );
        } else {
            return array(
                'status' => 400,
                'message' => $error
            );
        }
    }
    public function private_avater() {
        global $db, $_UPLOAD, $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden'),
                'lock_private_photo' => false
            );
        }
        if(self::Config()->lock_private_photo == 1 && self::ActiveUser()->lock_private_photo == 1){
            return array(
                'status' => 200,
                'lock_private_photo' => true
            );
        }
        $error = '';
        $media_id   = '';
        if (isset($_POST)) {
            if (isset($_POST[ 'id' ]) && !empty($_POST[ 'id' ])) {
                $media_id = (int)Secure($_POST[ 'id' ]);
            } else {
                $error .= '<p>• ' . __('Missing `id` parameter.') . '</p>';
            }
        }
        if ($error == '') {
            $exist = $db->where('user_id', self::ActiveUser()->id)->where('id', $media_id)->getOne('mediafiles');
            if(!$exist){
                return array(
                    'status' => 400,
                    'message' => 'Media Not exist'
                );
            }

            if ($exist[ 'file' ] == self::ActiveUser()->avater->full) {
                return array(
                    'status' => 400,
                    'message' => __('You can not private your profile image, but you can change it first.')
                );
            }
            $id = $db->where('user_id', self::ActiveUser()->id)->where('id', $media_id)->get('mediafiles', 1, array('*'));
            if ($id[0]['id'] > 0) {

                if( $id[0]['is_video'] == 1 ){
                    $db->where('id', $id[0]['id'])->update('mediafiles', array('is_private' => 1, 'private_file' => $id[0]['file']));
                    return array(
                        'status' => 200,
                        'message' => __('This image now is private.')
                    );
                }

                $avater_file = str_replace('_full.', '_avater.', $id[0]['file']);

                if (!file_exists($_UPLOAD . 'photos' . $_DS . 'private' . $_DS . date('Y'))) {
                    mkdir($_UPLOAD . 'photos' . $_DS . 'private' . $_DS . date('Y'), 0777, true);
                }
                if (!file_exists($_UPLOAD . 'photos' . $_DS . 'private' . $_DS . date('Y') . $_DS . date('m'))) {
                    mkdir($_UPLOAD . 'photos' . $_DS . 'private' . $_DS . date('Y') . $_DS . date('m'), 0777, true);
                }
                $dir = $_UPLOAD . 'photos' . $_DS . 'private' . $_DS . date('Y') . $_DS . date('m');
                $key      = GenerateKey();
                $file_extension    = pathinfo($id[0]['file'], PATHINFO_EXTENSION);

                $dest = $dir . $_DS . $key . '_private_full.'.$file_extension;
                $safe_dest = 'upload/photos/private/' . date('Y') . '/' . date('m') . '/' . $key . '_private_full.'.$file_extension;
                $safe_dest_thumb = 'upload/photos/private/' . date('Y') . '/' . date('m') . '/' . $key . '_private_avatar.'.$file_extension;

                if($id[0]['private_file'] == "") {
                    CompressImage($id[0]['file'], $dest, self::Config()->profile_picture_image_quality, true);
                }

                if(file_exists($dest)){

                    if($id[0]['private_file'] !== '') {
                        $safe_dest = $id[0]['private_file'];
                    }

                    $db->where('id', $id[0]['id'])->update('mediafiles', array('is_private' => 1, 'private_file' => $safe_dest));

                    $thumbnail = new ImageThumbnail($dest);
                    $thumbnail->setSize(self::Config()->profile_picture_width_crop, self::Config()->profile_picture_height_crop);
                    $thumbnail->save($safe_dest_thumb);

                    if (is_file($safe_dest_thumb)) {
                        $upload_s3 = UploadToS3($safe_dest_thumb, array(
                            'amazon' => 0
                        ));
                    }
                    if (is_file($safe_dest)) {
                        $upload_s3 .= UploadToS3($safe_dest, array(
                            'amazon' => 0
                        ));
                    }
                }


            }
            return array(
                'status' => 200,
                'message' => __('This image now is private.'),
                'lock_private_photo' => false
            );
        } else {
            return array(
                'status' => 400,
                'message' => $error,
                'lock_private_photo' => false
            );
        }
    }
    public function delete_avater() {
        global $db, $_UPLOAD, $_DS, $site_url;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error = '';
        $media_id   = '';
        if (isset($_POST)) {
            if (isset($_POST[ 'id' ]) && !empty($_POST[ 'id' ])) {
                $media_id = (int)Secure($_POST[ 'id' ]);
            } else {
                $error .= '<p>• ' . __('Missing `id` parameter.') . '</p>';
            }
        }
        if ($error == '') {
            $exist = $db->where('user_id', self::ActiveUser()->id)->where('id', $media_id)->getOne('mediafiles');
            if(!$exist){
                return array(
                    'status' => 400,
                    'message' => 'Media Not exist'
                );
            }

            $id = $db->where('user_id', self::ActiveUser()->id)->where('file', $exist[ 'file' ])->getValue('mediafiles', 'id');
            if ($id > 0) {

                if( $exist['is_video'] == 1 ){
                    DeleteFromToS3($exist[ 'video_file' ]);
                }

                $avater_file = str_replace('_full.', '_avater.', $exist[ 'file' ]);
                DeleteFromToS3($exist[ 'file' ]);
                DeleteFromToS3($avater_file);

                $private_file = $db->where('id', $id)->getValue('mediafiles', 'private_file');
                if($private_file !== ''){
                    $avater_file = str_replace('_full.', '_avatar.', $private_file);
                    DeleteFromToS3($avater_file);
                    DeleteFromToS3($private_file);
                }

                $db->where('id', $id)->delete('mediafiles');

                if ($exist[ 'file' ] == str_replace($site_url . "/","",self::ActiveUser()->avater->full)) {
                    $db->where('id', self::ActiveUser()->id)->update('users',array('avater' => self::Config()->userDefaultAvatar));
                }
            }
            return array(
                'status' => 200,
                'message' => __('File deleted successfully')
            );
        } else {
            return array(
                'status' => 400,
                'message' => $error
            );
        }
    }
    public function delete_avater_admin() {
        global $db, $_UPLOAD, $_DS;

        if (self::ActiveUser() == NULL || self::ActiveUser()->admin !== "1") {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error = '';
        $media_id   = '';
        $u_id   = '';
        if (isset($_POST)) {
            if (isset($_POST[ 'id' ]) && !empty($_POST[ 'id' ])) {
                $media_id = (int)Secure($_POST[ 'id' ]);
            } else {
                $error .= '<p>• ' . __('Missing `id` parameter.') . '</p>';
            }
        }
        if (isset($_POST)) {
            if (isset($_POST[ 'uid' ]) && !empty($_POST[ 'uid' ])) {
                $u_id = (int)Secure($_POST[ 'uid' ]);
            } else {
                $error .= '<p>• ' . __('Missing `uid` parameter.') . '</p>';
            }
        }
        if ($error == '') {

            $exist = $db->where('user_id', $u_id)->where('id', $media_id)->getOne('mediafiles');
            if(!$exist){
                return array(
                    'status' => 400,
                    'message' => 'Media Not exist'
                );
            }

            if ($exist[ 'file' ] == self::ActiveUser()->avater->full) {
                return array(
                    'status' => 400,
                    'message' => __('You can not private your profile image, but you can change it first.')
                );
            }

            $media = $db->where('id', $media_id)->getOne('mediafiles', array(
                'user_id'
            ));

            $uid = $media['user_id'];
            $userData = userData($uid);

            $id = $db->where('user_id', $uid)->where('id', $media_id)->getValue('mediafiles', 'id');
            if ($id > 0) {
                if( $exist['is_video'] == 1 ){
                    DeleteFromToS3($exist[ 'video_file' ]);
                }

                $avater_file = str_replace('_full.', '_avater.', $exist[ 'file' ]);
                DeleteFromToS3($exist[ 'file' ]);
                DeleteFromToS3($avater_file);

                $private_file = $db->where('id', $id)->getValue('mediafiles', 'private_file');
                if($private_file !== ''){
                    $avater_file = str_replace('_full.', '_avatar.', $private_file);
                    DeleteFromToS3($avater_file);
                    DeleteFromToS3($private_file);
                }

                $db->where('id', $id)->delete('mediafiles');
                if ($_POST[ 'url' ] == $userData->avater->full) {
                    $last_img = $db->where('user_id', $uid)->orderBy('id','DESC')->getValue('mediafiles', 'file');
                    if($last_img){
                        $db->where('id', $uid)->update('users',array( 'avater' => str_replace('_full.', '_avater.', $last_img) ));
                    }else{
                        $db->where('id', $uid)->update('users',array( 'avater' => self::Config()->userDefaultAvatar ));
                    }
                }

            }

            return array(
                'status' => 200,
                'message' => __('File deleted successfully'),
                'userData' => $userData
            );

        } else {
            return array(
                'status' => 400,
                'message' => $error
            );
        }
    }
    public function confirm_upload_video(){
        global $db, $_UPLOAD, $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (!isset($_FILES) && empty($_FILES)) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error = false;
        if (self::Config()->ffmpeg_sys == '0') {
            if (!isset($_FILES['video_thumbnail']) || empty($_FILES['video_thumbnail'])) {
                $error = true;
            }
        }

        if(!isset($_POST['media_id']) || empty($_POST['media_id'])){
            $error = true;
        }
        if(!isset($_POST['privacy'])){
            $error = true;
        }

        $media_exist = $db->where('id', (int)Secure($_POST['media_id']) )->where('user_id', self::ActiveUser()->id)->getOne('mediafiles');
        if(!$media_exist){
            $error = true;
        }

        if($error === false){

            if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y'))) {
                mkdir($_UPLOAD . 'photos' . $_DS . date('Y'), 0777, true);
            }
            if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'))) {
                mkdir($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'), 0777, true);
            }
            $dir = $_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m');
            $ext      = pathinfo($_FILES['video_thumbnail'][ 'name' ], PATHINFO_EXTENSION);
            $key      = GenerateKey();
            $filename = $dir . $_DS . $key . '.' . $ext;

            if (self::Config()->ffmpeg_sys == '1'){
                $media = array();
                $media['is_private'] = (int)Secure($_POST['privacy']);
                $media['is_confirmed'] = '1';
                $saved = $db->where('id', (int)Secure($_POST['media_id']))->where('user_id', self::ActiveUser()->id)->update('mediafiles', $media);
                if ($saved) {
                    return array(
                        'status' => 200
                    );
                } else {
                    return array(
                        'status' => 503
                    );
                }
            }else {
                if (move_uploaded_file($_FILES['video_thumbnail']['tmp_name'], $filename)) {
                    $org_file = 'upload' . $_DS . 'photos' . $_DS . date('Y') . $_DS . date('m') . $_DS . $key . '_full.' . $ext;
                    if (is_file($org_file)) {
                        $upload_s3 = UploadToS3($org_file, array(
                            'amazon' => 0
                        ));
                    }

                    $media = array();
                    $media['is_private'] = (int)Secure($_POST['privacy']);
                    $media['is_confirmed'] = '1';
                    $media['file'] = 'upload/photos/' . date('Y') . '/' . date('m') . '/' . $key . '.' . $ext;
                    $media['private_file'] = ((int)Secure($_POST['privacy']) === 1) ? 'upload/photos/' . date('Y') . '/' . date('m') . '/' . $key . '.' . $ext : '';
                    $saved = $db->where('id', (int)Secure($_POST['media_id']))->where('user_id', self::ActiveUser()->id)->update('mediafiles', $media);
                    if ($saved) {
                        return array(
                            'status' => 200
                        );
                    } else {
                        return array(
                            'status' => 503
                        );
                    }
                } else {
                    return array(
                        'status' => 403,
                        'message' => __('Forbidden')
                    );
                }
            }
        }else{
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
    }
    public function upload_video() {
        global $db, $_UPLOAD, $_DS, $_LIBS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (!isset($_FILES) && empty($_FILES)) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if(self::ActiveUser()->is_pro == '0'){
            $user_image_count = (int)$db->where('user_id', self::ActiveUser()->id)->getValue('mediafiles','count(id)');
            $config_max_image = (int)self::Config()->max_photo_per_user;
            if( $user_image_count >= $config_max_image ) {
                return array(
                    'status' => 403,
                    'message' => __('You reach to limit of media uploads.')
                );
            }
        }
        $error = false;
        $files = array();

        if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y'))) {
            mkdir($_UPLOAD . 'photos' . $_DS . date('Y'), 0777, true);
        }
        if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'))) {
            mkdir($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'), 0777, true);
        }
        $img_dir = $_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m');
        $img_path = 'upload/photos/' . date('Y') . '/' . date('m');

        if (!file_exists($_UPLOAD . 'videos' . $_DS . date('Y'))) {
            mkdir($_UPLOAD . 'videos' . $_DS . date('Y'), 0777, true);
        }
        if (!file_exists($_UPLOAD . 'videos' . $_DS . date('Y') . $_DS . date('m'))) {
            mkdir($_UPLOAD . 'videos' . $_DS . date('Y') . $_DS . date('m'), 0777, true);
        }
        $dir = $_UPLOAD . 'videos' . $_DS . date('Y') . $_DS . date('m');
        $ext      = pathinfo($_FILES['video'][ 'name' ], PATHINFO_EXTENSION);
        $key      = GenerateKey();
        $filename = $dir . $_DS . $key . '.' . $ext;

        if (self::Config()->ffmpeg_sys == '1' && !empty($_FILES['video']) && file_exists($_FILES['video']['tmp_name'])){

            require_once( $_LIBS . 'ffmpeg-php/vendor/autoload.php');

            $ffmpeg  = new FFmpeg(self::Config()->ffmpeg_binary);
            if (move_uploaded_file($_FILES['video']['tmp_name'], $filename)) {
                $org_file = 'upload' . $_DS . 'videos' . $_DS . date('Y') . $_DS . date('m') . $_DS . $key . '.' . $ext;
                if (is_file($org_file)) {
                    $upload_s3 = UploadToS3($org_file, array(
                        'amazon' => 0
                    ));
                }

                $filepath = explode('.', $org_file)[0];
                $filext   = explode('.', $org_file)[1];

                //
                    $ffmpeg->input($org_file);
                    $ffmpeg->set('-ss', '0');
                if((int)self::Config()->max_video_duration > 0) {
                    $ffmpeg->set('-t', (int)self::Config()->max_video_duration);
                }
                    $ffmpeg->set('-vcodec', 'h264');
                    $ffmpeg->set('-c:v', 'libx264');
                    $ffmpeg->set('-preset', 'ultrafast');
                    $ffmpeg->set('-acodec', 'mp3');
                    $ffmpeg->set('-hide_banner');
                    $ffmpeg->forceFormat('mp4');

                    $video = $ffmpeg->output("$filepath.final.mp4")->ready();
                    $video = 'upload/videos/' . date('Y') . '/' . date('m') . '/' . $key . '.final.mp4';
                    @unlink($org_file);
                //}else{
                //    $video = 'upload/videos/' . date('Y') . '/' . date('m') . '/' . $key . '.' . $ext;
                //}


                $hash     = sha1(time() + time() - rand(9999,9999));
                $thumb    = "$img_dir/$hash.video_thumb.jpeg";

                $ffmpeg = new FFmpeg(self::Config()->ffmpeg_binary);
                $ffmpeg->input($video);
                $ffmpeg->set('-ss','2');
                $ffmpeg->set('-vframes','1');
                $ffmpeg->set('-f','mjpeg');
                $output_thumb = $ffmpeg->output("$thumb")->ready();

                $vthumb = $img_path . "/$hash.video_thumb.jpeg";

                $media = array();
                $media['user_id'] = self::ActiveUser()->id;
                $media['file'] = $vthumb;
                $media['is_video'] = '1';
                $media['video_file'] = $video;
                $media['created_at'] = date('Y-m-d H:i:s');
                $saved = $db->insert('mediafiles', $media);
                if ($saved) {
                    $file = $video;
                    return array(
                        'status' => 200,
                        'video_file' => $file,
                        'media_id' => $saved,
                        'thumb' => GetMedia($vthumb)
                    );
                } else {
                    return array(
                        'status' => 503
                    );
                }

                return array(
                    'status' => 200,
                    'video_file' => $video,
                    'thumb' => $vthumb
                );


            } else {
                return array(
                    'status' => 503
                );
            }

        }else {

            if (move_uploaded_file($_FILES['video']['tmp_name'], $filename)) {
                $org_file = 'upload' . $_DS . 'videos' . $_DS . date('Y') . $_DS . date('m') . $_DS . $key . '.' . $ext;
                if (is_file($org_file)) {
                    $upload_s3 = UploadToS3($org_file, array(
                        'amazon' => 0
                    ));
                }
                $media = array();
                $media['user_id'] = self::ActiveUser()->id;
                $media['is_video'] = '1';
                $media['video_file'] = 'upload/videos/' . date('Y') . '/' . date('m') . '/' . $key . '.' . $ext;
                $media['created_at'] = date('Y-m-d H:i:s');
                $saved = $db->insert('mediafiles', $media);
                if ($saved) {
                    $file = 'upload/videos/' . date('Y') . '/' . date('m') . '/' . $key . '.' . $ext;
                    return array(
                        'status' => 200,
                        'video_file' => $file,
                        'media_id' => $saved
                    );
                } else {
                    return array(
                        'status' => 503
                    );
                }
            } else {
                return array(
                    'status' => 503
                );
            }

        }
    }
    public function upload_verification_photo(){
        global $db, $_UPLOAD, $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (!isset($_FILES) && empty($_FILES)) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (self::Config()->verification_on_signup == '0'){
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error = false;
        $files = array();
        $saved = false;
        $class = "hide";
        $id = $db->where('user_id', self::ActiveUser()->id)->get('verification_requests',null,array('*'));
        if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y'))) {
            mkdir($_UPLOAD . 'photos' . $_DS . date('Y'), 0777, true);
        }
        if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'))) {
            mkdir($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'), 0777, true);
        }
        $dir = $_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m');
        foreach ($_FILES as $file) {
            $ext      = pathinfo($file[ 'name' ], PATHINFO_EXTENSION);
            $key      = GenerateKey();
            $filename = $dir . $_DS . $key . '.' . $ext;
            if (move_uploaded_file($file[ 'tmp_name' ], $filename)) {
                $org_file  = 'upload'. $_DS . 'photos' . $_DS . date('Y') . $_DS . date('m') . $_DS . $key . '_full.' . $ext;
                $oreginal  = new ImageThumbnail($filename);
                $oreginal->setResize(false);
                $oreginal->save($org_file);
                @unlink($filename);
                if (is_file($org_file)) {
                    $upload_s3 = UploadToS3($org_file, array(
                        'amazon' => 0
                    ));
                }


                $media                 = array();

                $media[ 'user_name' ] = self::ActiveUser()->username;
                $media[ 'photo' ]       = 'upload/photos/' . date('Y') . '/' . date('m') . '/' . $key . '_full.' . $ext;
                if( $id[0] ){
                    $saved                 = $db->where('id',$id[0]['id'])->update('verification_requests', $media);
                        if($id[0]['passport'] !== '' ){
                            $class = "";
                        }

                }else{
                    $media[ 'user_id' ]    = self::ActiveUser()->id;
                    $saved                 = $db->insert('verification_requests', $media);
                }
                if ($saved) {
                    $_SESSION[ 'userEdited' ] = true;
                    $files[]                  = 'upload/photos/' . date('Y') . '/' . date('m') . '/' . $key . '_full.' . $ext;
                }
            } else {
                $error = true;
            }
        }
        if ($error) {
            return array(
                'status' => 503
            );
        } else {
            return array(
                'status' => 200,
                'files' => $files,
                'class' => $class
            );
        }

    }
    public function upload_verification_passport(){
        global $db, $_UPLOAD, $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (!isset($_FILES) && empty($_FILES)) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (self::Config()->verification_on_signup == '0'){
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error = false;
        $saved = false;
        $class = "hide";
        $files = array();
        if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y'))) {
            mkdir($_UPLOAD . 'photos' . $_DS . date('Y'), 0777, true);
        }
        if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'))) {
            mkdir($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'), 0777, true);
        }
        $dir = $_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m');
        foreach ($_FILES as $file) {
            $ext      = pathinfo($file[ 'name' ], PATHINFO_EXTENSION);
            $key      = GenerateKey();
            $filename = $dir . $_DS . $key . '.' . $ext;
            if (move_uploaded_file($file[ 'tmp_name' ], $filename)) {
                $org_file  = 'upload'. $_DS . 'photos' . $_DS . date('Y') . $_DS . date('m') . $_DS . $key . '_full.' . $ext;
                $oreginal  = new ImageThumbnail($filename);
                $oreginal->setResize(false);
                $oreginal->save($org_file);
                @unlink($filename);
                if (is_file($org_file)) {
                    $upload_s3 = UploadToS3($org_file, array(
                        'amazon' => 0
                    ));
                }
                $id = $db->where('user_id', self::ActiveUser()->id)->get('verification_requests',null,array('*'));

                $media                 = array();

                $media[ 'user_name' ] = self::ActiveUser()->username;
                $media[ 'passport' ]       = 'upload/photos/' . date('Y') . '/' . date('m') . '/' . $key . '_full.' . $ext;
                if( !empty($id[0]) ){
                    $saved                 = $db->where('id',$id[0]['id'])->update('verification_requests', $media);
                    if($id[0]['photo'] !== '' ){
                        $class = "";
                    }
                }else{
                    $media[ 'user_id' ]    = self::ActiveUser()->id;
                    $saved                 = $db->insert('verification_requests', $media);
                }
                if ($saved) {
                    $_SESSION[ 'userEdited' ] = true;
                    $files[]                  = 'upload/photos/' . date('Y') . '/' . date('m') . '/' . $key . '_full.' . $ext;
                }
            } else {
                $error = true;
            }
        }
        if ($error) {
            return array(
                'status' => 503
            );
        } else {
            return array(
                'status' => 200,
                'files' => $files,
                'class' => $class
            );
        }

    }
    public function upload_avater() {
        global $db, $_UPLOAD, $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (!isset($_FILES) && empty($_FILES)) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if(self::ActiveUser()->is_pro == '0'){
            $user_image_count = (int)$db->where('user_id', self::ActiveUser()->id)->getValue('mediafiles','count(id)');
            $config_max_image = (int)self::Config()->max_photo_per_user;
            if( $user_image_count >= $config_max_image ) {
                return array(
                    'status' => 403,
                    'message' => __('You reach to limit of media uploads.')
                );
            }
        }
        $error = false;
        $files = array();
        if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y'))) {
            mkdir($_UPLOAD . 'photos' . $_DS . date('Y'), 0777, true);
        }
        if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'))) {
            mkdir($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'), 0777, true);
        }
        $dir = $_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m');
        foreach ($_FILES as $file) {
            $ext      = pathinfo($file[ 'name' ], PATHINFO_EXTENSION);
            $key      = GenerateKey();
            $filename = $dir . $_DS . $key . '.' . $ext;


            if (move_uploaded_file($file[ 'tmp_name' ], $filename)) {

                $thumbfile = 'upload'. $_DS . 'photos' . $_DS . date('Y') . $_DS . date('m') . $_DS . $key . '_avater.' . $ext;
                $org_file  = 'upload'. $_DS . 'photos' . $_DS . date('Y') . $_DS . date('m') . $_DS . $key . '_full.' . $ext;
                $oreginal  = new ImageThumbnail($filename);
                $oreginal->setResize(false);
                $oreginal->save($org_file);
                $thumbnail = new ImageThumbnail($filename);
                $thumbnail->setSize(self::Config()->profile_picture_width_crop, self::Config()->profile_picture_height_crop);
                $thumbnail->save($thumbfile);
                @unlink($filename);
                if (is_file($org_file)) {
                    $upload_s3 = UploadToS3($org_file, array(
                        'amazon' => 0
                    ));
                } 
                if (is_file($thumbfile)) {
                    $upload_s3 .= UploadToS3($thumbfile, array(
                        'amazon' => 0
                    ));
                }
                $media                 = array();
                $media[ 'user_id' ]    = self::ActiveUser()->id;
                $media[ 'file' ]       = 'upload/photos/' . date('Y') . '/' . date('m') . '/' . $key . '_full.' . $ext;
                $media[ 'created_at' ] = date('Y-m-d H:i:s');
                if( self::Config()->review_media_files == '1') {
                    $media[ 'is_approved' ] = 0;
                }
                $saved                 = $db->insert('mediafiles', $media);
                if ($saved) {
                    $_SESSION[ 'userEdited' ] = true;
                    $files[]                  = 'upload/photos/' . date('Y') . '/' . date('m') . '/' . $key . '_avater.' . $ext;
                }
            } else {
                $error = true;
            }
        }
        if ($error) {
            return array(
                'status' => 503
            );
        } else {
            return array(
                'status' => 200,
                'files' => $files
            );
        }
    }
    public function set_avater() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (empty($_GET[ 'id' ])) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        } else {
            $id = Secure($_GET[ 'id' ]);
            if ($id != self::ActiveUser()->avater->avater) {
                $updated = $db->where('id', self::ActiveUser()->id)->update('users', array(
                    'avater' => $id
                ));
                if ($updated) {
                    $_SESSION[ 'userEdited' ] = true;
                    return array(
                        'status' => 200
                    );
                } else {
                    return array(
                        'status' => 204
                    );
                }
            }
        }
    }
    public function set_user_avater() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (empty($_GET[ 'id' ]) && empty($_GET[ 'userid' ])) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        } else {
            $id       = Secure($_GET[ 'id' ]);
            $userid   = Secure($_GET[ 'userid' ]);
            $new_user = $db->where('id', $userid)->getOne('users', array(
                'id'
            ));
            if ($new_user) {
                $updated = $db->where('id', $userid)->update('users', array(
                    'avater' => $id
                ));
                if ($updated) {
                    $media = $db->where('file', str_replace('_avater.', '_full.', $id))->getOne('mediafiles', array(
                        'id'
                    ));
                    if ($media) {
                        $saved = $db->where('id', $media['id'])->update('mediafiles', array('user_id' => $userid));
                        if ($saved) {
                            $_SESSION[ 'userEdited' ] = true;
                            return array(
                                'status' => 200
                            );
                        }
                    }
                } else {
                    return array(
                        'status' => 204
                    );
                }
            }
        }
    }
    public function set() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (empty($_GET[ 'key' ])) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (empty($_GET[ 'value' ])) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if ($_GET[ 'key' ] == 'username' || $_GET[ 'key' ] == 'password' || $_GET[ 'key' ] == 'admin' || $_GET[ 'key' ] == 'id' || $_GET[ 'key' ] == 'active' || $_GET[ 'key' ] == 'verified') {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $key     = Secure($_GET[ 'key' ]);
        $value   = Secure($_GET[ 'value' ]);
        $updated = $db->where('id', self::ActiveUser()->id)->update('users', array(
            $key => $value
        ));
        if ($updated) {
            $_SESSION[ 'userEdited' ] = true;
            return array(
                'status' => 200
            );
        } else {
            return array(
                'status' => 204
            );
        }
    }
    public function set_data() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (isset($_GET[ 'path' ])) {
            unset($_GET[ 'path' ]);
        }
        $data = array();
        foreach ($_GET as $key => $value) {
            if ($key == 'username' || $key == 'password' || $key == 'admin' || $key == 'id') {
                return array(
                    'status' => 403,
                    'message' => __('Forbidden')
                );
            } else {
                $data[ $key ] = Secure($value);
            }
        }
        if(isset($data['start_up']) && $data['start_up'] == "2"){
            if(self::Config()->emailValidation == "0"){
                $data['start_up'] = "3";
            }
//            if(self::Config()->image_verification == "1"){
//                $data['start_up'] = "1";
//            }
        }
        $updated = $db->where('id', self::ActiveUser()->id)->update('users', $data);
        if ($updated) {
            $_SESSION[ 'userEdited' ] = true;
            return array(
                'status' => 200
            );
        } else {
            return array(
                'status' => 204
            );
        }
    }
    public function set_snapshotdata(){
        global $db, $_UPLOAD, $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if( !isset( $_POST['snapshot'] ) ){
            return array(
                'status' => 204
            );
        }else{
            $img = $_POST['snapshot'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            if (!file_exists($_UPLOAD . 'snapshots' . $_DS . date('Y'))) {
                mkdir($_UPLOAD . 'snapshots' . $_DS . date('Y'), 0777, true);
            }
            if (!file_exists($_UPLOAD . 'snapshots' . $_DS . date('Y') . $_DS . date('m'))) {
                mkdir($_UPLOAD . 'snapshots' . $_DS . date('Y') . $_DS . date('m'), 0777, true);
            }
            $dir = $_UPLOAD . 'snapshots' . $_DS . date('Y') . $_DS . date('m');
            $key      = GenerateKey();
            $fileName = $dir . $_DS . $key . '.jpg';
            file_put_contents($fileName, $fileData);
            if (is_file($fileName)) {
                $safe_dir = 'upload/snapshots/' . date('Y') . '/' . date('m') . '/' . $key . '.jpg';
                $upload_s3 = UploadToS3($safe_dir, array(
                    'amazon' => 0
                ));
            }

            $data = array();
            $data['status'] = "2";
            $data['start_up'] = "1";
            if( self::Config()->pending_verification == "1" ) {
                $data['verified'] = "0";
            }
            $data['snapshot'] = 'upload/snapshots/' . date('Y') . '/' . date('m') . '/' . $key . '.jpg';

            $updated = $db->where('id', self::ActiveUser()->id)->update('users', $data);
            if ($updated) {
                $_SESSION[ 'userEdited' ] = true;
                return array(
                    'status' => 200
                );
            } else {
                return array(
                    'status' => 204
                );
            }
        }


    }
    public function save_general_setting() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error       = "";
        $set_admin   = false;
        $set_pro     = false;
        $set_balance = false;
        $user        = array();
        $users       = LoadEndPointResource('users');
        $target_id   = self::ActiveUser()->id;
        $change_phone = false;
        if (isset($_POST) && !empty($_POST)) {
            if (isset($_POST[ 'targetuid' ]) && $_POST[ 'targetuid' ] !== '') {
                $targetuid = base64_decode(strrev(Secure($_POST[ 'targetuid' ])));
                if (is_numeric($targetuid) && $targetuid > 0) {
                    $target_id = (int) $targetuid;
                }
            }
            if (isset($_POST[ 'first_name' ]) && strlen($_POST[ 'first_name' ]) > 30) {
                $error .= '<p>• ' . __('you can not use more than 30 character for first name.') . '</p>';
            }
            if (isset($_POST[ 'last_name' ]) && strlen($_POST[ 'last_name' ]) > 30) {
                $error .= '<p>• ' . __('you can not use more than 30 character for last name.') . '</p>';
            }
            if (isset($_POST[ 'username' ]) && $target_id == self::ActiveUser()->id) {
                if (Secure($_POST[ 'username' ]) !== self::ActiveUser()->username) {
                    if ($users) {
                        if ($users->isUsernameExists(Secure($_POST[ 'username' ]))) {
                            $error .= '<p>• ' . __('This User name is Already exist.') . '</p>';
                        }
                    }
                    $user_name_list = array(
                        'home',
                        'register',
                        'login',
                        'reset_password',
                        'social_login',
                        'find-matches',
                        'pro',
                        'credit',
                        'settings',
                        'settings-profile',
                        'settings-privacy',
                        'settings-password',
                        'settings-social',
                        'settings-blocked',
                        'settings-delete',
                        'settings-delete',
                        'visits',
                        'likes',
                        'liked',
                        'disliked',
                        'transactions',
                        'admin',
                        'about',
                        'contact',
                        'forgot',
                        'mail-otp',
                        'privacy',
                        'terms',
                        'reset',
                        'profile',
                        'ajax'
                    );
                    if (in_array(Secure($_POST[ 'username' ]), $user_name_list)) {
                        $error .= '<p>• ' . __('This User name is reserved word. please choose anther username.') . '</p>';
                    }
                }
            }
            if (isset($_POST[ 'username' ]) && empty($_POST[ 'username' ])) {
                $error .= '<p>• ' . __('empty user name.') . '</p>';
            }
            if (isset($_POST[ 'email' ]) && $target_id == self::ActiveUser()->id) {
                if (!filter_var($_POST[ 'email' ], FILTER_VALIDATE_EMAIL)) {
                    $error .= '<p>• ' . __('This e-mail is invalid.') . '</p>';
                } else {
                    if ($users) {
                        if (Secure($_POST[ 'email' ]) !== self::ActiveUser()->email) {
                            if ($users->isEmailExists(Secure($_POST[ 'email' ]))) {
                                $error .= '<p>• ' . __('This email is Already exist.') . '</p>';
                            }
                        }
                    }
                }
            }

            if( $config->disable_phone_field == 'on' ){ 
                if (self::ActiveUser()->phone_number !== $_POST[ 'phone_number' ]) {
                    $phone = Secure($_POST['phone_number']);
                    if (isset($_POST['phone_number']) && empty($_POST['phone_number'])) {
                        $error = '<p>• ' . __('Missing phone number.') . '</p>';
                    }
                    if (substr($_POST['phone_number'], 0, 1) !== '+') {
                        $error = '<p>• ' . __('Please provide international number with your area code starting with +.') . '</p>';
                    }
                    if (strlen($phone) < 6 OR strlen($phone) > 32) {
                        $error = '<p>• ' . __('Please enter valid number.') . '</p>';
                    }
                    if (!is_numeric(substr($phone, 1))) {
                        $error = '<p>• ' . __('Please provide international number with your area code starting with +.') . '</p>';
                    }
                }
            }

            if (self::ActiveUser()->admin == 1) {
                if (isset($_POST[ 'admin' ]) && ( $_POST[ 'admin' ] == 'on' || $_POST[ 'admin' ] == 'off' ) ) {
                    $set_admin = true;
                }
                if (isset($_POST[ 'is_pro' ]) && $_POST[ 'is_pro' ] == 'on') {
                    $set_pro = true;
                }
                if (isset($_POST[ 'balance' ]) && $_POST[ 'balance' ] >= 0) {
                    $set_balance = true;
                }
            }
            if ($error == '') {
                if (isset($_POST[ 'admin' ])) {
                    if ($set_admin) {
                        if ($_POST['admin'] == 'on') {
                            $user['admin'] = '1';
                        } elseif ($_POST['admin'] == 'off') {
                            $user['admin'] = '0';
                        }
                    }
                }
                if ($set_pro) {
                    if (self::ActiveUser()->admin == 1) {
                        $user['is_pro'] = '1';
                        $user['pro_type'] = '4';
                        $user['pro_time'] = time();
                    }
                } else {
                    if (self::ActiveUser()->admin == 1) {
                        $user['is_pro'] = '0';
                        $user['pro_type'] = '0';
                        $user['pro_time'] = '0';
                    }
                }
                if ($set_balance) {
                    $user[ 'balance' ] = Secure($_POST[ 'balance' ]);
                }
                if (isset($_POST[ 'first_name' ])) {
                    $user[ 'first_name' ] = Secure($_POST[ 'first_name' ],true,1);
                }
                if (isset($_POST[ 'last_name' ])) {
                    $user[ 'last_name' ] = Secure($_POST[ 'last_name' ],true,1);
                }
                if (isset($_POST[ 'email' ])) {
                    $user[ 'email' ] = Secure($_POST[ 'email' ]);
                }
                if (isset($_POST[ 'username' ])) {
                    $user[ 'username' ] = Secure($_POST[ 'username' ]);
                }
                if (isset($_POST[ 'country' ])) {
                    $user[ 'country' ] = Secure($_POST[ 'country' ]);
                }
                if (isset($_POST[ 'phone_number' ])) {
                    $user[ 'phone_number' ] = Secure($_POST[ 'phone_number' ]);
                    if (self::ActiveUser()->phone_number !== $user[ 'phone_number' ]) {
                        if (self::ActiveUser()->phone_verified == 1) {
                            $user[ 'verified' ] = '0';
                            $user[ 'phone_verified' ] = '0';
                            $user[ 'start_up' ] = '2';
                            $change_phone = true;
                        }
                    }
                }
                if (isset($_POST[ 'gender' ])) {
                    $user[ 'gender' ] = Secure($_POST[ 'gender' ]);
                }
                if (isset($_POST[ 'birthday' ])) {
                    $user[ 'birthday' ] = Secure($_POST[ 'birthday' ]);
                }

                $saved = $db->where('id', $target_id)->update('users', $user);
                if ($saved) {

                    $field_data = array();
                    if (!empty($_POST['custom_fields'])) {
                        $fields = GetProfileFields('general');
                        foreach ($fields as $key => $field) {
                            $name = $field['fid'];
                            if (isset($_POST[$name])) {
                                if (mb_strlen($_POST[$name]) > $field['length']) {
                                    $errors[] = $field['name'] . ' field max characters is ' . $field['length'];
                                }
                                $field_data[] = array(
                                    $name => $_POST[$name]
                                );
                            }
                        }
                    }
                    if (!empty($field_data)) {
                        $insert = UpdateUserCustomData($target_id, $field_data);
                    }

                    if ($target_id == self::ActiveUser()->id) {
                        $_SESSION[ 'userEdited' ] = true;

                        if( $change_phone === true ){
                            return array(
                                'status' => 200,
                                'message' => '<p> ' . __('Profile general data saved successfully.') . '</p>',
                                'url' => $config->uri
                            );

                        }else{
                            return array(
                                'status' => 200,
                                'message' => '<p> ' . __('Profile general data saved successfully.') . '</p>',
                                'updateDom' => array(
                                    'selector' => '#profile_link',
                                    'attributes' => array(
                                        'href' => $config->uri . '/@' . Secure($_POST[ 'username' ]),
                                        'data-ajax' => '/@' . Secure($_POST[ 'username' ])
                                    )
                                )
                            );
                        }

                    } else {
                        return array(
                            'status' => 200,
                            'message' => '<p> ' . __('Profile general data saved successfully.') . '</p>',
                            'set_balance' => $set_balance
                        );
                    }
                } else {
                    $error .= '<p>• ' . __('Error while saving general profile settings.') . '</p>';
                }
            }
        }
        if ($error !== '') {
            return array(
                'status' => 401,
                'message' => $error
            );
        }
    }
    public function verify_twofactor_setting(){
        global $db, $config;
        $error = '';
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (empty($_POST['twofactor_confirmationcode'])) {
            return array(
                'status' => 403,
                'message' => __('Something went wrong, please try again later.')
            );
        } else {
            $confirm_code = $db->where('id', self::ActiveUser()->id)->where('two_factor_email_code', md5($_POST['twofactor_confirmationcode']))->getValue('users', 'count(*)');
            $Update_data = array();
            if (empty($confirm_code)) {
                $error = __('Wrong confirmation code.');
            }
        }
        if (empty($error)) {
            $message = '';
            if (self::Config()->two_factor_type == 'phone') {
                $message = __('Your phone number has been successfully verified.');
                $Update_data['phone_number'] = self::ActiveUser()->new_phone;
                $Update_data['new_phone'] = '';
            }
            if (self::Config()->two_factor_type == 'email') {
                $message = __('Your E-mail has been successfully verified.');
                $Update_data['email'] = self::ActiveUser()->new_email;
                $Update_data['new_email'] = '';
            }
            if (self::Config()->two_factor_type == 'both') {
                $message = __('Your phone number and E-mail have been successfully verified.');
                if (!empty(self::ActiveUser()->new_email)) {
                    $Update_data['email'] = self::ActiveUser()->new_email;
                    $Update_data['new_email'] = '';
                }
                if (!empty(self::ActiveUser()->new_phone)) {
                    $Update_data['phone_number'] = self::ActiveUser()->new_phone;
                    $Update_data['new_phone'] = '';
                }
            }
            $Update_data['two_factor_verified'] = 1;
            $Update_data['two_factor'] = 1;
            $update = $db->where('id', self::ActiveUser()->id)->update('users', $Update_data);
            return array(
                'status' => 200,
                'message' => $message,
            );
        }else{
            return array(
                'status' => 400,
                'message' => __('Something went wrong, please try again later.'),
            );
        }
    }
    public function confirm_two_factor_confirmation_code(){
        global $db, $config;
        $errors = '';
        $data = array();
        if (!empty($_POST['confirm_code']) && !empty($_COOKIE['code_id'])) {
            $confirm_code = $_POST['confirm_code'];
            $user_id = $_COOKIE['code_id'];
            if (empty($_POST['confirm_code'])) {
                $errors = __('Please check your details.');
            } else if (empty($_COOKIE['code_id'])) {
                $errors = __('Error while activating your account.');
            }
            $confirm_code = $db->where('id', $user_id)->where('email_code', md5($confirm_code))->getValue('users', 'count(*)');
            if (empty($confirm_code)) {
                $errors = __('Wrong confirmation code.');
            }
            if (empty($errors) && $confirm_code > 0) {
                setcookie('code_id', '', 1, '/');
                unset($_COOKIE['code_id']);
                $user = $db->where('id', $user_id)->getOne('users');
                if ($user) {
                    SessionStart();
                    $users = LoadEndPointResource('users');
                    if ($users) {
                        $data = $users->createSession($user_id, $user);
                        if ($data) {
                            $profile =  $users->get_user_profile($user_id,array('web_token','start_up','active','web_token_created_at','verified','admin'));


                            if ( $config->maintenance_mode == 1 ) {
                                if ($profile->admin === "0") {
                                    return array(
                                        'status' => 400,
                                        'message' => '<p>• Website maintenance mode is active, Login for user is forbidden</p>'
                                    );
                                }
                            }

                            $JWT = $profile->web_token;
                            $url = '';
                            if ($profile->start_up == 3 && $profile->verified == 1) {
                                $url = $config->uri . '/find-matches';
                            } else {
                                $url = $config->uri . '/steps';
                            }
                            $_SESSION[ 'JWT' ]     = $profile;
                            $_SESSION[ 'user_id' ] = $JWT;
                            return array(
                                'status' => 200,
                                'message' => __('Login successfully'),
                                'url' => $url,
                                'cookies' => array(
                                    'JWT' => $JWT
                                )
                            );


                        }else{
                            return array(
                                'status' => 400,
                                'message' => $errors
                            );
                        }
                    }else{
                        return array(
                            'status' => 400,
                            'message' => $errors
                        );
                    }
                }else{
                    return array(
                        'status' => 400,
                        'message' => $errors
                    );
                }
            }else{
                return array(
                    'status' => 400,
                    'message' => $errors
                );
            }
        }else{
            return array(
                'status' => 400,
                'message' => __('Something went wrong, please try again later.')
            );
        }
    }
    public function save_twofactor_setting() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error       = "";
        $set_admin   = false;
        $set_pro     = false;
        $set_balance = false;
        $user        = array();
        $users       = LoadEndPointResource('users');
        $target_id   = self::ActiveUser()->id;
        $change_phone = false;

        if (!isset($_POST[ 'two_factor' ])) {
            $update = $db->where('id', self::ActiveUser()->id)->update('users', array('two_factor' => 0, 'two_factor_verified' => 0, 'two_factor_email_code' => ''));
            return array(
                'status' => 200,
                'message' => '<p> ' . __('Two-factor authentication data saved successfully.') . '</p>'
            );
        }

        if (isset($_POST) && !empty($_POST)) {
            if (isset($_POST[ 'targetuid' ]) && $_POST[ 'targetuid' ] !== '') {
                $targetuid = base64_decode(strrev(Secure($_POST[ 'targetuid' ])));
                if (is_numeric($targetuid) && $targetuid > 0) {
                    $target_id = (int) $targetuid;
                }
            }

            if ((empty($_POST['new_email']) && self::Config()->two_factor_type == 'email')) {
                $error = __('Please check your details.');
            }

            $is_phone = false;
            if (!empty($_POST['phone_number']) && (self::Config()->two_factor_type == 'both' || self::Config()->two_factor_type == 'phone')) {
                preg_match_all('/\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|
                            2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|
                            4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/', $_POST['phone_number'], $matches);
                if (!empty($matches[1][0]) && !empty($matches[0][0])) {
                    $is_phone = true;
                }
            }
            if ((empty($_POST['phone_number']) && self::Config()->two_factor_type == 'phone')) {
                $error = __('Please check your details.');
            }
            elseif (!empty($_POST['phone_number']) && (self::Config()->two_factor_type == 'both' || self::Config()->two_factor_type == 'phone') && $is_phone == false) {
                $error = __('Phone number should be as this format: +90..');
            }

            if ($error == '') {
                $code = rand(111111, 999999);
                $hash_code = md5($code);
                $message = "Your confirmation code is: $code";
                $phone_sent = false;
                $email_sent = false;
                if (!empty($_POST['phone_number']) && (self::Config()->two_factor_type == 'both' || self::Config()->two_factor_type == 'phone')) {
                    $send = SendSMS($_POST['phone_number'], $message);
                    if ($send) {
                        $phone_sent = true;
                        $Update_data = array(
                            'new_phone' => secure($_POST['phone_number'])
                        );
                        $update = $db->where('id', self::ActiveUser()->id)->update('users', $Update_data);
                    }
                }
                if (self::Config()->two_factor_type == 'both' || self::Config()->two_factor_type == 'email') {
                    $send_message_data       = array(
                        'from_email' => self::Config()->email,
                        'from_name' => self::Config()->name,
                        'to_email' => self::ActiveUser()->email,
                        'to_name' => self::ActiveUser()->first_name . ' ' . self::ActiveUser()->last_name,
                        'subject' => 'Please verify that it’s you',
                        'charSet' => 'utf-8',
                        'message_body' => $message,
                        'is_html' => true
                    );
                    if( isset( $_POST['new_email'] ) && !empty( $_POST['new_email'] ) ){
                        $send_message_data['to_email'] = secure($_POST['new_email']);
                    }
                    $send = SendEmail($send_message_data['to_email'],$send_message_data['subject'],$send_message_data['message_body'],false);
                    if ($send) {
                        $email_sent = true;
                    }
                }

                if ($email_sent == true || $phone_sent == true) {
                    if (isset($_POST[ 'two_factor' ])) {
                        $user[ 'two_factor' ] = 0;
                        $user[ 'two_factor_verified' ] = 0;
                        $user[ 'two_factor_email_code' ] = $hash_code;

                        if( isset( $_POST['new_email'] ) && !empty( $_POST['new_email'] ) ){
                            $user[ 'new_email' ] = secure($_POST['new_email']);
                        }
                    }
                    $saved = $db->where('id', $target_id)->update('users', $user);
                    if ($saved) {
                        return array(
                            'status' => 200,
                            'm' => $message,
                            'message' => '<p> ' . __('Two-factor authentication data saved successfully.') . '</p>'
                        );
                    } else {
                        $error .= '<p>• ' . __('Error while saving Two-factor authentication settings.') . '</p>';
                    }
                }
                else{
                    return array(
                        'status' => 400,
                        'message' => __('Something went wrong, please try again later.'),
                    );
                }
            }
        }
        if ($error !== '') {
            return array(
                'status' => 400,
                'message' => $error
            );
        }
    }
    public function save_profile_setting() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error     = "";
        $msg       = "";
        $user      = array();
        $target_id = self::ActiveUser()->id;
        if (isset($_POST) && !empty($_POST)) {
            if (isset($_POST[ 'targetuid' ]) && $_POST[ 'targetuid' ] !== '') {
                $targetuid = base64_decode(strrev(Secure($_POST[ 'targetuid' ])));
                if (is_numeric($targetuid) && $targetuid > 0) {
                    $target_id = (int) $targetuid;
                }
            }
            if (isset($_POST[ 'about' ])) {
                $user[ 'about' ] = Secure($_POST[ 'about' ]);
            }
            if (isset($_POST[ 'interest' ])) {
                $user[ 'interest' ] = Secure($_POST[ 'interest' ]);
            }
            if (isset($_POST[ 'location' ])) {
                $user[ 'location' ] = Secure($_POST[ 'location' ]);
            }
            if (isset($_POST[ 'relationship' ])) {
                $user[ 'relationship' ] = Secure($_POST[ 'relationship' ]);
            }
            if (isset($_POST[ 'language' ])) {
                $user[ 'language' ] = Secure($_POST[ 'language' ]);
            }
            if (isset($_POST[ 'work_status' ])) {
                $user[ 'work_status' ] = Secure($_POST[ 'work_status' ]);
            }
            if (isset($_POST[ 'education' ])) {
                $user[ 'education' ] = Secure($_POST[ 'education' ]);
            }
            if (isset($_POST[ 'ethnicity' ])) {
                $user[ 'ethnicity' ] = Secure($_POST[ 'ethnicity' ]);
            }
            if (isset($_POST[ 'body' ])) {
                $user[ 'body' ] = Secure($_POST[ 'body' ]);
            }
            if (isset($_POST[ 'height' ])) {
                $user[ 'height' ] = Secure($_POST[ 'height' ]);
            }
            if (isset($_POST[ 'hair_color' ])) {
                $user[ 'hair_color' ] = Secure($_POST[ 'hair_color' ]);
            }
            if (isset($_POST[ 'character' ])) {
                $user[ 'character' ] = Secure($_POST[ 'character' ]);
            }
            if (isset($_POST[ 'children' ])) {
                $user[ 'children' ] = Secure($_POST[ 'children' ]);
            }
            if (isset($_POST[ 'friends' ])) {
                $user[ 'friends' ] = Secure($_POST[ 'friends' ]);
            }
            if (isset($_POST[ 'pets' ])) {
                $user[ 'pets' ] = Secure($_POST[ 'pets' ]);
            }
            if (isset($_POST[ 'live_with' ])) {
                $user[ 'live_with' ] = Secure($_POST[ 'live_with' ]);
            }
            if (isset($_POST[ 'car' ])) {
                $user[ 'car' ] = Secure($_POST[ 'car' ]);
            }
            if (isset($_POST[ 'religion' ])) {
                $user[ 'religion' ] = Secure($_POST[ 'religion' ]);
            }
            if (isset($_POST[ 'smoke' ])) {
                $user[ 'smoke' ] = Secure($_POST[ 'smoke' ]);
            }
            if (isset($_POST[ 'drink' ])) {
                $user[ 'drink' ] = Secure($_POST[ 'drink' ]);
            }
            if (isset($_POST[ 'travel' ])) {
                $user[ 'travel' ] = Secure($_POST[ 'travel' ]);
            }
            if (isset($_POST[ 'music' ])) {
                $user[ 'music' ] = Secure($_POST[ 'music' ]);
            }
            if (isset($_POST[ 'dish' ])) {
                $user[ 'dish' ] = Secure($_POST[ 'dish' ]);
            }
            if (isset($_POST[ 'song' ])) {
                $user[ 'song' ] = Secure($_POST[ 'song' ]);
            }
            if (isset($_POST[ 'hobby' ])) {
                $user[ 'hobby' ] = Secure($_POST[ 'hobby' ]);
            }
            if (isset($_POST[ 'city' ])) {
                $user[ 'city' ] = Secure($_POST[ 'city' ]);
            }
            if (isset($_POST[ 'sport' ])) {
                $user[ 'sport' ] = Secure($_POST[ 'sport' ]);
            }
            if (isset($_POST[ 'book' ])) {
                $user[ 'book' ] = Secure($_POST[ 'book' ]);
            }
            if (isset($_POST[ 'movie' ])) {
                $user[ 'movie' ] = Secure($_POST[ 'movie' ]);
            }
            if (isset($_POST[ 'colour' ])) {
                $user[ 'colour' ] = Secure($_POST[ 'colour' ]);
            }
            if (isset($_POST[ 'tv' ])) {
                $user[ 'tv' ] = Secure($_POST[ 'tv' ]);
            }
            if (!empty($user)) {
                $saved = $db->where('id', $target_id)->update('users', $user);
                if ($saved) {

                    $field_data = array();
                    if (!empty($_POST['custom_fields'])) {
                        $fields = GetProfileFields('profile');
                        foreach ($fields as $key => $field) {
                            $name = $field['fid'];
                            if (isset($_POST[$name])) {
                                if (mb_strlen($_POST[$name]) > $field['length']) {
                                    $errors[] = $field['name'] . ' field max characters is ' . $field['length'];
                                }
                                $field_data[] = array(
                                    $name => $_POST[$name]
                                );
                            }
                        }
                    }
                    if (!empty($field_data)) {
                        $insert = UpdateUserCustomData($target_id, $field_data);
                    }

                    if ($target_id == self::ActiveUser()->id) {
                        $_SESSION[ 'userEdited' ] = true;
                    }
                    return array(
                        'status' => 200,
                        'message' => '<p> ' . __('Profile data saved successfully.') . '</p>'
                    );
                } else {
                    $error .= '<p>• ' . __('Error while saving profile settings.') . '</p>';
                }
            } else {
                return array(
                    'status' => 200,
                    'message' => '<p> ' . __('Profile data saved successfully.') . '</p>'
                );
            }
        }
        if ($error !== '') {
            return array(
                'status' => 401,
                'message' => $error
            );
        }
    }
    public function save_privacy_setting() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error     = "";
        $msg       = "";
        $user      = array();
        $target_id = self::ActiveUser()->id;
        if (isset($_POST)) {
            if (isset($_POST[ 'targetuid' ]) && $_POST[ 'targetuid' ] !== '') {
                $targetuid = base64_decode(strrev(Secure($_POST[ 'targetuid' ])));
                if (is_numeric($targetuid) && $targetuid > 0) {
                    $target_id = (int) $targetuid;
                }
            }
            if (isset($_POST[ 'privacy_show_profile_on_google' ]) && !empty($_POST[ 'privacy_show_profile_on_google' ])) {
                $user[ 'privacy_show_profile_on_google' ] = (Secure($_POST[ 'privacy_show_profile_on_google' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'privacy_show_profile_on_google' ] = 0;
            }
            if (isset($_POST[ 'privacy_show_profile_random_users' ]) && !empty($_POST[ 'privacy_show_profile_random_users' ])) {
                $user[ 'privacy_show_profile_random_users' ] = (Secure($_POST[ 'privacy_show_profile_random_users' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'privacy_show_profile_random_users' ] = 0;
            }
            if (isset($_POST[ 'privacy_show_profile_match_profiles' ]) && !empty($_POST[ 'privacy_show_profile_match_profiles' ])) {
                $user[ 'privacy_show_profile_match_profiles' ] = (Secure($_POST[ 'privacy_show_profile_match_profiles' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'privacy_show_profile_match_profiles' ] = 0;
            }
            if (isset($_POST[ 'confirm_followers' ]) && !empty($_POST[ 'confirm_followers' ])) {
                $user[ 'confirm_followers' ] = '1';
            } else {
                $user[ 'confirm_followers' ] = '0';
            }
            if (!empty($user)) {
                $saved = $db->where('id', $target_id)->update('users', $user);
                if ($saved) {
                    if ($target_id == self::ActiveUser()->id) {
                        $_SESSION[ 'userEdited' ] = true;
                    }
                    return array(
                        'status' => 200,
                        'message' => '<p> ' . __('Profile privacy data saved successfully.') . '</p>',
                        'user' => $user
                    );
                } else {
                    $error .= '<p>• ' . __('Error while saving privacy setting.') . '</p>';
                }
            } else {
                return array(
                    'status' => 200,
                    'message' => '<p> ' . __('Profile privacy data saved successfully.') . '</p>'
                );
            }
        }
        if ($error !== '') {
            return array(
                'status' => 401,
                'message' => $error
            );
        }
    }
    public function save_password_setting() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error            = "";
        $msg              = "";
        $set_new_password = false;
        $target_id        = self::ActiveUser()->id;
        if (isset($_POST) && !empty($_POST)) {
            if (isset($_POST[ 'targetuid' ]) && $_POST[ 'targetuid' ] !== '') {
                $targetuid = base64_decode(strrev(Secure($_POST[ 'targetuid' ])));
                if (is_numeric($targetuid) && $targetuid > 0) {
                    $target_id = (int) $targetuid;
                }
            }
            if ($_POST[ 'n_pass' ] !== $_POST[ 'cn_pass' ]) {
                $error .= "<p>• " . __("Passwords Don't Match.") . "</p>";
            }
            if (isset($_POST[ 'n_pass' ]) && empty($_POST[ 'n_pass' ])) {
                $error .= '<p>• ' . __('Missing New password.') . '</p>';
            }
            if (!empty($_POST[ 'n_pass' ]) && strlen($_POST[ 'n_pass' ]) < 6) {
                $error .= '<p>• ' . __('Password is too short.') . '</p>';
            }
            if (self::ActiveUser()->admin == "1") {
                $set_new_password = true;
            } else {
                if (isset($_POST[ 'c_pass' ]) && empty($_POST[ 'c_pass' ])) {
                    $error .= '<p>• ' . __('Current password missing .') . '</p>';
                } else {
                    $currentpass     = $db->where('id', $target_id)->getValue("users", "password");
                    $password_result = password_verify(Secure($_POST[ 'c_pass' ]), $currentpass);
                    if ($password_result == true) {
                        $set_new_password = true;
                    } else {
                        if (!empty($_POST[ 'c_pass' ])) {
                            $error .= '<p>• ' . __('Current password is wrong, please check again.') . '</p>';
                        }
                    }
                }
            }
            if ($error == '') {
                if ($set_new_password) {
                    $_new_password = password_hash(Secure($_POST[ 'n_pass' ]), PASSWORD_DEFAULT, array(
                        'cost' => 11
                    ));
                    $updated       = $db->where('id', $target_id)->update('users', array(
                        'password' => $_new_password
                    ));
                    if ($updated) {
                        if ($target_id == self::ActiveUser()->id) {
                            $_SESSION[ 'userEdited' ] = true;
                        }
                        return array(
                            'status' => 200,
                            'message' => '<p> ' . __('Password updated successfully.') . '</p>'
                        );
                    } else {
                        $error .= '<p>• ' . __('Error while update your password, please check again.') . '</p>';
                    }
                }
            }
        }
        if ($error !== '') {
            return array(
                'status' => 401,
                'message' => $error
            );
        }
    }
    public function save_social_setting() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error     = '';
        $msg       = '';
        $user      = array();
        $target_id = self::ActiveUser()->id;
        if (isset($_POST) && !empty($_POST)) {
            if (isset($_POST[ 'targetuid' ]) && $_POST[ 'targetuid' ] !== '') {
                $targetuid = base64_decode(strrev(Secure($_POST[ 'targetuid' ])));
                if (is_numeric($targetuid) && $targetuid > 0) {
                    $target_id = (int) $targetuid;
                }
            }
            if (isset($_POST[ 'facebook' ])) {
                if (filter_var($_POST[ 'facebook' ], FILTER_VALIDATE_URL)) {
                    $error .= '<p>• ' . __('Please enter just facebook profile user.') . '</p>';
                } else {
                    $user[ 'facebook' ] = Secure($_POST[ 'facebook' ]);
                }
            }
            if (isset($_POST[ 'twitter' ])) {
                if (filter_var($_POST[ 'twitter' ], FILTER_VALIDATE_URL)) {
                    $error .= '<p>• ' . __('Please enter just twitter profile user.') . '</p>';
                } else {
                    $user[ 'twitter' ] = Secure($_POST[ 'twitter' ]);
                }
            }
            if (isset($_POST[ 'google' ])) {
                if (filter_var($_POST[ 'google' ], FILTER_VALIDATE_URL)) {
                    $error .= '<p>• ' . __('Please enter just google profile user.') . '</p>';
                } else {
                    $user[ 'google' ] = Secure($_POST[ 'google' ]);
                }
            }
            if (isset($_POST[ 'instagram' ])) {
                if (filter_var($_POST[ 'instagram' ], FILTER_VALIDATE_URL)) {
                    $error .= '<p>• ' . __('Please enter just instagram profile user.') . '</p>';
                } else {
                    $user[ 'instagram' ] = Secure($_POST[ 'instagram' ]);
                }
            }
            if (isset($_POST[ 'linkedin' ])) {
                if (filter_var($_POST[ 'linkedin' ], FILTER_VALIDATE_URL)) {
                    $error .= '<p>• ' . __('Please enter just linkedin profile user.') . '</p>';
                } else {
                    $user[ 'linkedin' ] = Secure($_POST[ 'linkedin' ]);
                }
            }
            if (isset($_POST[ 'website' ])) {
                if (!empty($_POST[ 'website' ])) {
                    if (filter_var($_POST[ 'website' ], FILTER_VALIDATE_URL)) {
                        $user[ 'website' ] = Secure($_POST[ 'website' ]);
                    } else {
                        $error .= '<p>• ' . __('Please enter valid domain name.') . '</p>';
                    }
                } else {
                    $user[ 'website' ] = '';
                }
            }
            if ($error == '') {
                if (!empty($user)) {
                    $saved = $db->where('id', $target_id)->update('users', $user);
                    if ($saved) {

                        $field_data = array();
                        if (!empty($_POST['custom_fields'])) {
                            $fields = GetProfileFields('social');
                            foreach ($fields as $key => $field) {
                                $name = $field['fid'];
                                if (isset($_POST[$name])) {
                                    if (mb_strlen($_POST[$name]) > $field['length']) {
                                        $errors[] = $field['name'] . ' field max characters is ' . $field['length'];
                                    }
                                    $field_data[] = array(
                                        $name => $_POST[$name]
                                    );
                                }
                            }
                        }
                        if (!empty($field_data)) {
                            $insert = UpdateUserCustomData($target_id, $field_data);
                        }

                        if ($target_id == self::ActiveUser()->id) {
                            $_SESSION[ 'userEdited' ] = true;
                        }
                        return array(
                            'status' => 200,
                            'message' => '<p> ' . __('Social setting updated successfully.') . '</p>'
                        );
                    } else {
                        $error .= '<p>• ' . __('Error while saving social setting.') . '</p>';
                    }
                } else {
                    return array(
                        'status' => 200,
                        'message' => '<p> ' . __('Social setting updated successfully.') . '</p>'
                    );
                }
            }
        }
        if ($error !== '') {
            return array(
                'status' => 401,
                'message' => $error
            );
        }
    }
    public function save_email_setting() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error = '';
        $msg   = '';
        $user  = array();
        if (isset($_POST)) {
            if (isset($_POST[ 'email_on_profile_view' ]) && !empty($_POST[ 'email_on_profile_view' ]) && $_POST[ 'email_on_profile_view' ] !== self::ActiveUser()->email_on_profile_view) {
                $user[ 'email_on_profile_view' ] = (Secure($_POST[ 'email_on_profile_view' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'email_on_profile_view' ] = 0;
            }
            if (isset($_POST[ 'email_on_new_message' ]) && !empty($_POST[ 'email_on_new_message' ]) && $_POST[ 'email_on_new_message' ] !== self::ActiveUser()->email_on_new_message) {
                $user[ 'email_on_new_message' ] = (Secure($_POST[ 'email_on_new_message' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'email_on_new_message' ] = 0;
            }
            if (isset($_POST[ 'email_on_profile_like' ]) && !empty($_POST[ 'email_on_profile_like' ]) && $_POST[ 'email_on_profile_like' ] !== self::ActiveUser()->email_on_profile_like) {
                $user[ 'email_on_profile_like' ] = (Secure($_POST[ 'email_on_profile_like' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'email_on_profile_like' ] = 0;
            }
            if (isset($_POST[ 'email_on_purchase_notifications' ]) && !empty($_POST[ 'email_on_purchase_notifications' ]) && $_POST[ 'email_on_purchase_notifications' ] !== self::ActiveUser()->email_on_purchase_notifications) {
                $user[ 'email_on_purchase_notifications' ] = (Secure($_POST[ 'email_on_purchase_notifications' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'email_on_purchase_notifications' ] = 0;
            }
            if (isset($_POST[ 'email_on_special_offers' ]) && !empty($_POST[ 'email_on_special_offers' ]) && $_POST[ 'email_on_special_offers' ] !== self::ActiveUser()->email_on_special_offers) {
                $user[ 'email_on_special_offers' ] = (Secure($_POST[ 'email_on_special_offers' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'email_on_special_offers' ] = 0;
            }
            if (isset($_POST[ 'email_on_announcements' ]) && !empty($_POST[ 'email_on_announcements' ]) && $_POST[ 'email_on_announcements' ] !== self::ActiveUser()->email_on_announcements) {
                $user[ 'email_on_announcements' ] = (Secure($_POST[ 'email_on_announcements' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'email_on_announcements' ] = 0;
            }

            if (isset($_POST[ 'email_on_get_gift' ]) && !empty($_POST[ 'email_on_get_gift' ]) && $_POST[ 'email_on_get_gift' ] !== self::ActiveUser()->email_on_get_gift) {
                $user[ 'email_on_get_gift' ] = (Secure($_POST[ 'email_on_get_gift' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'email_on_get_gift' ] = 0;
            }
            if (isset($_POST[ 'email_on_got_new_match' ]) && !empty($_POST[ 'email_on_got_new_match' ]) && $_POST[ 'email_on_got_new_match' ] !== self::ActiveUser()->email_on_got_new_match) {
                $user[ 'email_on_got_new_match' ] = (Secure($_POST[ 'email_on_got_new_match' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'email_on_got_new_match' ] = 0;
            }
            if (isset($_POST[ 'email_on_chat_request' ]) && !empty($_POST[ 'email_on_chat_request' ]) && $_POST[ 'email_on_chat_request' ] !== self::ActiveUser()->email_on_chat_request) {
                $user[ 'email_on_chat_request' ] = (Secure($_POST[ 'email_on_chat_request' ]) == "on") ? 1 : 0;
            } else {
                $user[ 'email_on_chat_request' ] = 0;
            }

            if (!empty($user)) {
                $saved = $db->where('id', self::ActiveUser()->id)->update('users', $user);
                if ($saved) {
                    $_SESSION[ 'userEdited' ] = true;
                    return array(
                        'status' => 200,
                        'message' => '<p> ' . __('Emails setting saved successfully.') . '</p>'
                    );
                } else {
                    $error .= '<p>• ' . __('Error while saving email setting.') . '</p>';
                }
            } else {
                return array(
                    'status' => 200,
                    'message' => '<p> ' . __('Emails setting saved successfully.') . '</p>'
                );
            }
        }
        if ($error !== '') {
            return array(
                'status' => 401,
                'message' => $error
            );
        }
    }
    public function get_profile_likes() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $likes_html = '';
        $likes      = $db->objectBuilder()->join('users u', 'l.user_id=u.id', 'LEFT')->where('l.like_userid', self::ActiveUser()->id)->where('l.is_like', "1")->groupBy('l.user_id')->orderBy('l.created_at', 'DESC')->get('likes l', null, array(
            'DISTINCT(l.user_id)',
            'u.username',
            'u.avater',
            'l.created_at'
        ));
        foreach ($likes as $key => $value) {
            $likes_html .= '<li><a href="' . $config->uri . '/@' . $value->username . '" data-ajax="/@' . $value->username . '" class="valign-wrapper"><img src="' . GetMedia($value->avater) . '" class="margin_right_ten" /><span class="bold">' . $value->username . '</span></a><a href="' . $config->uri . '/@' . $value->username . '" class="valign-wrapper time ajax-time " title="' . date('c', strtotime($value->created_at)) . '">' . Time_Elapsed_String(strtotime($value->created_at)) . '</a></li>';
        }
        return array(
            'status' => 200,
            'likes' => $likes_html
        );
    }
    public function get_profile_views() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $views_html = '';
        $views      = $db->objectBuilder()->join('users u', 'v.user_id=u.id', 'LEFT')->where('v.view_userid', self::ActiveUser()->id)->groupBy('v.user_id')->orderBy('v.created_at', 'DESC')->get('views v', null, array(
            'DISTINCT(v.user_id)',
            'u.username',
            'u.avater',
            'max(v.created_at) as created_at'
        ));
        foreach ($views as $key => $value) {
            $views_html .= '<li><a href="' . $config->uri . '/@' . $value->username . '" data-ajax="/@' . $value->username . '" class="valign-wrapper"><img src="' . GetMedia($value->avater) . '" class="margin_right_ten" /><span class="bold">' . $value->username . '</span></a><a href="' . $config->uri . '/@' . $value->username . '" class="valign-wrapper ajax-time" title="' . date('c', strtotime($value->created_at)) . '">' . Time_Elapsed_String(strtotime($value->created_at)) . '</a></li>';
        }
        return array(
            'status' => 200,
            'views' => $views_html,
            'd' => $views
        );
    }
    public function get_notifications() {
        global $_BASEPATH,$_DS,$config;
        $data          = array(
            'status' => 200
        );

        $html = '';
        $theme_path = $_BASEPATH . 'themes' . $_DS . $config->theme . $_DS;

        $notifications = LoadEndPointResource('notifications');
        if ($notifications) {
            $data[ 'notifications' ] = (int) $notifications->getUnreadNotifications();
        }
        $messages = LoadEndPointResource('messages');
        if ($messages) {
            $data[ 'chatnotifications' ] = (int) $messages->getUnreadMessages();
        }

        $data['calls']    = 0;
        $data['is_call']  = 0;
        $check_calles     = CheckFroInCalls();
        if ($check_calles !== false && is_array($check_calles)) {
            $wo['incall']                 = $check_calles;
            $wo['incall']['in_call_user'] = userData($check_calles['from_id']);
            $data['calls']                = 200;
            $data['is_call']              = 1;


            $template            = $theme_path . 'partails' . $_DS . 'modals' . $_DS . 'in_call.php';
            if (file_exists($template)) {
                ob_start();
                require($template);
                $html .= ob_get_contents();
                ob_end_clean();
            }


            $data['calls_html']           = $html;
        }

        $data['audio_calls']   = 0;
        $data['is_audio_call'] = 0;
        $check_calles          = CheckFroInCalls('audio');
        if ($check_calles !== false && is_array($check_calles)) {
            $wo['incall']                 = $check_calles;
            $wo['incall']['in_call_user'] = userData($check_calles['from_id']);
            $data['audio_calls']          = 200;
            $data['is_audio_call']        = 1;

            $template            = $theme_path . 'partails' . $_DS . 'modals' . $_DS . 'in_audio_call.php';
            if (file_exists($template)) {
                ob_start();
                require($template);
                $html .= ob_get_contents();
                ob_end_clean();
            }

            $data['audio_calls_html']     = $html;
        }

        return $data;
    }
    public function open_gift_model() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $gifts_html = '';
        $gifts      = $db->objectBuilder()->orderBy('id', 'desc')->get('gifts', null, array(
            'id',
            'media_file'
        ));
        foreach ($gifts as $key => $value) {
            $gifts_html .= '<div class="gift-data" data-id="' . $value->id . '"><img src="' . GetMedia($value->media_file) . '" data-id="' . $value->id . '" class="gift"></div>';
        }
        return array(
            'status' => 200,
            'gifts' => $gifts_html
        );
    }
    public function send_gift() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error   = '';
        $to      = 0;
        $gift_id = 0;
        if (isset($_POST)) {
            if (isset($_POST[ 'to' ]) && is_numeric($_POST[ 'to' ])) {
                $to = (int) Secure($_POST[ 'to' ]);
            } else {
                $error .= '<p>• ' . __('Missing `to` parameter.') . '</p>';
            }
            if (isset($_POST[ 'gift_id' ]) && is_numeric($_POST[ 'gift_id' ])) {
                $gift_id = (int) Secure($_POST[ 'gift_id' ]);
            } else {
                $error .= '<p>• ' . __('Missing `gift_id` parameter.') . '</p>';
            }
        }
        if ($error == '') {
            $save = $db->insert('user_gifts', array(
                'from' => self::ActiveUser()->id,
                'to' => $to,
                'gift_id' => $gift_id,
                'time' => 0
            ));
            if ($save) {
                $db->where('id', self::ActiveUser()->id)->update('users', array(
                    'balance' => $db->dec((int) $config->cost_per_gift)
                ), 1);
                $Notification = LoadEndPointResource('Notifications');
                if ($Notification) {
                    $Notification->createNotification(self::ActiveUser()->web_device_id, self::ActiveUser()->id, $to, 'send_gift', '', '/@' . self::ActiveUser()->username . '/opengift/' . $save);
                }
                return array(
                    'status' => 200,
                    'current_credit' => self::ActiveUser()->balance - (int) $config->cost_per_gift,
                    'cost_per_gift' => (int) $config->cost_per_gift,
                    'message' => __('Gift send successfully.')
                );
            } else {
                return array(
                    'status' => 400,
                    'message' => __('Gift send failed.')
                );
            }
        } else {
            return array(
                'status' => 400,
                'message' => $error
            );
        }
    }
    public function record_gift_seen() {
        global $db;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $gift_id = 0;
        $error   = '';
        if (isset($_POST)) {
            if (isset($_POST[ 'id' ]) && is_numeric($_POST[ 'id' ])) {
                $gift_id = (int) Secure($_POST[ 'id' ]);
            } else {
                $error .= '<p>• ' . __('Missing `id` parameter.') . '</p>';
            }
        }
        if ($error == '') {
            $updated = $db->where('id', $gift_id)->update('user_gifts', array(
                'time' => time()
            ));
            if ($updated) {
                return array(
                    'status' => 200
                );
            } else {
                return array(
                    'status' => 400
                );
            }
        } else {
            return array(
                'status' => 400,
                'message' => $error
            );
        }
    }
    public function buymore_xvisits() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $_cost  = 0;
        $userid = 0;
        $error  = '';
        if (isset($_POST[ 'uid' ]) && !empty($_POST[ 'uid' ])) {
            $userid = Secure($_POST[ 'uid' ]);
        }
        if ($userid == 0) {
            $error = '<p>• ' . __('No user ID found.') . '</p>';
        }
        $_cost = (int) $config->cost_per_xvisits;
        if( isGenderFree(self::ActiveUser()->gender) === true ){
            $_cost = 0;
        }
        if (self::ActiveUser()->balance >= $_cost) {
        } else {
            $error = '<p>• ' . __('No credit available.') . '</p>';
        }
        if ($error == '') {
            $saved = $db->where('id', $userid)->update('users', array(
                'balance' => $db->dec($_cost),
                'user_buy_xvisits' => '1',
                'xvisits_created_at' => time()
            ));
            if ($saved) {
                $_SESSION[ 'userEdited' ] = true;
                return array(
                    'status' => 200,
                    'current_credit' => self::ActiveUser()->balance - $_cost,
                    'message' => __('User buy more visits successfully.')
                );
            } else {
                $error = '<p>• ' . __('Error while buy more visits.') . '</p>';
            }
        }
        if ($error !== '') {
            return array(
                'status' => 400,
                'message' => __('Error while buy more visits.')
            );
        }
    }
    public function buymore_xmatches() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $_cost  = 0;
        $userid = 0;
        $error  = '';
        if (isset($_POST[ 'uid' ]) && !empty($_POST[ 'uid' ])) {
            $userid = Secure($_POST[ 'uid' ]);
        }
        if ($userid == 0) {
            $error = '<p>• ' . __('No user ID found.') . '</p>';
        }
        $_cost = (int) $config->cost_per_xmatche;
        if( isGenderFree(self::ActiveUser()->gender) === true ){
            $_cost = 0;
        }
        if (self::ActiveUser()->balance >= $_cost) {
        } else {
            $error = '<p>• ' . __('No credit available.') . '</p>';
        }
        if ($error == '') {
            $saved = $db->where('id', $userid)->update('users', array(
                'balance' => $db->dec($_cost),
                'user_buy_xmatches' => '1',
                'xmatches_created_at' => time()
            ));
            if ($saved) {
                $_SESSION[ 'userEdited' ] = true;
                return array(
                    'status' => 200,
                    'current_credit' => self::ActiveUser()->balance - $_cost,
                    'message' => __('User buy more matches successfully.')
                );
            } else {
                $error = '<p>• ' . __('Error while buy more matches.') . '</p>';
            }
        }
        if ($error !== '') {
            return array(
                'status' => 400,
                'message' => __('Error while buy more matches.')
            );
        }
    }
    public function delete_session() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (isset($_POST[ 'session_id' ]) && is_numeric($_POST[ 'session_id' ])) {
            $session_id = (int) Secure($_POST[ 'session_id' ]);
        } else {
            $error = '<p>• ' . __('Missing `session_id` parameter.') . '</p>';
        }
        if ($error == '') {
            $delete = $db->where('user_id' , self::ActiveUser()->id)->where('id' , $session_id)->delete('sessions');
            if ($delete) {
                return array(
                    'status' => 200,
                    'message' => __('Session deleted successfully.')
                );
            }
        } else {
            return array(
                'status' => 400,
                'message' => $error
            );
        }
    }
    public function buymore_xlikes() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $_cost  = 0;
        $userid = 0;
        $error  = '';
        if (isset($_POST[ 'uid' ]) && !empty($_POST[ 'uid' ])) {
            $userid = Secure($_POST[ 'uid' ]);
        }
        if ($userid == 0) {
            $error = '<p>• ' . __('No user ID found.') . '</p>';
        }
        $_cost = (int) $config->cost_per_xlike;
        if( isGenderFree(self::ActiveUser()->gender) === true ){
            $_cost = 0;
        }
        if (self::ActiveUser()->balance >= $_cost) {
        } else {
            $error = '<p>• ' . __('No credit available.') . '</p>';
        }
        if ($error == '') {
            $saved = $db->where('id', $userid)->update('users', array(
                'balance' => $db->dec($_cost),
                'user_buy_xlikes' => '1',
                'xlikes_created_at' => time()
            ));
            if ($saved) {
                $_SESSION[ 'userEdited' ] = true;
                return array(
                    'status' => 200,
                    'current_credit' => self::ActiveUser()->balance - $_cost,
                    'message' => __('User buy more likes successfully.')
                );
            } else {
                $error = '<p>• ' . __('Error while buy more likes.') . '</p>';
            }
        }
        if ($error !== '') {
            return array(
                'status' => 400,
                'message' => __('Error while buy more likes.')
            );
        }
    }
    public function delete_account() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error                = "";
        $deleted              = false;
        $allow_delete_account = false;
        if (isset($_POST) && !empty($_POST)) {
            if (isset($_POST[ 'c_pass' ]) && empty($_POST[ 'c_pass' ])) {
                $error .= '<p>• ' . __('Current password missing.') . '</p>';
            } else {
                $currentpass     = $db->where('id', self::ActiveUser()->id)->getValue("users", "password");
                $password_result = password_verify(Secure($_POST[ 'c_pass' ]), $currentpass);
                if ($password_result == true) {
                    $allow_delete_account = true;
                } else {
                    if (!empty($_POST[ 'c_pass' ])) {
                        $error .= '<p>• ' . __('Current password is wrong, please check again.') . '</p>';
                    }
                }
            }
        }
        if ($error == '') {
            if ($allow_delete_account) {
                $d_user = LoadEndPointResource('users');
                if ($d_user) {
                    $deleted = $d_user->delete_user(self::ActiveUser()->id);
                }
                if ($deleted[ 'message' ] !== '' && $deleted[ 'is_delete' ] === false) {
                    return array(
                        'status' => 401,
                        'message' => $deleted[ 'message' ]
                    );
                } else {
                    logout(false);
                    return array(
                        'status' => 200,
                        'url' => $config->uri,
                        'message' => __('Your account deleted successfully.')
                    );
                }
            }
        }
        if ($error !== '') {
            return array(
                'status' => 401,
                'message' => $error
            );
        }
    }
    public function upload_receipt() {
        global $db, $_UPLOAD, $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (!isset($_FILES) && empty($_FILES)) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error = false;
        $files = array();
        if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y'))) {
            mkdir($_UPLOAD . 'photos' . $_DS . date('Y'), 0777, true);
        }
        if (!file_exists($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'))) {
            mkdir($_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m'), 0777, true);
        }
        $dir = $_UPLOAD . 'photos' . $_DS . date('Y') . $_DS . date('m');
        foreach ($_FILES as $file) {
            $ext      = pathinfo($file[ 'name' ], PATHINFO_EXTENSION);
            $key      = GenerateKey();
            $filename = $dir . $_DS . $key . '.' . $ext;
            if (move_uploaded_file($file[ 'tmp_name' ], $filename)) {
                $org_file  = $dir . $_DS . $key . '_full.' . $ext;
                $org_file  = 'upload' . $_DS . 'photos' . $_DS . date('Y') . $_DS . date('m') . $_DS . $key . '_avater.' . $ext;
                $oreginal  = new ImageThumbnail($filename);
                $oreginal->setResize(false);
                $oreginal->save($org_file);
                @unlink($filename);
                if (is_file($org_file)) {
                    $upload_s3 = UploadToS3($org_file, array(
                        'amazon' => 0
                    ));
                }
                $info                  = array();
                $info[ 'user_id' ]     = self::ActiveUser()->id;
                $info[ 'receipt_file' ]= 'upload/photos/' . date('Y') . '/' . date('m') . '/' . $key . '_avater.' . $ext;
                $info[ 'created_at' ]  = date('Y-m-d H:i:s');
                $info[ 'description' ] = (isset($_POST['description'])) ? Secure($_POST['description']) : '';
                $info[ 'price' ]       = (isset($_POST['price'])) ? Secure($_POST['price']) : '0';
                $info[ 'mode' ]        = (isset($_POST['mode'])) ? Secure($_POST['mode']) : '';
                $info[ 'approved' ]    = 0;
                $saved                 = $db->insert('bank_receipts', $info);
            } else {
                $error = true;
            }
        }
        if ($error) {
            return array(
                'status' => 503
            );
        } else {
            return array(
                'status' => 200,
                'info' => $info
            );
        }
    }
    public function request_payment() {
        global $db, $_UPLOAD, $_DS;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error = array();
        if (empty($_POST['amount']) || empty($_POST['paypal_email'])) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (Wo_IsUserPaymentRequested(self::ActiveUser()->id) === true) {
            $errors[] = __('You have already a pending request.');
        } else if (!filter_var($_POST['paypal_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = __('This e-mail is invalid.');
        } else if (!is_numeric($_POST['amount'])) {
            $errors[] = __('Invalid amount value');
        } else if ((self::ActiveUser()->aff_balance < $_POST['amount'])) {
            $errors[] = __('Invalid amount value, your amount is:') . ' ' . self::Config()->currency_symbol . number_format(self::ActiveUser()->aff_balance, 2);
        } else if (self::Config()->m_withdrawal > $_POST['amount']) {
            $errors[] = __('Invalid amount value, minimum withdrawal request is:') . ' '. self::Config()->currency_symbol . self::Config()->m_withdrawal;
        }
        if (empty($errors)) {
            $amount       = (float)Secure($_POST['amount']);
            $paypal_email = Secure($_POST['paypal_email']);
            $db->where('id', self::ActiveUser()->id)->update('users', array('paypal_email' => $paypal_email));
            $insert_payment = Wo_RequestNewPayment(self::ActiveUser()->id, $amount);
            if ($insert_payment) {
                $update_balance = Wo_UpdateBalance(self::ActiveUser()->id, $amount, '-');
                return array(
                    'status' => 200,
                    'message' => __('Your request has been sent, you&#039;ll receive an email regarding the payment details soon.')
                );
            }

        }else{
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
    }
    public function add_friend() {
        global $db, $config;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        $error   = '';
        $uname   = '';
        $to      = 0;
        if (isset($_POST)) {
            if (isset($_POST[ 'to' ]) && is_numeric($_POST[ 'to' ])) {
                $to = (int) Secure($_POST[ 'to' ]);
                $uname = $db->where('id', $to)->getValue('users','username');

                $user_followers = Wo_CountFollowing((int) self::ActiveUser()->id, true);
                $friends_limit  = $config->connectivitySystemLimit;
                if($user_followers >= $friends_limit){
                    $error .= '<p>• ' . __('You exceed Friends limit.') . '</p>';
                }
                if( $config->connectivitySystem == "0" ){
                    $error .= '<p>• ' . __('Friend system is disabled.') . '</p>';
                }
                if( ( Wo_IsFollowing($to, (int) self::ActiveUser()->id) === true || Wo_IsFollowing( (int) self::ActiveUser()->id, $to) === true ) || ( Wo_IsFollowRequested($to, (int) self::ActiveUser()->id) === true || Wo_IsFollowRequested((int) self::ActiveUser()->id, $to) === true ) ){
                    if (Wo_DeleteFollow($to, (int) self::ActiveUser()->id) || Wo_DeleteFollow((int) self::ActiveUser()->id, $to)) {
                        return array(
                            'status' => 200,
                            'message' => 'Request deleted',
                            'ajaxRedirect' => '/@'.$uname
                        );
                    }
                }
            } else {
                $error .= '<p>• ' . __('Missing `to` parameter.') . '</p>';
            }
        }
        if ($error == '') {
            if (Wo_RegisterFollow($to, (int) self::ActiveUser()->id)) {

                return array(
                    'status' => 200,
                    'message' => __('Success'),
                    'ajaxRedirect' => '/@'.$uname
                );
            }
        } else {
            return array(
                'status' => 400,
                'message' => $error
            );
        }
    }
    public function disapprove_friend_request(){
        global $conn;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (isset($_POST)) {
            $friend_request_userid  = (int)Secure($_POST['friend_request_userid']);
            $friend_request_to_userid   = (int)Secure($_POST['friend_request_to_userid']);
            if (!isset($friend_request_userid) or empty($friend_request_userid) or !is_numeric($friend_request_userid) or $friend_request_userid < 1) {
                return array(
                    'status' => 400,
                    'message' => __('Invalid id')
                );
            }
            if (!isset($friend_request_to_userid) or empty($friend_request_to_userid) or !is_numeric($friend_request_to_userid) or $friend_request_to_userid < 1) {
                return array(
                    'status' => 400,
                    'message' => __('Invalid id')
                );
            }
            if (Wo_IsFollowRequested($friend_request_userid, $friend_request_to_userid) === false) {
                return array(
                    'status' => 400,
                    'message' => __('No Friend Request found')
                );
            }
            $follower_data = Wo_UserData($friend_request_to_userid);
            if (empty($follower_data['id'])) {
                return false;
            }
            $following_data = Wo_UserData($friend_request_userid);
            if (empty($following_data['id'])) {
                return false;
            }
            if( self::ActiveUser()->id == $friend_request_userid ) {
                $query = mysqli_query($conn, "DELETE FROM `followers` WHERE `following_id` = {$friend_request_userid} AND `follower_id` = {$friend_request_to_userid} AND `active` = '0'");
                if ($query) {
                    $Notif = LoadEndPointResource('Notifications');
                    if ($Notif) {
                        $n = $Notif->createNotification($follower_data['web_device_id'], $friend_request_userid, $friend_request_to_userid, 'friend_request_rejected', '', '/@' . $following_data['username']);
                        if (isset($n['code']) && $n['code'] == '200') {
                            return array(
                                'status' => 200,
                                'message' => __('Success'),
                                'ajaxRedirect' => '/@'.$follower_data['username']
                            );
                        } else {
                            return array(
                                'status' => 400,
                                'message' => __('can not create notification')
                            );
                        }
                    } else {
                        return array(
                            'status' => 400,
                            'message' => __('can not create notification')
                        );
                    }
                } else {
                    return array(
                        'status' => 400,
                        'message' => __('can not create notification')
                    );
                }

            }else {
                return array(
                    'status' => 400,
                    'message' => __('You not authorized to perform this action')
                );
            }

        } else {
            return array(
                'status' => 400,
                'message' => __('Missing fields')
            );
        }
    }
    public function approve_friend_request(){
        global $conn;
        if (self::ActiveUser() == NULL) {
            return array(
                'status' => 403,
                'message' => __('Forbidden')
            );
        }
        if (isset($_POST)) {
            $friend_request_userid  = (int)Secure($_POST['friend_request_userid']);
            $friend_request_to_userid   = (int)Secure($_POST['friend_request_to_userid']);
            if (!isset($friend_request_userid) or empty($friend_request_userid) or !is_numeric($friend_request_userid) or $friend_request_userid < 1) {
                return array(
                    'status' => 400,
                    'message' => __('Invalid id')
                );
            }
            if (!isset($friend_request_to_userid) or empty($friend_request_to_userid) or !is_numeric($friend_request_to_userid) or $friend_request_to_userid < 1) {
                return array(
                    'status' => 400,
                    'message' => __('Invalid id')
                );
            }
            if (Wo_IsFollowRequested($friend_request_to_userid, $friend_request_userid) === false) {
                return array(
                    'status' => 400,
                    'message' => __('No Friend Request found')
                );
            }
            $follower_data = Wo_UserData($friend_request_to_userid);
            if (empty($follower_data['id'])) {
                return false;
            }
            $following_data = Wo_UserData($friend_request_userid);
            if (empty($following_data['id'])) {
                return false;
            }
            if( self::ActiveUser()->id == $friend_request_userid ) {
                $query = mysqli_query($conn, "UPDATE `followers` SET `active` = '1' WHERE `following_id` = {$friend_request_userid} AND `follower_id` = {$friend_request_to_userid} AND `active` = '0'");
                if ($query) {
                    $Notif = LoadEndPointResource('Notifications');
                    if ($Notif) {
                        $n = $Notif->createNotification($following_data['web_device_id'], $friend_request_to_userid, $friend_request_userid, 'friend_request_accepted', '', '/@' . $follower_data['username']);
                        if (isset($n['code']) && $n['code'] == '200') {
                            $Notif->createNotification($follower_data['web_device_id'], $friend_request_userid, $friend_request_to_userid, 'friend_request_accepted', '', '/@' . $following_data['username']);
                            return array(
                                'status' => 200,
                                'message' => __('Success'),
                                'ajaxRedirect' => '/@'.$follower_data['username']
                            );
                        } else {
                            return array(
                                'status' => 400,
                                'message' => __('can not create notification')
                            );
                        }
                    } else {
                        return array(
                            'status' => 400,
                            'message' => __('can not create notification')
                        );
                    }
                } else {
                    return array(
                        'status' => 400,
                        'message' => __('can not create notification')
                    );
                }

            }else {
                return array(
                    'status' => 400,
                    'message' => __('You not authorized to perform this action')
                );
            }

        } else {
            return array(
                'status' => 400,
                'message' => __('Missing fields')
            );
        }
    }
}
