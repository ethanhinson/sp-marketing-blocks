<?php

/*--------------------------------------------*
 * Custom Post Types
 *--------------------------------------------*/

$post_types = array();

$post_types['sp_marketing_blocks'] = array(
                                        'label' => 'Marketing Blocks',
                                        'description' => 'Blocks which can be called with a shortcode or template tag.',
                                        'public' => true,
                                        'show_ui' => true,
                                        'show_in_menu' => true,
                                        'capability_type' => 'post',
                                        'hierarchical' => false,
                                        'rewrite' => array('slug' => ''),
                                        'query_var' => true,
                                        'exclude_from_search' => true,
                                        'supports' => array('title','excerpt','revisions','thumbnail',),
                                        'labels' => array (
                                                    'name' => 'Marketing Blocks',
                                                    'singular_name' => 'Marketing Block',
                                                    'menu_name' => 'Marketing Blocks',
                                                    'add_new' => 'Add New',
                                                    'add_new_item' => 'Add New Block',
                                                    'edit' => 'Edit',
                                                    'edit_item' => 'Edit Block',
                                                    'new_item' => 'New Block',
                                                    'view' => 'View Marketing Block',
                                                    'view_item' => 'View Marketing Block',
                                                    'search_items' => 'Search Marketing Blocks',
                                                    'not_found' => 'No Marketing Blocks Found',
                                                    'not_found_in_trash' => 'No Marketing Blocks Found in Trash',
                                                    'parent' => 'Parent Marketing Block',
                                                  ),
                                       );

?>
