<?php
$dir = str_replace('admin-panel', '', dirname(__FILE__));
require_once($dir . '/bootstrap.php');
include 'function.php';

header("Location: " . Wo_LoadAdminLinkSettings(''));
exit();