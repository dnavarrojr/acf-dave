//* Add required acf_form_head() function to head of page
function am_do_acf_form_head() {
	if ( !is_admin() )
    acf_form_head();
}
add_action( 'get_header', 'am_do_acf_form_head', 1 );

//* Add custom body class to the head
function acf_form_class( $classes ) {
	$classes[] = 'acf-form-front';
	return $classes;
}
add_filter( 'body_class', 'acf_form_class' );

//* ACF Form Short Code
function am_sc_acf_form( $attr ) {
  
  $cpt     = $attr['cpt'];
  $post_id = $_GET['postid'];
  $title   = ( $attr['title'] == 1 ) || ( $attr['title'] == 'y' ) || ( $attr['title'] == 'yes' );
  $content = ( $attr['content'] == 1 ) || ( $attr['content'] == 'y' ) || ( $attr['content'] == 'yes' );
  $submit  = 'submit';
  
  if ( empty( $post_id ) ) {
    $post_id = 'new_post';
  } else {
    $submit = 'update';
  }
  
  $options = array( 'id' => 'acf_form',
                    'post_id' => $post_id,
                    'label_placement' => 'left',
                    'instruction_placement' => 'field',
                    'new_post' => array( 'post_type' => $cpt, 'post_status' => 'publish'),
                    'submit_value' => $submit,
                    'updated_message' => __( 'Client Updated', 'acf' ),
                    'post_title' => $title,
                    'post_content' => $content,
                    'return' => '%post_url%',
                   );
  
  ob_start();
  acf_form( $options );
  $ret = ob_get_contents();
  ob_end_clean();
  
  return $ret;
  
}
add_shortcode( 'do_acf_form', 'am_sc_acf_form' );
