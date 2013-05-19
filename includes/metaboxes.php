<?php

/*--------------------------------------------*
 * Meta boxes
 *--------------------------------------------*/

//overall metaboxes array - we'll add arrays to this to pass to add_meta_box
$meta_boxes = array();
//Init an array to start some callback args for field rendering
$sp_marketing_block_fields = array();
//Extra arguments for the sp_marketing_block metabox
$sp_marketing_block_fields['fields'] = array(
                                'link' => array(
                                                'type' => 'text',
                                                'default_value' => get_bloginfo( 'url' ),
                                                'name' => 'sp_marketing_block_link',
                                                'label' => 'Link Address',
                                                'size' => '35',
                                                'description' => 'A web address which this marketing block will link to.'
                                            ),
                                'weight' => array(
                                                'type' => 'text',
                                                'default_value' => '0',
                                                'name' => 'sp_marketing_block_weight',
                                                'label' => 'Order',
                                                'size' => '2',
                                                'description' => 'Marketing blocks will appear in ascending order.'
                                            )
                            );
//Add a box to the meta_boxes array
$meta_boxes['sp_marketing_block'] = array(
                                        'id' => 'sp-marketing-block-data',
                                        'title' => 'Block Configuration',
                                        'callback' => array( &$this, 'render_box' ),
                                        'post_type' => 'sp_marketing_blocks',
                                        'context' => 'normal',
                                        'priority' => 'low',
                                        'callback_args' => array( 
                                                                  'path' => 'views/admin.php', 
                                                                  'variables' => $sp_marketing_block_fields
                                                                )
                                    );


?>
