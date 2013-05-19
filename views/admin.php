 <!-- 
 // The actual fields for data entry
 // Use get_post_meta to retrieve an existing value from the database and use the value for the form
 -->
 <?php foreach($variables['fields'] as $label => $field): ?>
 <div class="block-configuration-form-element">
 <?php $value = ( get_post_meta( $variables['post']->ID, $field['name'], true ) ? get_post_meta( $variables['post']->ID, $field['name'], true ) : '' ); ?>
    <label for="<?php print $field['name']; ?>">
        <h4> <?php _e( ucwords( $label ), 'sp_marketing_blocks' ); ?> </h4>
    </label>
    <input type="<?php print $field['type'] ?>" id="<?php print $field['name'] ?>" name="fields[<?php print $field['name'] ?>]" value="<?php print $value ?>" size="<?php print $field['size']; ?>" />
    <p>
       <small> <?php _e( $field['description'], 'sp_marketing_blocks' ); ?> </small>      
    </p>
 </div>
  <?php endforeach; ?>
  <?php wp_nonce_field( 'save_data', 'sp_marketing_blocks_data' ); ?>