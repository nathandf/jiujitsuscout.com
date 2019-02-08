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

    $( ".task-submit" ).on( "click", function () {
        checked = $( ".assignee-checkbox:checked" ).length;
        if ( !checked ) {
            alert( "You must assign at least 1 user to this task" );
            return false;
        }
    } );

    $( ".reschedule-trigger" ).on( "click", function () {
        $( ".lightbox" ).hide();
        $( "#reschedule-modal" ).toggle();
    } );

    $( ".--no-prop" ).on( "click", function ( event ) {
        event.preventDefault();
    } );

    $( ".--new-task-modal-trigger" ).on( "click", function () {
        $( "#new-task-modal" ).toggle();
    } );

    $( ".remove-member" ).on( "click", function ( event ) {
        confirmation = confirm( "Are you sure you want to remove this member?" );
        if ( confirmation !== false ) {
            $( "#remove-member-id" ).val( this.dataset.id );
            $( "#remove-member-form" ).submit();
        }
    } );

    $( ".remove-prospect" ).on( "click", function () {
        confirmation = confirm( "Are you sure you want to remove this lead?" );
        if ( confirmation !== false ) {
            $( "#remove-prospect-id" ).val( this.dataset.id );
            $( "#remove-prospect-form" ).submit();
        }
    } );

    $( ".task-actions-modal-trigger" ).on( "click", function () {
        $( "#task-actions-modal" ).toggle();
    } );

    $( ".choose-prospect-trigger" ).on( "click", function () {
        $( ".lightbox" ).hide();
		$( "#choose-prospect-modal" ).show();
	} );

	$( ".choose-member-trigger" ).on( "click", function () {
        $( ".lightbox" ).hide();
		$( "#choose-member-modal" ).show();
	} );

	$( ".choose-prospect-tag" ).on( "click", function() {
		$( "#choose-prospect-id" ).val( this.dataset.id )
		$( "#choose-prospect-modal-form" ).submit();
    } );

	$( ".choose-member-tag" ).on( "click", function() {
		$( "#choose-member-id" ).val( this.dataset.id )
		$( "#choose-member-modal-form" ).submit();
    } );
} );
