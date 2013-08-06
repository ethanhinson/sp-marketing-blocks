<!-- This file is used to markup the public facing aspect of the plugin. -->

<div class="marketing-block <?php print $variables->class; ?>">
    <div class="block-title">
        <h3>
            <a href="<?php print get_post_meta( $variables->ID, 'sp_marketing_block_link', true ); ?>">
                <?php print apply_filters( 'the_title', $variables->post_title ); ?>
            </a>
        </h3>
    </div>
    <div class="block-thumbnail">
        <a href="<?php print get_post_meta( $variables->ID, 'sp_marketing_block_link', true ); ?>">
            <?php print get_the_post_thumbnail( $variables->ID, 'marketing-block-thumb' ); ?>
        </a>
    </div>
    <div class="block-excerpt">
        <?php print apply_filters( 'the_excerpt', $variables->post_excerpt ); ?>
    </div>
</div>
