<?php
    $error = "";
    if( isset( $_SESSION['JWT'] ) ){
        $profile = auth();
    }else{
        exit();
    }
    $current_step = "";
	if( $profile->status == 0 ){
        $current_step = "slider-zero-active";
    }else if( $profile->start_up == 0 ){
        $current_step = "slider-one-active";
    }else if( $profile->start_up == 1 ){
        if( $config->image_verification == 1 && $profile->status == 3 ){
            $current_step = "slider-one-active";
        }else {
            $current_step = "center slider-two-active";
        }
    }else if( $profile->start_up == 2 ){
        $current_step = "full slider-three-active";
    }

    global $db;
    if($config->emailValidation == '0'){
        if( $profile->start_up == 2 ){
            $db->where('id',$profile->id)->update('users',array('start_up'=>'3'));
            ?>
            <a href="javascript:void(0);" id="btnProSuccessRedirect" data-ajax="/find-matches" style="visibility: hidden;display: none;"></a>
            <script>
                setTimeout(() => {
                    $("#btnProSuccessRedirect").click();
                }, 1500);
            </script>
            <?php
        }
    }else{
//        if($config->pending_verification == '0'){
//            $db->where('id',$profile->id)->update('users',array('start_up'=>'2'));
//        }else{
//            if( $profile->start_up == 2 ){
//                $db->where('id',$profile->id)->update('users',array('start_up'=>'3'));
//                ?>
<!--                <a href="javascript:void(0);" id="btnProSuccessRedirect" data-ajax="/find-matches" style="visibility: hidden;display: none;"></a>-->
<!--                <script>-->
<!--                    setTimeout(() => {-->
<!--                        $("#btnProSuccessRedirect").click();-->
<!--                    }, 1500);-->
<!--                </script>-->
<!--                --><?php
//            }
//        }
    }
