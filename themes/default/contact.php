<!-- Contact  -->
<style>
@media (max-width: 1024px){
.dt_slide_menu {
	display: none;
}
nav .header_user {
	display: block;
}
}
</style>
<div class="container dt_contact">
    <div class="row">
        <div class="col m12 l3"></div>
                <form method="POST" action="/shared/contact" class="col m12 l6">
					<h2 class="bold center"><?php echo __( 'Contact Us' );?></h2>
                    <div class="alert alert-danger" role="alert" style="display:none;"></div>
                    <div class="alert alert-success" role="alert" style="display:none;"></div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="first_name" name="first_name" value="" type="text" class="validate" autofocus>
                            <label for="first_name"><?php echo __( 'First Name' );?></label>
                        </div>
                        <div class="input-field col s6">
                            <input id="last_name" name="last_name" value="" type="text" class="validate">
                            <label for="last_name"><?php echo __( 'Last Name' );?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" name="email" type="email" value="" class="validate" required>
                            <label for="email"><?php echo __( 'Email' );?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="how_we_can_help" name="message" class="materialize-textarea"></textarea>
                            <label for="how_we_can_help"><?php echo __( 'How can we help?' );?></label>
                        </div>
                    </div>
                    <button class="btn btn-large waves-effect waves-light bold btn_primary btn_round" type="submit" name="action"><span><?php echo __( 'Send' );?></span> <svg viewBox="0 0 19 14" xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path fill="currentColor" d="M18.6 6.9v-.5l-6-6c-.3-.3-.9-.3-1.2 0-.3.3-.3.9 0 1.2l5 5H1c-.5 0-.9.4-.9.9s.4.8.9.8h14.4l-4 4.1c-.3.3-.3.9 0 1.2.2.2.4.2.6.2.2 0 .4-.1.6-.2l5.2-5.2h.2c.5 0 .8-.4.8-.8 0-.3 0-.5-.2-.7z"></path></svg></button>
                </form>
        <div class="col m12 l3"></div>
    </div>
</div>
<!-- End Contact  -->