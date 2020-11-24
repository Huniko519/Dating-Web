Hello <?php echo $first_name ?>,
<br><br>

Thank you for joining <?php echo $config->site_name;?>!<br><br>

Your temporary login credentials are: <br><br>
Username: <?php echo $username;?><br>
Password: <?php echo $password;?><br><br>

Please change your password as soon as possible to fully secure your account.
<br><br>
You can login your account now. by clicking <a href="<?php echo $config->uri . '/login';?>"> here</a>
<br>

Best Regards,<br>
<?php echo $config->site_name;?> Team.