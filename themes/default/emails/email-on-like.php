Hello <?php echo $full_name ?>,
<br><br>

<a href="<?php echo $config->uri . '/@' . $username;?>"><img src="<?php echo $userprofile;?>"><?php echo $username;?></a> Liked you.<br><br>

<br><br>
You can login your account now. by clicking <a href="<?php echo $config->uri . '/login';?>"> here</a>
<br>

Best Regards,<br>
<?php echo $config->site_name;?> Team.