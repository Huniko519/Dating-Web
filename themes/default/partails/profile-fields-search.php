<?php $fid = '';
if( isset( $_GET[ $field['fid'] ] ) && !empty( $_GET[ $field['fid'] ] ) ){
    $fid = Secure( $_GET[ $field['fid'] ] );
}
?>
<div class="col s12 m3">
    <h5><?php echo $field['description'];?></h5>
    <div class="input-field">
    <?php
    if ($field['select_type'] == 'yes') {
        $options = @explode(',', $field['type']); ?>
        <select name="<?php echo $field['fid'];?>" class="form-control profile_custom_data_field" data-name="<?php echo $field['fid'];?>">
            <option value=""><?php echo $field['description'];?></option>
            <?php
            foreach ($options as $key => $value) {
                $selected = (($key + 1) == $fid) ? 'selected' : '';
                ?>
                <option value="<?php echo $key + 1;?>" <?php echo $selected;?>><?php echo $value;?></option>
            <?php } ?>
        </select>
        <?php
    } else {
        if ($field['type'] == 'textbox' || $field['type'] == 'textarea') { ?>
            <input id="<?php echo $field['fid'];?>" name="<?php echo $field['fid'];?>" type="text" class="form-control profile_custom_data_field input-md" data-name="<?php echo $field['fid'];?>" value="<?php echo $fid?>" placeholder="<?php echo $field['name']; ?>">
         <?php } } ?>
    </div>
</div>