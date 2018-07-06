$( function() {
    $( ".--offer-request-form-drop" ).on( "click", function() {
        offer_request_element_id = this.id.split( "-" );
        offer_request_form_id = "#offer-request-form-" + offer_request_element_id[ 2 ];
        $( offer_request_form_id ).slideToggle( );
    } );

    $( ".--schedule-request-form-drop" ).on( "click", function() {
        schedule_request_element_id = this.id.split( "-" );
        schedule_request_form_id = "#schedule-request-form-" + schedule_request_element_id[ 2 ];
        $( schedule_request_form_id ).slideToggle( );
    } );
} );
