<?php

/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Debug Metabox */

function dave_acf_metaboxes() {
    add_meta_box( 'dave_postmeta', 'ACF Postmeta Info', 'dave_metabox_postmeta_info', 'post_name', 'normal', 'low' );
}
add_action( 'add_meta_boxes', 'dave_acf_metaboxes' );

function dave_metabox_postmeta_info( $post ) {
    echo '<strong>$post->ID:</strong> ' . $post->ID . '<br />';
    echo '<strong>$post->post_type:</strong> ' . $post->post_type . '<br />';
    echo '<pre style="overflow: hidden;">get_fields = ' . print_r( get_fields( $post->ID ), true ) . '</pre>';
    echo '<hr />';
    echo '<pre style="overflow: hidden;">post_object = ' . print_r( $post, true ) . '</pre>';
}
