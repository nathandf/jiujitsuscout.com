$( function() {
    $( ".--task-drop" ).on( "click", function() {
        task_drop_element_id = this.id.split( "-" );
        task_drop_form_id = "#task-drop-form-" + task_drop_element_id[ 2 ];
        $( task_drop_form_id ).slideToggle( );
    } );

    $( ".--task-complete" ).on( "click", function() {
        task_complete_element_id = this.id.split( "-" );
        task_complete_form_id = "#task-complete-form-" + task_complete_element_id[ 2 ];
        task_drop_form_id = "#task-drop-form-" + task_complete_element_id[ 2 ];
        $( task_complete_form_id ).hide( 500 );
        $( task_drop_form_id ).hide( 500 );
    } );
} );
