<style>
nav{ display: none;}
footer {display:none !important;}
body { text-align: center; padding: 150px;overflow: hidden;}
body > #container {min-height: auto;height: 100%;}
h1 { font-size: 50px;}
h2 {font-size: 30px;}
article { width: 100%;max-width: 560px;margin: auto;height: 100%;display: flex;align-items: center;justify-content: center;flex-direction: column;}
article img {width: 200px;height: 200px;margin-bottom: 15px;}
a { color: #3d8cfa; text-decoration: none; }
a:hover { color: #333; text-decoration: none; }
p {font-size: 14px;margin: 0 0 5px;line-height: 20px;}
@media(max-width:990px){
body{padding: 10px;	height: 100vh; width: 100%;display: table;}
footer .footer-wrapper{display:none !important;}
.content-container {margin-top: 0px;vertical-align: middle;display: table-cell;}
}

.maintenance-style {position: absolute;background-repeat: no-repeat;background-size: 100%}
.maintenance-style.maintenance-style-top-left {width: 240px;height: 218px;top: -73px;left: -37px;background-image: url("<?php echo $theme_url;?>assets/img/maintenance-style-top-left.png")}
.maintenance-style.maintenance-style-middle-left {width: 90px;height: 53px;bottom: 36px;left: -45px;background-image: url("<?php echo $theme_url;?>assets/img/maintenance-style-middle-left.png")}
.maintenance-style.maintenance-style-middle-right {width: 141px;height: 140px;-webkit-transform: translateY(-50%);-moz-transform: translateY(-50%);-ms-transform: translateY(-50%);-o-transform: translateY(-50%);transform: translateY(-50%);top: 50%;right: -89px;background-image: url("<?php echo $theme_url;?>assets/img/maintenance-style-middle-right.png")}
.maintenance-style.maintenance-style-bottom-right {width: 264px;height: 83px;right: -13px;bottom: -40px;background-image: url("<?php echo $theme_url;?>assets/img/maintenance-style-bottom-right.png")}

@media (min-width: 768px) {
.maintenance-style.maintenance-style-top-left {width:480px;height: 435px;top: -146px;left: -74px}
.maintenance-style.maintenance-style-middle-left {width:180px;height: 106px;bottom: 72px;left: -90px}
.maintenance-style.maintenance-style-middle-right {width:282px;height: 280px;right: -178px}
.maintenance-style.maintenance-style-bottom-right {width:528px;height: 166px;right: -26px;bottom: -80px}
}

@media (max-width: 768px) {
.maintenance-style {display: none;}
body {overflow-y: auto;}
}
</style>

<div class="maintenance-style maintenance-style-top-left"></div>
<div class="maintenance-style maintenance-style-middle-left"></div>
<div class="maintenance-style maintenance-style-middle-right"></div>
<div class="maintenance-style maintenance-style-bottom-right"></div>

<article>
	<img src="<?php echo $theme_url;?>assets/img/maintenance.svg" alt="<?php echo __('We’ll be back soon!');?>">
    <h2><?php echo __('We’ll be back soon!');?></h2>
    <div>
        <p><?php echo __('Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. If you need help you can always');?> <a href="mailto:<?php echo $config->siteEmail; ?>"><?php echo __('contact us');?></a>, <?php echo __('otherwise we&rsquo;ll be back online shortly!');?></p>
        <p>&mdash; <?php echo $config->site_name;?></p>
    </div>
</article>