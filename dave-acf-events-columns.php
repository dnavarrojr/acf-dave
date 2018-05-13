<?php

/* Modify the data in a column created with the Admin Columns plugin */

/*---------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Change Enter Title hint on CPT edit */

function dave_acf_events_columns( $value, $id, $column ) {
	
    if ( $column instanceof ACA_ACF_Column ) {
        $meta_key    = $column->get_meta_key(); // This gets the Custom Field key
        $column_name = $column->get_name();
        if ( $column_name == '5af3b49fcea61' ) {
            $event_type = get_field('event_type', $id );
            if ( $event_type == 'multi' ) {
                $dates = get_field('event_select_dates', $id);
                $value = '';
                foreach ( $dates as $date ) {
                    $value .= date( 'm/d/Y', strtotime( $date['event_start_date'] ) ) . ', ';
                }
                $value = trim( $value, ', ' );
            }
        }
    }
    
    return $value;
}
add_filter( 'ac/column/value', 'dave_acf_events_columns', 10, 3 );
