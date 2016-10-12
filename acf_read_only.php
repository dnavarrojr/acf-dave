add_action('acf/render_field_settings/type=text', 'add_readonly_and_disabled_to_text_field');

function add_readonly_and_disabled_to_text_field( $field ) {
  acf_render_field_setting( $field, array(
    'label'      => __('Read Only?','acf'),
    'instructions'  => '',
    'type'      => 'radio',
    'name'      => 'readonly',
    'choices'    => array(
      1        => __("Yes",'acf'),
      0        => __("No",'acf'),
    ),
    'layout'  =>  'horizontal',
  ));
  acf_render_field_setting( $field, array(
    'label'      => __('Disabled?','acf'),
    'instructions'  => '',
    'type'      => 'radio',
    'name'      => 'disabled',
    'choices'    => array(
      1        => __("Yes",'acf'),
      0        => __("No",'acf'),
    ),
    'layout'  =>  'horizontal',
  ));
}
