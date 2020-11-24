<?php
global $db;
$payments = $db->objectbuilder()->where('user_id',$profile->id)->orderBy('id', 'DESC')->get('payments');
?>
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
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15,14V11H18V9L22,12.5L18,16V14H15M14,7.7V9H2V7.7L8,4L14,7.7M7,10H9V15H7V10M3,10H5V15H3V10M13,10V12.5L11,14.3V10H13M9.1,16L8.5,16.5L10.2,18H2V16H9.1M17,15V18H14V20L10,16.5L14,13V15H17Z" /></svg>
        </div>
        <div class="sett_navbar valign-wrapper">
            <ul class="tabs">
                <li class="tab col s3"><a class="active" href="javascript:void(0);"><?php echo __( 'Transactions' );?></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="dt_settings row">
        <div class="col s12 m2"></div>
		<form class="col s12 m8">
        <?php
            if( empty( $payments ) ){
				echo '<h5 class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M0.93,4.2L2.21,2.93L20,20.72L18.73,22L16.73,20H4C2.89,20 2,19.1 2,18V6C2,5.78 2.04,5.57 2.11,5.38L0.93,4.2M20,8V6H7.82L5.82,4H20A2,2 0 0,1 22,6V18C22,18.6 21.74,19.13 21.32,19.5L19.82,18H20V12H13.82L9.82,8H20M4,8H4.73L4,7.27V8M4,12V18H14.73L8.73,12H4Z" /></svg>' . __( 'No transactions found.' ) . '</h5>';
            }else{
        ?>
        <table class="highlight responsive-table">
            <thead>
            <tr>
                <th><?php echo __('Date');?></th>
                <th><?php echo __('Processed By');?></th>
                <th><?php echo __('Amount');?></th>
                <th><?php echo __('Type');?></th>
                <th><?php echo __('Notes');?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($payments as $paymentlist) {
                echo '<tr>';
                echo '  <td>'.$paymentlist->date.'</td>';
                echo '  <td>'.$paymentlist->via.'</td>';
                echo '  <td>'.$config->currency_symbol . $paymentlist->amount.'</td>';
                echo '  <td>'.$paymentlist->type.'</td>';
                echo '  <td>';
                if( $paymentlist->pro_plan > 0 ){
                    if( $paymentlist->pro_plan == 1 ){
                        echo __('WEEKLY');
                    }
                    if( $paymentlist->pro_plan == 2 ){
                        echo __('MONTHLY');
                    }
                    if( $paymentlist->pro_plan == 3 ){
                        echo __('YEARLY');
                    }
                    if( $paymentlist->pro_plan == 4 ){
                        echo __('LIFETIME');
                    }
                }
                if($paymentlist->credit_amount > 0 ){
                    echo $paymentlist->credit_amount .' ' . __(' Credits');
                }
                echo '  </td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
        <?php } ?>
		</form>
        <div class="col s12 m2"></div>
    </div>
</div>