<?php

/*---------------------------------------------------------------------------------------------------------------------------------------------------*/

function acf_dave_metaboxes() {
    add_meta_box( 'acf_dave_debug', 'ACF Debug Info', 'acf_dave_debug_box', 'events', 'side', 'low' );
}
add_action( 'add_meta_boxes', 'acf_dave_metaboxes' );

/*---------------------------------------------------------------------------------------------------------------------------------------------------*/

function acf_dave_debug_box( $post ) {
    echo 'Post ID: ' . $post->ID . '<br />';
    echo 'Date Type: <span id="date-type"></span><br />';
    echo '<select id="event-date-select" style="margin-bottom: 6px;"></select>';
    echo '<div id="event-list" style="overflow: hidden;"></div>';
}

/*---------------------------------------------------------------------------------------------------------------------------------------------------*/

add_action( 'admin_footer', 'acf_dave_debug_js', 100 );

function acf_dave_debug_js() {

  if ( get_post_type() != 'events' )
    return;

?>
    <script type="text/javascript">
        // Update the Debug DIV
        function acfDaveUpdateDiv() {
            var eventType = jQuery("#event-type select").val();
            var eventDate = jQuery("#event-date-select").val();
            jQuery("#date-type").text( eventType );
            if ( eventDate == null || eventDate.length == 0 ) { return; }
            
            jQuery.getJSON( uri, function( data ) {
                var result = data.result;
                var html = "";
                jQuery.each( result, function( i, e ) {
                    html += "<li><strong>" + e.event_title + "</strong><br />" + e.event_time_disp + " | " + e.event_location + "</li>";
                });
                jQuery("#event-list").html( html );
            });
        }

        // Update the debug date SELECT
        function acfDebugUpdateSelect() {
            var eventType = jQuery("#event-type select").val();
            if ( eventType == "single" ) {
                var eventDateText = jQuery("#event_single_date input.hasDatepicker").val();
                var eventDate = jQuery("#event_single_date .input-alt").val();
                jQuery("#event-date-select").html( jQuery("<option>", { value: eventDate, text: eventDateText } ) );
            } else if ( eventType == "multi" ) {
                jQuery("#ems-date").html("");
                jQuery("#event_multi_date .acf-input .acf-date-picker").each( function(i) {
                    var eventDate = jQuery(this).children(".input-alt").val();
                    var eventDateText = jQuery(this).children("input.hasDatepicker").val();
                    if ( eventDate.length ) {
                        jQuery("#event-date-select").append( jQuery("<option>", { value: eventDate, text: eventDateText } ));
                    }
                });
            }
            acfDaveUpdateDiv();
        }

        // JS document ready for ACF Dave
        jQuery( document ).ready( function() {
            acfDebugUpdateSelect();

            jQuery("#event-date-select").change( acfDaveUpdateDiv );
            
            jQuery("#event-type select").select( acfDebugUpdateSelect );

            jQuery("#event_single_date input.hasDatepicker").on( "propertychange change paste", acfDebugUpdateSelect );

            jQuery("#event_multi_date input.hasDatepicker").each( function(i) {
                jQuery( this ).on( "propertychange change paste", acfDebugUpdateSelect );
            });
        });
    </script>
<?php
}
