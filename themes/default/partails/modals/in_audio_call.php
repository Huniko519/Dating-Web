<div class="modal fade" id="re-calling-modal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content dt_call_rec_ing">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo __('New audio call');?></h4>
            </div>
            <div class="modal-body">
                <div class="dt_call_rec_ing_detal">
                    <img src="<?php echo $wo['incall']['in_call_user']->avater->avater;?>" alt="" class="hidden-mobile-image">
                    <b><?php echo $wo['incall']['in_call_user']->fullname;?></b><p><?php echo __('wants to talk with you.');?></p>
                </div>
                <div class="clear"></div>
            </div>
			<div class="modal-footer">
                <button data-href="<?php echo $wo['incall']['url'];?>" type="button" class="btn btn-flat green darken-1 btn-white waves-effect answer-call" onclick="Wo_AnswerCall('<?php echo $wo['incall']['id'];?>', '<?php echo $wo['incall']['url'];?>', 'audio');" title="<?php echo __('Accept & Start');?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z" /></svg></button>
                <button type="button" class="btn btn-flat red darken-1 waves-effect decline-call" onclick="Wo_DeclineCall('<?php echo $wo['incall']['id'];?>', '', 'audio');" title="<?php echo __('Decline');?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12,9C10.4,9 8.85,9.25 7.4,9.72V12.82C7.4,13.22 7.17,13.56 6.84,13.72C5.86,14.21 4.97,14.84 4.17,15.57C4,15.75 3.75,15.86 3.5,15.86C3.2,15.86 2.95,15.74 2.77,15.56L0.29,13.08C0.11,12.9 0,12.65 0,12.38C0,12.1 0.11,11.85 0.29,11.67C3.34,8.77 7.46,7 12,7C16.54,7 20.66,8.77 23.71,11.67C23.89,11.85 24,12.1 24,12.38C24,12.65 23.89,12.9 23.71,13.08L21.23,15.56C21.05,15.74 20.8,15.86 20.5,15.86C20.25,15.86 20,15.75 19.82,15.57C19.03,14.84 18.14,14.21 17.16,13.72C16.83,13.56 16.6,13.22 16.6,12.82V9.72C15.15,9.25 13.6,9 12,9Z" /></svg></button>
            </div>
        </div>
    </div>
</div>
