<?php $fid = '';
if (!empty($custom_data[$field['fid']])) {
    $fid = $custom_data[$field['fid']];
}
if( isset( $_GET[ $field['fid'] ] ) && !empty( $_GET[ $field['fid'] ] ) ){
    $fid = Secure( $_GET[ $field['fid'] ] );
}
?>
<div class="input-field col s6 xs12">
    <?php
    if ($field['select_type'] == 'yes') {
        $options = @explode(',', $field['type']); ?>
        <select name="<?php echo $field['fid'];?>" class="form-control">
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
        if ($field['type'] == 'textbox') { ?>
            <input id="<?php echo $field['fid'];?>" name="<?php echo $field['fid'];?>" type="text" class="form-control input-md" value="<?php echo $fid?>" placeholder="<?php echo $field['name']; ?>">
        <?php } else if ($field['type'] == 'textarea') {?>
            <textarea class="materialize-textarea" id="<?php echo $field['fid'];?>" name="<?php echo $field['fid'];?>" placeholder="<?php echo $field['name']; ?>"><?php echo br2nl($fid);?></textarea>
        <?php } } ?>
    <label for="<?php echo $field['name'];?>"><?php echo $field['description'];?></label>
</div>