?>
    <!-- Step One  -->
    <div class="container slider_container <?php echo $current_step;?>">
        <div class="row">
            <div>
                <div class="dt_signup_steps">
                    <?php if( $config->image_verification == 1 && $profile->snapshot !== '' && $profile->approved_at == 0){ ?>
						<h5 class="empty_state">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15,3H12V6H8V3H5A2,2 0 0,0 3,5V21A2,2 0 0,0 5,23H15A2,2 0 0,0 17,21V5A2,2 0 0,0 15,3M10,8A2,2 0 0,1 12,10A2,2 0 0,1 10,12A2,2 0 0,1 8,10A2,2 0 0,1 10,8M14,16H6V15C6,13.67 8.67,13 10,13C11.33,13 14,13.67 14,15V16M11,5H9V1H11V5M14,19H6V18H14V19M10,21H6V20H10V21M19,12V7H21V12H19M19,16V14H21V16H19Z" /></svg>
							<?php echo __('Your account wait admin photo verification. Please try again later.');?>
						</h5>
                    <?php }else{ ?>
                    <div class="steps_header">
                        <div class="steps">
                            <div class="step step-one">
                                <div class="liner"></div>
                                <span><?php echo __( 'Avatar' );?></span>
                            </div>

                            <div class="step step-two" >
                                <div class="liner"></div>
                                <span><?php echo __( 'Info' );?></span>
                            </div>

                            <div class="step step-three">
                                <div class="liner"></div>
                                <span>
                                    <?php if( $config->emailValidation == "0" ) {?>
                                        <?php echo __( 'Finish' );?>
                                    <?php }else{ ?>
                                        <?php echo __( 'Verification' );?>
                                    <?php } ?>
                                </span>
                            </div>

                        </div>
                        <div class="line">
                            <div class="dot-move"></div>
                            <div class="dot zero"></div>
                            <div class="dot center"></div>
                            <div class="dot full"></div>
                        </div>
                    </div>
                    <div class="slider-ctr">
                        <div class="slider">

                            <?php $approved = false; if($config->verification_on_signup == 1){?>
                            <?php if($profile->verified == "1" && $profile->active == "1"){
                                $approved = true;
                                ?>
                                    <script>
                                        $("#verification_on_signup").hide();
                                        $("#profile_image_upload").show();
                                       // $(".slider_container").addClass("center slider-two-active").removeClass("full slider-one-active");
                                    </script>
                                    <?php
                            }else{ ?>
                            <form class="slider-form slider-one" id="verification_on_signup" style="padding: 0px;">
                                <div class="webcam_photo_verification <?php if( $profile->status == 0 ){ ?>hide0<?php }?>" >
                                    <h6 class="bold"><?php echo __( 'Verify your' );?> <?php echo $config->site_name;?> <?php echo __( 'account' );?>.</h6>
                                    <p><?php echo __( 'Please upload a photo with your passport / ID  & your distinct photo' );?>.</p>

                                    <div class="row">
                                        <div class="col m6 s6">

                                            <?php
                                                $vimg = get_verification_photo($profile->id);
                                                if( $vimg !== '' ){?>
                                                <span class="dt_selct_avatar qd_select_verifi_start dt_selct_avatar_vphoto_img" onclick="document.getElementById('vphoto_img').click(); return false" style="background-image: url(<?php echo GetMedia($vimg) ;?>);"></span>
                                            <?php }else{ ?>
                                                <span class="dt_selct_avatar qd_select_verifi_start dt_selct_avatar_vphoto_img" onclick="document.getElementById('vphoto_img').click(); return false">
                                                    <span class="svg-empty"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5,3A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H14.09C14.03,20.67 14,20.34 14,20C14,19.32 14.12,18.64 14.35,18H5L8.5,13.5L11,16.5L14.5,12L16.73,14.97C17.7,14.34 18.84,14 20,14C20.34,14 20.67,14.03 21,14.09V5C21,3.89 20.1,3 19,3H5M19,16V19H16V21H19V24H21V21H24V19H21V16H19Z"></svg></span>
                                                </span>
                                            <?php } ?>
                                            <input type="file" id="vphoto_img" class="hide" accept="image/x-png, image/gif, image/jpeg" name="vphoto">
                                            <div class="progress vphoto_progress qd_select_verifi_start_progress hide">
                                                <div class="determinate vphoto_determinate" style="width: 0%"></div >
                                            </div>
                                        </div>
                                        <div class="col m6 s6">

                                            <?php
                                            $pimg = get_verification_passport($profile->id);
                                            if( $pimg !== '' ){?>
                                                <span class="dt_selct_avatar qd_select_verifi_start dt_selct_avatar_vpassport_img" onclick="document.getElementById('vpassport_img').click(); return false" style="background-image: url(<?php echo GetMedia($pimg) ;?>);"></span>
                                            <?php }else{ ?>
                                                <span class="dt_selct_avatar qd_select_verifi_start dt_selct_avatar_vpassport_img" onclick="document.getElementById('vpassport_img').click(); return false">
                                                    <span class="svg-empty"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M2,3H22C23.05,3 24,3.95 24,5V19C24,20.05 23.05,21 22,21H2C0.95,21 0,20.05 0,19V5C0,3.95 0.95,3 2,3M14,6V7H22V6H14M14,8V9H21.5L22,9V8H14M14,10V11H21V10H14M8,13.91C6,13.91 2,15 2,17V18H14V17C14,15 10,13.91 8,13.91M8,6A3,3 0 0,0 5,9A3,3 0 0,0 8,12A3,3 0 0,0 11,9A3,3 0 0,0 8,6Z"></svg></span>
                                                </span>
                                            <?php } ?>
                                            <input type="file" id="vpassport_img" class="hide" accept="image/x-png, image/gif, image/jpeg" name="vpassport">
                                            <div class="progress vpassport_progress qd_select_verifi_start_progress hide">
                                                <div class="determinate vpassport_determinate" style="width: 0%"></div >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    $class = "hide";
                                    $verification_requests = $db->where('user_id', $profile->id)->get('verification_requests',null,array('*'));
                                    if(!empty($verification_requests[0])){
                                        if($verification_requests[0]['passport'] !== '' && $verification_requests[0]['photo'] !== ''){
                                            $class = "";
                                        }
                                    }
                                ?>
                                <div class="step_footer verification_requests_footer <?php echo $class;?>">
                                    <?php if($approved === true){ ?>
                                        <button class="waves-effect waves-light btn btn_primary bold first next" id="btn-verification_requests" data-pending-verification="<?php echo $config->pending_verification;?>" data-image-verification="<?php echo $config->image_verification;?>" data-src="<?php echo $profile->src;?>" data-selected="<?php if($profile->src == 'Facebook' ) { echo str_replace( $config->uri . '/' , '', $profile->avater->full); } ?>" data-defaultText="<?php echo __( 'Next' );?>"><span id="nexttext"><?php echo __( 'Next' );?></span> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
                                    <?php }else{ ?>
                                        <div class="center"><?php echo __('Your account is waiting admin approval.');?></div>
                                    <?php } ?>
                                </div>

                            </form>
                            <?php }}?>

                            <!-- Step 1  -->
                            <form class="slider-form slider-one" id="profile_image_upload" style="<?php if( $config->image_verification == 1 && $profile->status == 3 ){ ?>padding: 0px;<?php }?>">
                                <div class="choose_photo <?php if( $profile->status == 3 ){ ?>hide<?php }?>">
                                    <h6 class="bold"><?php echo ( $profile->full_name !== "" ? $profile->full_name : $profile->username ) ;?>, <?php echo __( 'people want to see what you look like!' );?></h6>
                                    <p><?php echo __( 'Upload Images to set your Profile Picture Image.' );?></p>

                                    <?php if( $profile->avater->full !== '' ){?>
                                        <span class="dt_selct_avatar" onclick="document.getElementById('avatar_img').click(); return false" style="background-image: url(<?php echo $profile->avater->full ;?>);background-repeat: no-repeat;background-size: cover;background-position: center center;">

                                        </span>
                                    <?php }else{ ?>
                                        <span class="dt_selct_avatar" onclick="document.getElementById('avatar_img').click(); return false">
                                            <span class="svg-empty"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5,3A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H14.09C14.03,20.67 14,20.34 14,20C14,19.32 14.12,18.64 14.35,18H5L8.5,13.5L11,16.5L14.5,12L16.73,14.97C17.7,14.34 18.84,14 20,14C20.34,14 20.67,14.03 21,14.09V5C21,3.89 20.1,3 19,3H5M19,16V19H16V21H19V24H21V21H24V19H21V16H19Z"></svg></span>
                                        </span>
                                    <?php } ?>

                                    <input type="file" id="avatar_img" class="hide" accept="image/x-png, image/gif, image/jpeg" name="avatar">
                                    <div class="progress hide" style="width: 180px;margin: auto;margin-top: 25px;padding-top: 4px;">
                                        <div class="determinate" style="width: 0%"></div >
                                    </div>
                                </div>

                                <?php if( $config->image_verification == 1 && $profile->snapshot == '' ){ ?>
                                <div class="webcam_photo_verification <?php if( $profile->status == 0 ){ ?>hide<?php }?>" >
                                    <h6 class="bold"><?php echo __( 'Verify your' );?> <?php echo $config->site_name;?> <?php echo __( 'account' );?>.</h6>
                                    <p><?php echo __( 'You will be required to take a selfie holding the ID document next to your face, so we can compare your photo with your actual look.This is just an additional security measure' );?>.</p>
                                    <div class="no_camera hide">
                                        <h5 class="empty_state">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3.27,2L2,3.27L4.73,6H4A1,1 0 0,0 3,7V17A1,1 0 0,0 4,18H16C16.2,18 16.39,17.92 16.54,17.82L19.73,21L21,19.73M21,6.5L17,10.5V7A1,1 0 0,0 16,6H9.82L21,17.18V6.5Z" /></svg>
											<?php echo __( 'Your camera is off or disconnected, Please connect your camera and try again.' );?>.
                                            <div id="errorMsg"></div>
										</h5>
                                        <button class="btn btn_primary btn_round waves-effect waves-light" id="btn-try-again"><?php echo __('Try again');?></button>
                                    </div>
									<div class="qd_verfy_pic_wcam row">
										<div class="col m6">
											<img src="<?php echo $theme_url;?>assets/img/img_verification.jpg" id="taken_shot" class="hide">
										</div>
										<div class="col m6">
											<div id="take_snapshot" class="hide">
												<video width="400" height="170" id="video" autoplay></video>
												<button class="waves-effect waves-light btn" id="btn-take-snapshot"><?php echo __( 'Take Snapshot' );?></button>
											</div>
											<div class="hide" id="retake_snapshot">
												<canvas width="226" height="170" class="camera_2" id='camera_canves'></canvas>
												<button class="waves-effect waves-light btn bold" id="btn-retake-snapshot"><?php echo __( 'Retake Snapshot' );?></button>
											</div>
										</div>
									</div>
                                </div>

                                <script>

                                    const constraints = window.constraints = {
                                        audio: false,
                                        video: true
                                    };

                                    function handleSuccess(stream) {
                                        const video = document.querySelector('video');
                                        const videoTracks = stream.getVideoTracks();
                                        console.log('Got stream with constraints:', constraints);
                                        console.log(`Using video device: ${videoTracks[0].label}`);
                                        window.stream = stream; // make variable available to browser console
                                        video.srcObject = stream;

                                        $('.no_camera').addClass('hide');
                                        $('#take_snapshot').removeClass('hide');
                                        $('#retake_snapshot').addClass('hide');
                                        $('#taken_shot').removeClass('hide');
                                        $('#btn-upload-images').removeClass('hide');
                                        $('.step_footer').removeClass('hide');

                                        $('.slider-one').css({'padding': 'none'});
                                        $('.choose_photo').removeClass('hide');
                                        $('.webcam_photo_verification').addClass('hide');

                                    }

                                    function handleError(error) {
                                        if (error.name === 'ConstraintNotSatisfiedError') {
                                            const v = constraints.video;
                                            errorMsg(`The resolution ${v.width.exact}x${v.height.exact} px is not supported by your device.`);
                                        } else if (error.name === 'PermissionDeniedError') {
                                            errorMsg('Permissions have not been granted to use your camera and ' +
                                            'microphone, you need to allow the page access to your devices in ' +
                                            'order for the demo to work.');
                                        }
                                        errorMsg(`getUserMedia error: ${error.name}`, error);


                                        $('.slider-one').css({'padding': '0px'});
                                        $('.choose_photo').addClass('hide');
                                        $('.webcam_photo_verification').removeClass('hide');


                                        $('.no_camera').removeClass('hide');
                                        $('#take_snapshot').addClass('hide');
                                        $('#retake_snapshot').addClass('hide');
                                        $('#taken_shot').addClass('hide');
                                        $('#btn-upload-images').addClass('hide');
                                        $('.step_footer').addClass('hide');
                                        $('#camera_canves').addClass('hide');

                                    }

                                    function errorMsg(msg, error) {
                                        const errorElement = document.querySelector('#errorMsg');
                                        errorElement.innerHTML += `<p>${msg}</p>`;
                                        // if (typeof error !== undefined) {
                                        //     console.error(error);
                                        // }
                                    }

                                    async function init(e) {
                                        try {
                                            const stream = await navigator.mediaDevices.getUserMedia(constraints);
                                            handleSuccess(stream);
                                            //e.target.disabled = true;
                                        } catch (e) {
                                            handleError(e);
                                        }
                                    }


                                    $(document).ready(function() {
                                        init();
                                        window.camera_canvas = document.getElementById("camera_canves");
                                        window.camera_ctx = window.camera_canvas.getContext('2d');
                                    });

                                    // window.camera_canvas = document.getElementById("camera_canves");
                                    // window.camera_ctx = window.camera_canvas.getContext('2d');

                                    // navigator.getUserMedia = ( navigator.getUserMedia ||
                                    //     navigator.webkitGetUserMedia ||
                                    //     navigator.mozGetUserMedia ||
                                    //     navigator.msGetUserMedia);

                                    // window.camera_video;
                                    // var webcamStream;
                                    // if (navigator.getUserMedia) {
                                    //     navigator.getUserMedia (

                                    //         // constraints
                                    //         {
                                    //             video: true,
                                    //             audio: false
                                    //         },

                                    //         // successCallback
                                    //         function(localMediaStream) {
                                    //             window.camera_video = document.getElementById('video');
                                    //             //video.src = window.URL.createObjectURL(localMediaStream);
                                    //             webcamStream = localMediaStream;
                                    //             window.camera_video.srcObject = webcamStream;

                                    //             $('.no_camera').addClass('hide');
                                    //             $('#take_snapshot').removeClass('hide');
                                    //             $('#retake_snapshot').addClass('hide');
                                    //             $('#taken_shot').removeClass('hide');
                                    //             $('#btn-upload-images').removeClass('hide');
                                    //             $('.step_footer').removeClass('hide');

                                    //             $('.slider-one').css({'padding': 'none'});
                                    //             $('.choose_photo').removeClass('hide');
                                    //             $('.webcam_photo_verification').addClass('hide');

                                    //         },

                                    //         // errorCallback
                                    //         function(err) {


                                    //             $('.slider-one').css({'padding': '0px'});
                                    //             $('.choose_photo').addClass('hide');
                                    //             $('.webcam_photo_verification').removeClass('hide');


                                    //             $('.no_camera').removeClass('hide');
                                    //             $('#take_snapshot').addClass('hide');
                                    //             $('#retake_snapshot').addClass('hide');
                                    //             $('#taken_shot').addClass('hide');
                                    //             $('#btn-upload-images').addClass('hide');
                                    //             $('.step_footer').addClass('hide');
                                    //             $('#camera_canves').addClass('hide');
                                    //             console.log("" + err);
                                    //         }
                                    //     );
                                    // } else {
                                    //     alert("webRTC isn't supported in your device");
                                    // }

                                </script>
                                <?php } ?>

                                <div class="step_footer">
                                    <button class="waves-effect waves-light btn btn_primary bold first next" id="btn-upload-images" data-pending-verification="<?php echo $config->pending_verification;?>" data-image-verification="<?php echo $config->image_verification;?>" <?php if($profile->src == 'Facebook' ) { } else { echo 'disabled'; }?> data-src="<?php echo $profile->src;?>" data-selected="<?php if($profile->src == 'Facebook' ) { echo str_replace( $config->uri . '/' , '', $profile->avater->full); } ?>" data-defaultText="<?php echo __( 'Next' );?>"><span id="nexttext"><?php echo __( 'Next' );?></span> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
                                </div>
                            </form>

                            <!--
                            <form class="slider-form slider-img">

                                <div class="step_footer">
                                    <button class="waves-effect waves-light btn btn_primary bold firstimg next" id="btn-verify-image" disabled data-selected=""><?php echo __( 'Next' );?> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
                                </div>
                            </form>
                            -->

                            <!-- Step 2  -->
                            <form class="slider-form slider-two">
                                <div class="row">
                                    <div class="input-field col s6">
                                        <select id="height" name="height" data-errmsg="<?php echo __( 'Your height is required.');?>">
                                            <?php echo DatasetGetSelect( null, "height", __("Height") );?>
                                        </select>
                                        <label for="height"><?php echo __( 'Height' );?></label>
                                    </div>
                                    <div class="input-field col s6">
                                        <select id="hair" name="hair">
                                            <?php echo DatasetGetSelect( null, "hair_color", __("Choose your Hair Color") );?>
                                        </select>
                                        <label for="hair"><?php echo __( 'Hair Color' );?></label>
                                    </div>
                                </div>
                                <div class="row">
                                <?php if( $config->disable_phone_field == 'on' ){ ?>
                                    <div class="input-field col s6">
                                        <input id="mobile" type="text" data-errmsg="<?php echo __( 'Your phone number is required.');?>" class="validate" title="Field must be a number." placeholder="<?php echo __('Phone number, e.g +90..');?>" <?php if($config->sms_or_email == 'sms'){?> data-validation-type="sms" required<?php }else{?> data-validation-type="mail" <?php } ?> >
                                        <label for="mobile"><?php echo __( 'Mobile Number' );?></label>
                                    </div>
                                <?php }?>
                                    <div class="input-field col s6">
                                        <select id="country" data-errmsg="<?php echo __( 'Select your country.');?>" required>
                                            <option value="" disabled selected><?php echo __( 'Choose your country' );?></option>
                                            <?php
                                            foreach( Dataset::load('countries') as $key => $val ){
                                                echo '<option value="'. $key .'" data-code="'. $val['isd'] .'">'. $val['name'] .'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="country"><?php echo __( 'Country' );?></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s6">
                                        <select id="gender" name="gender" data-errmsg="<?php echo __( 'Choose your Gender');?>" required>
                                            <?php echo DatasetGetSelect( null, "gender", __("Choose your Gender") );?>
                                        </select>
                                        <label for="gender"><?php echo __( 'Gender' );?></label>
                                    </div>
                                    <div class="input-field col s6">
                                        <input id="birthdate" data-errmsg="<?php echo __( 'Select your Birth date.');?>" type="text" class="datepicker user_bday" required>
                                        <label for="birthdate"><?php echo __( 'Birthdate' );?></label>
                                    </div>
                                </div>
                                <div class="step_footer">
                                    <button class="waves-effect waves-light btn btn_primary bold second next" data-src="<?php echo $profile->src;?>" data-emailvalidation="<?php echo $config->emailValidation;?>"><?php echo __( 'Next' );?> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
                                </div>
                            </form>
                            <!-- Step 3  -->
                            <form class="slider-form slider-three" <?php if( $config->emailValidation == "0" ) {?>style="padding:0px;"<?php } ?>>
                                <?php if( $config->emailValidation == "1" && $profile->src == 'site' ) {?>

                                    <?php if ( $config->sms_or_email == "sms" ) {?>
                                    <!-- Mobile -->
                                    <div class="otp_head">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M16,18H7V4H16M11.5,22A1.5,1.5 0 0,1 10,20.5A1.5,1.5 0 0,1 11.5,19A1.5,1.5 0 0,1 13,20.5A1.5,1.5 0 0,1 11.5,22M15.5,1H7.5A2.5,2.5 0 0,0 5,3.5V20.5A2.5,2.5 0 0,0 7.5,23H15.5A2.5,2.5 0 0,0 18,20.5V3.5A2.5,2.5 0 0,0 15.5,1Z" /></svg>
                                        <p><?php echo __( 'Phone Verification Needed' );?></p>
                                        <div class="row">
                                            <div class="col s12 m2"></div>
                                            <div class="col s12 m8">
                                                <div class="input-field inline">
                                                    <input id="mobile_validate" type="text" style="width: 200px;" value="<?php echo $profile->phone_number;?>">
                                                </div>
                                                <button class="btn waves-effect waves-light" style="margin-left: -5px;" id="send_otp"><?php echo __( 'Send OTP' );?></button>
                                            </div>
                                            <div class="col s12 m2"></div>
                                        </div>
                                    </div>
                                    <div class="enter_otp">
                                        <p><?php echo __( 'Please enter the verification code sent to your Phone' );?></p>
                                        <div id="otp_outer">
                                            <div id="otp_inner">
                                                <input id="otp_check_phone" type="text" maxlength="4" value="" pattern="\d*" title="Field must be a number." onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,'') } if($(this).val().length == 4){verify_sms_code(this);}" required />
                                                <a href="javascript:void(0);" data-ajax="/steps"><?php echo __( 'Resend' );?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Mobile -->
                                    <?php } ?>
                                    <?php if ( $config->sms_or_email == "mail" ) {?>
                                    <!-- Email -->
                                    <div class="otp_head">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z" /></svg>
                                        <p><?php echo __( 'Email Verification Needed' );?></p>
                                        <div class="row">
                                            <div class="col s12 m2"></div>
                                            <div class="col s12 m8">
                                                <div class="input-field inline">
                                                    <input id="email" type="email" value="<?php echo strtolower($profile->email);?>" data-email="<?php echo strtolower($profile->email);?>">
                                                </div>
                                                <button class="btn waves-effect waves-light" id="send_otp_email"><?php echo __( 'Send OTP' );?></button>
                                            </div>
                                            <div class="col s12 m2"></div>
                                        </div>
                                    </div>
                                    <div class="enter_otp_email">
                                        <p><?php echo __( 'Please enter the verification code sent to your Email' );?></p>
                                        <div id="otp_outer">
                                            <div id="otp_inner">
                                                <input id="otp_check_email" type="text" maxlength="4" value="" pattern="\d*" title="Field must be a number." onkeyup="if (/\D/g.test(this.value)){ this.value = this.value.replace(/\D/g,'') } if($(this).val().length == 4){verify_email_code(this);}" required/>
                                                <a href="<?php echo $site_url;?>/steps" data-ajax="/steps"><?php echo __( 'Resend' );?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Email -->
                                    <?php } ?>
                                <?php }else{ ?>

                                            <div class="dt_p_head center pro_success">
                                                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"></circle><path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path></svg>
                                                <h2 class="light"><?php echo __( 'Congratulations!' );?></h2>
                                                <p class="bold"><?php echo __('You have successfully registered.');?></p>
                                            </div>

                                <?php } ?>
                                <div class="step_footer">
                                    <button class="waves-effect waves-light btn btn_primary bold reset" disabled><?php echo __( 'Finish' );?> <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"></path></svg></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Step One  -->

    <!-- Images Modal -->
    <div id="modal_imgs" class="modal modal-fixed-footer">
        <div class="modal-content">
            <h6 class="bold"><span class="count_imgs"></span> <?php echo __( 'Images Uploaded' );?></h6>
            <p class="select_profile_image" style="display:none;"><?php echo __( 'Now, select any one image that you want to set as your Profile Picture.' );?></p>
            <div id="image_holder"></div>

            <div class="progress">
                <div class="determinate" style="width: 0%"></div >
            </div>

            <div id="status"></div>

        </div>
        <div class="modal-footer">
            <div id="modal_imgs_info"></div><button class="modal-close waves-effect waves-green btn-flat bold" disabled  data-selected=""><?php echo __( 'Apply' );?></button>
        </div>
    </div>
    <!-- End Images Modal -->
<?php if( $config->image_verification == 1 ){ ?>
<style>
    .slider_container.center .line .dot-move {
        left: 50%;
        animation: .3s anim 1;
    }
</style>
<?php }?>