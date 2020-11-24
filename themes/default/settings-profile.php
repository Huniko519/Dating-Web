<?php
$admin_mode = false;
if( $profile->admin == '1' || CheckPermission($profile->permission, "manage-users") ){
    $admin_mode = true;
}

$target_user = route(2);
if($target_user !== ''){
    $_user = LoadEndPointResource('users');
    if( $_user ){
        if( $target_user !== '' ){
            $user = $_user->get_user_profile(Secure($target_user));
            if( !$user ){
                echo '<script>window.location = window.site_url;</script>';
                exit();
            }else{
                if( $user->admin == '1' ){
                    $admin_mode = true;
                }
            }
        }
    }
}else{
    $user = auth();
}
?>
<?php //$user = auth();?>
<style>
.dt_settings_header {margin-top: -3px;display: inline-block;}
@media (max-width: 1024px){
.dt_slide_menu {
	display: none;
}
nav .header_user {
	display: block;
}
}
</style>
<!-- Settings  -->
<div class="dt_settings_header bg_gradient">
	<div class="dt_settings_circle-1"></div>
	<div class="dt_settings_circle-2"></div>
	<div class="dt_settings_circle-3"></div>
    <div class="container">
        <div class="sett_active_svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,19.2C9.5,19.2 7.29,17.92 6,16C6.03,14 10,12.9 12,12.9C14,12.9 17.97,14 18,16C16.71,17.92 14.5,19.2 12,19.2M12,5A3,3 0 0,1 15,8A3,3 0 0,1 12,11A3,3 0 0,1 9,8A3,3 0 0,1 12,5M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z" /></svg>
        </div>
        <div class="sett_navbar valign-wrapper">
            <ul class="tabs">
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings/<?php echo $user->username;?>" data-ajax="/settings/<?php echo $user->username;?>" target="_self"><?php echo __( 'General' );?></a></li>
                <li class="tab col s3"><a class="active" href="<?php echo $site_url;?>/settings-profile/<?php echo $user->username;?>" data-ajax="/settings-profile/<?php echo $user->username;?>" target="_self"><?php echo __( 'Profile' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-privacy/<?php echo $user->username;?>" data-ajax="/settings-privacy/<?php echo $user->username;?>" target="_self"><?php echo __( 'Privacy' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-password/<?php echo $user->username;?>" data-ajax="/settings-password/<?php echo $user->username;?>" target="_self"><?php echo __( 'Password' );?></a></li>
                <?php if( $config->social_media_links == 'on' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-social/<?php echo $user->username;?>" data-ajax="/settings-social/<?php echo $user->username;?>" target="_self"><?php echo __( 'Social Links' );?></a></li><?php }?>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-blocked/<?php echo $user->username;?>" data-ajax="/settings-blocked/<?php echo $user->username;?>" target="_self"><?php echo __( 'Blocked Users' );?></a></li>
                <li class="tab col s3"><a href="<?php echo $site_url;?>/settings-sessions/<?php echo $user->username;?>" data-ajax="/settings-sessions/<?php echo $user->username;?>" target="_self"><?php echo __( 'Manage Sessions' );?></a></li>
                <?php if( $config->affiliate_system == '1' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-affiliate/<?php echo $user->username;?>" data-ajax="/settings-affiliate/<?php echo $user->username;?>" target="_self"><?php echo __( 'My affiliates' );?></a></li><?php } ?>
                <?php if( $config->two_factor == '1' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-twofactor/<?php echo $user->username;?>" data-ajax="/settings-twofactor/<?php echo $user->username;?>" target="_self"><?php echo __( 'Two-factor authentication' );?></a></li><?php } ?>
                <?php if( $config->emailNotification == '1' ){ ?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-email/<?php echo $user->username;?>" data-ajax="/settings-email/<?php echo $user->username;?>" target="_self"><?php echo __( 'Manage Notifications' );?></a></li><?php } ?>
                <?php if( $admin_mode == false && $config->deleteAccount == '1' ) {?><li class="tab col s3"><a href="<?php echo $site_url;?>/settings-delete/<?php echo $user->username;?>" data-ajax="/settings-delete/<?php echo $user->username;?>" target="_self"><?php echo __( 'Delete Account' );?></a></li><?php } ?>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="dt_settings row">
        <div class="col s12 m3"></div>
        <form method="POST" action="/profile/save_profile_setting" class="col s12 m6 profile">
		<div class="sett_prof_cont">
            <div class="alert alert-success" role="alert" style="display:none;"></div>
			<div class="alert alert-danger" role="alert" style="display:none;"></div>

            <div class="row">
                <div class="input-field col s12">
                    <textarea id="about" name="about" class="materialize-textarea" autofocus><?php echo $user->about;?></textarea>
                    <label for="about"><?php echo __( 'About Me' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 no_margin_top">
                    <div id="interest" class="chips interest_chips chips-placeholder"></div>
                    <input type="hidden" id="interest_entry_profile" name="interest" value="<?php echo $user->interest;?>">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="ulocation" name="location" type="text" class="validate" value="<?php echo $user->location;?>">
                    <label for="ulocation"><?php echo __( 'Location' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <select id="relationship" name="relationship">
                        <?php echo DatasetGetSelect( $user->relationship, "relationship",  __("Choose your Relationship status") );?>
                    </select>
                    <label for="relationship"><?php echo __( 'Relationship status' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <select id="language" name="language">
                        <?php echo DatasetGetSelect( $user->language, "language", __("Choose your Preferred Language") );?>
                    </select>
                    <label for="language"><?php echo __( 'Preferred Language' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <select id="work" name="work_status">
                        <?php echo DatasetGetSelect( $user->work_status, "work_status", __("Choose your Work status") );?>
                    </select>
                    <label for="work"><?php echo __( 'Work status' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <select id="education" name="education">
                        <?php echo DatasetGetSelect( $user->education, "education", __("Education Level") );?>
                    </select>
                    <label for="education"><?php echo __( 'Education Level' );?></label>
                </div>
            </div>
		</div>

        <?php
        $fields = GetProfileFields('profile');
        $custom_data = UserFieldsData($profile->id);
        $template = $theme_path . 'partails' . $_DS . 'profile-fields.php';
        $html = '';
        if (count($fields) > 0) {
            foreach ($fields as $key => $field) {
                ob_start();
                require($template);
                $html .= ob_get_contents();
                ob_end_clean();
            }
            echo '<div class="sett_prof_cont"><div class="row">' . $html . '</div></div>';
            echo '<input name="custom_fields" type="hidden" value="1">';
        }
        ?>


		<div class="sett_prof_cont">
            <!--Looks-->
            <h5><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" d="M9,11.75A1.25,1.25 0 0,0 7.75,13A1.25,1.25 0 0,0 9,14.25A1.25,1.25 0 0,0 10.25,13A1.25,1.25 0 0,0 9,11.75M15,11.75A1.25,1.25 0 0,0 13.75,13A1.25,1.25 0 0,0 15,14.25A1.25,1.25 0 0,0 16.25,13A1.25,1.25 0 0,0 15,11.75M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,20C7.59,20 4,16.41 4,12C4,11.71 4,11.42 4.05,11.14C6.41,10.09 8.28,8.16 9.26,5.77C11.07,8.33 14.05,10 17.42,10C18.2,10 18.95,9.91 19.67,9.74C19.88,10.45 20,11.21 20,12C20,16.41 16.41,20 12,20Z"></path></svg> <?php echo __('Looks');?></h5>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <select id="ethnicity" name="ethnicity">
                        <?php echo DatasetGetSelect( $user->ethnicity, "ethnicity", __("Ethnicity") );?>
                    </select>
                    <label for="ethnicity"><?php echo __( 'Ethnicity' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <select id="body" name="body">
                        <?php echo DatasetGetSelect( $user->body, "body", __("Body Type") );?>
                    </select>
                    <label for="body"><?php echo __( 'Body Type' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <select id="height" name="height">
                        <?php echo DatasetGetSelect( $user->height, "height", __("Height") );?>
                    </select>
                    <label for="height"><?php echo __( 'Height' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <select id="hair_color" name="hair_color">
                        <?php echo DatasetGetSelect( $user->hair_color, "hair_color", __("Choose your Hair Color") );?>
                    </select>
                    <label for="hair_color"><?php echo __( 'Hair Color' );?></label>
                </div>
            </div>
		</div>
		
		<div class="sett_prof_cont">
            <!--Personality-->
            <h5><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" d="M1.5,4V5.5C1.5,9.65 3.71,13.28 7,15.3V20H22V18C22,15.34 16.67,14 14,14C14,14 13.83,14 13.75,14C9,14 5,10 5,5.5V4M14,4A4,4 0 0,0 10,8A4,4 0 0,0 14,12A4,4 0 0,0 18,8A4,4 0 0,0 14,4Z"></path></svg> <?php echo __('Personality');?></h5>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <select id="character" name="character">
                        <?php echo DatasetGetSelect( $user->character, "character", __("Character") );?>
                    </select>
                    <label for="character"><?php echo __( 'Character' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <select id="children" name="children">
                        <?php echo DatasetGetSelect( $user->children, "children", __("Children") );?>
                    </select>
                    <label for="children"><?php echo __( 'Children' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <select id="friends" name="friends">
                        <?php echo DatasetGetSelect( $user->friends, "friends", __("Friends") );?>
                    </select>
                    <label for="friends"><?php echo __( 'Friends' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <select id="pets" name="pets">
                        <?php echo DatasetGetSelect( $user->pets, "pets", __("Pets") );?>
                    </select>
                    <label for="pets"><?php echo __( 'Pets' );?></label>
                </div>
            </div>
		</div>
		
		<div class="sett_prof_cont">
            <!--Lifestyle-->
            <h5><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" d="M15,18.54C17.13,18.21 19.5,18 22,18V22H5C5,21.35 8.2,19.86 13,18.9V12.4C12.16,12.65 11.45,13.21 11,13.95C10.39,12.93 9.27,12.25 8,12.25C6.73,12.25 5.61,12.93 5,13.95C5.03,10.37 8.5,7.43 13,7.04V7A1,1 0 0,1 14,6A1,1 0 0,1 15,7V7.04C19.5,7.43 22.96,10.37 23,13.95C22.39,12.93 21.27,12.25 20,12.25C18.73,12.25 17.61,12.93 17,13.95C16.55,13.21 15.84,12.65 15,12.39V18.54M7,2A5,5 0 0,1 2,7V2H7Z"></path></svg> <?php echo __('Lifestyle');?></h5>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <select id="live_with" name="live_with">
                        <?php echo DatasetGetSelect( $user->live_with, "live_with", __("Live with") );?>
                    </select>
                    <label for="live_with"><?php echo __( 'I live with' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <select id="car" name="car">
                        <?php echo DatasetGetSelect( $user->car, "car", __("Car") );?>
                    </select>
                    <label for="car"><?php echo __( 'Car' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <select id="religion" name="religion">
                        <?php echo DatasetGetSelect( $user->religion, "religion", __("Religion") );?>
                    </select>
                    <label for="religion"><?php echo __( 'Religion' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <select id="smoke" name="smoke">
                        <?php echo DatasetGetSelect( $user->smoke, "smoke", __("Smoke") );?>
                    </select>
                    <label for="smoke"><?php echo __( 'Smoke' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <select id="drink" name="drink">
                        <?php echo DatasetGetSelect( $user->drink, "drink", __("Drink") );?>
                    </select>
                    <label for="drink"><?php echo __( 'Drink' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <select id="travel" name="travel">
                        <?php echo DatasetGetSelect( $user->travel, "travel", __("Travel") );?>
                    </select>
                    <label for="travel"><?php echo __( 'Travel' );?></label>
                </div>
            </div>
		</div>
		
		<div class="sett_prof_cont">
            <!--Favourites-->
            <h5><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" d="M12.1,18.55L12,18.65L11.89,18.55C7.14,14.24 4,11.39 4,8.5C4,6.5 5.5,5 7.5,5C9.04,5 10.54,6 11.07,7.36H12.93C13.46,6 14.96,5 16.5,5C18.5,5 20,6.5 20,8.5C20,11.39 16.86,14.24 12.1,18.55M16.5,3C14.76,3 13.09,3.81 12,5.08C10.91,3.81 9.24,3 7.5,3C4.42,3 2,5.41 2,8.5C2,12.27 5.4,15.36 10.55,20.03L12,21.35L13.45,20.03C18.6,15.36 22,12.27 22,8.5C22,5.41 19.58,3 16.5,3Z"></path></svg> <?php echo __('Favourites');?></h5>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <input id="music" type="text" class="validate" name="music" value="<?php echo $user->music;?>">
                    <label for="music"><?php echo __( 'Music Genre' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <input id="dish" type="text" class="validate" name="dish" value="<?php echo $user->dish;?>">
                    <label for="dish"><?php echo __( 'Dish' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <input id="song" type="text" class="validate" name="song" value="<?php echo $user->song;?>">
                    <label for="song"><?php echo __( 'Song' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <input id="hobby" type="text" class="validate" name="hobby" value="<?php echo $user->hobby;?>">
                    <label for="hobby"><?php echo __( 'Hobby' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <input id="city" type="text" class="validate" name="city" value="<?php echo $user->city;?>">
                    <label for="city"><?php echo __( 'City' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <input id="sport" type="text" class="validate" name="sport" value="<?php echo $user->sport;?>">
                    <label for="sport"><?php echo __( 'Sport' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <input id="book" type="text" class="validate" name="book" value="<?php echo $user->book;?>">
                    <label for="book"><?php echo __( 'Book' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <input id="movie" type="text" class="validate" name="movie" value="<?php echo $user->movie;?>">
                    <label for="movie"><?php echo __( 'Movie' );?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 xs12">
                    <input id="colour" type="text" class="validate" name="colour" value="<?php echo $user->colour;?>">
                    <label for="colour"><?php echo __( 'Color' );?></label>
                </div>
                <div class="input-field col s6 xs12">
                    <input id="tv" type="text" class="validate" name="tv" value="<?php echo $user->tv;?>">
                    <label for="tv"><?php echo __( 'TV Show' );?></label>
                </div>
            </div>
            <div class="dt_sett_footer valign-wrapper">
                <button class="btn btn-large waves-effect waves-light bold btn_primary btn_round" type="submit" name="action"><span><?php echo __( 'Save' );?></span> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
            </div>
            <?php if( $admin_mode == true ){?>
                <input type="hidden" name="targetuid" value="<?php echo strrev( str_replace( '==', '', base64_encode($user->id) ) );?>">
            <?php }?>
		</div>
        </form>
        <div class="col s12 m3"></div>
    </div>
</div>
<!-- End Settings  -->
