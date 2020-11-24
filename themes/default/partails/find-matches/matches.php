<?php global $site_url; ?>
<div class="mtc_usrd_content" data-id="<?php echo $matche->id;?>" <?php if($matche_first === false){?> style="display: none;"<?php }?>>
    <div class="row">
        <div class="col <?php if( $mode == 'hot' ){?>s12<?php }else{ ?>s12 m7<?php }?>">
            <div class="mtc_usrd_slider">
                <div class="mtc_usrd_top">
                    <div class="mtc_usrd_summary">
                        <div class="usr_name">
                            <?php
                                $_age = getAge($matche->birthday);
                                $_location = $matche->country;
                            ?>
                            <a href="<?php echo $site_url;?>/@<?php echo $matche->username;?>" data-ajax="/@<?php echo $matche->username;?>" tooltip="<?php echo $matche->username;?>"><?php echo ($matche->first_name !== '' ) ? $matche->first_name . ' ' . $matche->last_name : $matche->username;?></a><?php if( !empty($_age) || !empty($_location) ) {?>,<?php }?></div>
                            <?php if( !empty($_age) ) {?> <div class="usr_age"><?php echo $_age;?></div><?php }?>
                            <?php if( !empty($_location) ) {?> <div class="usr_location"><?php echo $_location;?></div> <?php }?>
                        <?php if( $mode == 'hot' ){ echo '&nbsp;&nbsp;' . $matche->gender; }?>
                    </div>
                </div>
				<?php if( $mode == 'hot' ){?>
					<?php $x = 0;$uname = ''; foreach ($matche->mediafiles as $key => $mfile){ if( $x > 1 ) { continue; } else { $uname = $matche->username;?>
						<a href="<?php echo $mfile['full'];?>" data-id="<?php echo $mfile['id'];?>" data-fancybox class="inline" rel="group-<?php echo $uname;?>">
                            <img alt="<?php echo $matche->username;?>" src="<?php echo $mfile['avater'];?>" <?php
                            if(count($matche->mediafiles) == 1){
                                echo 'style="margin: 0 auto;display: block;"';
                            } else {
                                if($x === 0 ){
                                    echo 'style="display:block;float:left;"';
                                }else{
                                    echo 'style="display:block;"';
                                }
                            }?>>
                        </a>
					<?php }$x++;} ?>
                    <script>
                    $('a[rel="group-<?php echo $uname;?>"]').fancybox({
                        'transitionIn'      : 'none',
                        'transitionOut'     : 'none',
                        'titlePosition'     : 'over',
                        'cyclic'            : true,
                        'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
                            return '<span id="fancybox-title-over">Image ' +  (currentIndex + 1) + ' / ' + currentArray.length + ' ' + title + '</span>';
                        }
                    });
                    </script>
				<?php }else{ ?>
                <div class="carousel carousel-slider center match_usr_img_slidr">
                    <?php if(count($matche->mediafiles) > 1){?>
                        <span class="changer back" onclick="Previous_Picture();"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15.41,16.58L10.83,12L15.41,7.41L14,6L8,12L14,18L15.41,16.58Z" /></svg></span>
                        <span class="changer next" onclick="Next_Picture();"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M8.59,16.58L13.17,12L8.59,7.41L10,6L16,12L10,18L8.59,16.58Z" /></svg></span>
                    <?php }else{
                        echo '<div class="carousel-item"><img alt="'.$matche->username.'" src="'. GetMedia('',false) . $matche->avater.'"></div>';
                    }?>

                    <?php foreach ($matche->mediafiles as $key => $mfile){?>
                        <div class="carousel-item">
                            <img alt="<?php echo $matche->username;?>" src="<?php echo $mfile['avater'];?>">
                        </div>
                    <?php } ?>
                </div>
				<?php }?>
                <?php if( $mode == 'hot' ){?>
                    <div class="mtc_usrd_actions">
						<a href="<?php echo $site_url;?>" class="btn waves-effect dislike">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z"></path></svg>
                        </a>
                        <button href="javascript:void(0);" data-userid="<?php echo $matche->id;?>" id="matches_like_btn" data-ajax-post="/useractions/hot" data-source="hot" data-ajax-params="userid=<?php echo $matche->id;?>&username=<?php echo $matche->username;?>&source=hot" data-ajax-callback="callback_hot" class="btn waves-effect like hot">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M17.55,11.2C17.32,10.9 17.05,10.64 16.79,10.38C16.14,9.78 15.39,9.35 14.76,8.72C13.3,7.26 13,4.85 13.91,3C13,3.23 12.16,3.75 11.46,4.32C8.92,6.4 7.92,10.07 9.12,13.22C9.16,13.32 9.2,13.42 9.2,13.55C9.2,13.77 9.05,13.97 8.85,14.05C8.63,14.15 8.39,14.09 8.21,13.93C8.15,13.88 8.11,13.83 8.06,13.76C6.96,12.33 6.78,10.28 7.53,8.64C5.89,10 5,12.3 5.14,14.47C5.18,14.97 5.24,15.47 5.41,15.97C5.55,16.57 5.81,17.17 6.13,17.7C7.17,19.43 9,20.67 10.97,20.92C13.07,21.19 15.32,20.8 16.93,19.32C18.73,17.66 19.38,15 18.43,12.72L18.3,12.46C18.1,12 17.83,11.59 17.5,11.21L17.55,11.2M14.45,17.5C14.17,17.74 13.72,18 13.37,18.1C12.27,18.5 11.17,17.94 10.5,17.28C11.69,17 12.39,16.12 12.59,15.23C12.76,14.43 12.45,13.77 12.32,13C12.2,12.26 12.22,11.63 12.5,10.94C12.67,11.32 12.87,11.7 13.1,12C13.86,13 15.05,13.44 15.3,14.8C15.34,14.94 15.36,15.08 15.36,15.23C15.39,16.05 15.04,16.95 14.44,17.5H14.45Z"></path></svg>
                        </button>
                        <button href="javascript:void(0);" data-userid="<?php echo $matche->id;?>" id="matches_dislike_btn" data-ajax-post="/useractions/not" data-source="hot" data-ajax-params="userid=<?php echo $matche->id;?>&username=<?php echo $matche->username;?>&source=hot" data-ajax-callback="callback_not" class="btn waves-effect dislike hot">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M19,15H23V3H19M15,3H6C5.17,3 4.46,3.5 4.16,4.22L1.14,11.27C1.05,11.5 1,11.74 1,12V14A2,2 0 0,0 3,16H9.31L8.36,20.57C8.34,20.67 8.33,20.77 8.33,20.88C8.33,21.3 8.5,21.67 8.77,21.94L9.83,23L16.41,16.41C16.78,16.05 17,15.55 17,15V5C17,3.89 16.1,3 15,3Z"></path></svg>
                        </button>
                    </div>
                <?php }else{ ?>
                    <div class="mtc_usrd_actions">
                        <button href="javascript:void(0);" data-userid="<?php echo $matche->id;?>" id="matches_like_btn" data-ajax-post="/useractions/like" data-ajax-params="userid=<?php echo $matche->id;?>&username=<?php echo $matche->username;?>&source=find-matches" data-ajax-callback="callback_like" class="btn waves-effect like"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z"></path></svg></button>
                        <button href="javascript:void(0);" data-userid="<?php echo $matche->id;?>" id="matches_dislike_btn" data-ajax-post="/useractions/dislike" data-source="find-matches" data-ajax-params="userid=<?php echo $matche->id;?>&username=<?php echo $matche->username;?>&source=find-matches" data-ajax-callback="callback_dislike" class="btn waves-effect dislike"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"></path></svg></button>
                    </div>
                <?php }?>
            </div>
        </div>
		<?php if( $mode == 'hot' ){?>
		<?php }else{ ?>
        <div class="col s12 m5">
            <div class="mtc_usrd_sidebar">
                <div class="sidebar_usr_info">
                    <h5><?php echo __('About');?> <?php echo ($matche->first_name !== '' ) ? $matche->first_name . ' ' . $matche->last_name : $matche->username;?></h5>
                    <?php if($matche->language){?>
                        <div>
                            <p class="info_title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12.87,15.07L10.33,12.56L10.36,12.53C12.1,10.59 13.34,8.36 14.07,6H17V4H10V2H8V4H1V6H12.17C11.5,7.92 10.44,9.75 9,11.35C8.07,10.32 7.3,9.19 6.69,8H4.69C5.42,9.63 6.42,11.17 7.67,12.56L2.58,17.58L4,19L9,14L12.11,17.11L12.87,15.07M18.5,10H16.5L12,22H14L15.12,19H19.87L21,22H23L18.5,10M15.88,17L17.5,12.67L19.12,17H15.88Z"></path></svg> <?php echo __('Preferred Language');?></p>
                            <span><?php echo __($matche->language);?></span>
                        </div>
                    <?php }?>
                    <?php if($matche->relationship){?>
                        <div>
                            <p class="info_title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7.5,2A2,2 0 0,1 9.5,4A2,2 0 0,1 7.5,6A2,2 0 0,1 5.5,4A2,2 0 0,1 7.5,2M6,7H9A2,2 0 0,1 11,9V14.5H9.5V22H5.5V14.5H4V9A2,2 0 0,1 6,7M16.5,2A2,2 0 0,1 18.5,4A2,2 0 0,1 16.5,6A2,2 0 0,1 14.5,4A2,2 0 0,1 16.5,2M15,22V16H12L14.59,8.41C14.84,7.59 15.6,7 16.5,7C17.4,7 18.16,7.59 18.41,8.41L21,16H18V22H15Z"></path></svg> <?php echo __('Relationship status');?></p>
                            <span><?php echo $matche->relationship;?></span>
                        </div>
                    <?php }?>
                    <?php if($matche->height){?>
                        <div>
                            <p class="info_title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M13,9V15H16L12,19L8,15H11V9H8L12,5L16,9H13M4,2H20V4H4V2M4,20H20V22H4V20Z"></path></svg> <?php echo __('Height');?></p>
                            <span><?php echo $matche->height;?></span>
                        </div>
                    <?php }?>
                    <?php if($matche->body){?>
                        <div>
                            <p class="info_title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,1C10.89,1 10,1.9 10,3C10,4.11 10.89,5 12,5C13.11,5 14,4.11 14,3A2,2 0 0,0 12,1M10,6C9.73,6 9.5,6.11 9.31,6.28H9.3L4,11.59L5.42,13L9,9.41V22H11V15H13V22H15V9.41L18.58,13L20,11.59L14.7,6.28C14.5,6.11 14.27,6 14,6"></path></svg> <?php echo __('Body Type');?></p>
                            <span><?php echo $matche->body;?></span>
                        </div>
                    <?php }?>
                    <?php if($matche->smoke){?>
                        <div>
                            <p class="info_title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M2,16H17V19H2V16M20.5,16H22V19H20.5V16M18,16H19.5V19H18V16M18.85,7.73C19.47,7.12 19.85,6.28 19.85,5.35C19.85,3.5 18.35,2 16.5,2V3.5C17.5,3.5 18.35,4.33 18.35,5.35C18.35,6.37 17.5,7.2 16.5,7.2V8.7C18.74,8.7 20.5,10.53 20.5,12.77V15H22V12.76C22,10.54 20.72,8.62 18.85,7.73M16.03,10.2H14.5C13.5,10.2 12.65,9.22 12.65,8.2C12.65,7.18 13.5,6.45 14.5,6.45V4.95C12.65,4.95 11.15,6.45 11.15,8.3A3.35,3.35 0 0,0 14.5,11.65H16.03C17.08,11.65 18,12.39 18,13.7V15H19.5V13.36C19.5,11.55 17.9,10.2 16.03,10.2Z"></path></svg> <?php echo __('Smoke');?></p>
                            <span><?php echo $matche->smoke;?></span>
                        </div>
                    <?php }?>
                    <?php if($matche->ethnicity){?>
                        <div>
                            <p class="info_title"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5,9.5L7.5,14H2.5L5,9.5M3,4H7V8H3V4M5,20A2,2 0 0,0 7,18A2,2 0 0,0 5,16A2,2 0 0,0 3,18A2,2 0 0,0 5,20M9,5V7H21V5H9M9,19H21V17H9V19M9,13H21V11H9V13Z"></path></svg> <?php echo __('Ethnicity');?></p>
                            <span><?php echo $matche->ethnicity;?></span>
                        </div>
                    <?php }?>
                </div>
                <div class="vew_profile">
                    <a href="<?php echo $site_url;?>/@<?php echo $matche->username;?>" data-ajax="/@<?php echo $matche->username;?>" class="btn waves-effect"><?php echo __( 'View Profile' );?></a>
                </div>
            </div>
        </div>
		<?php }?>
    </div>
</div>
