$( function() {

	var html_tags = {
		"bold": {
			"tag": "b"
		},
		"italic": {
			"tag": "i"
		},
		"underline": {
			"tag": "u"
		},
		"header2": {
			"tag": "h2"
		},
		"header3": {
			"tag": "h3"
		},
		"anchor": {
			"tag": "a"
		},
		"image": {
			"tag": "img"
		}
	};

	var selection = null;

	$( '#input_meta_title' ).on( "keyup", function() {
	    $( "#charCountTitle" ).text( this.value.length );
		if ( this.value.length < 42 ) {
			$( "#charCountTitle" ).css( "color", "red" );
		} else if ( this.value.length >= 42 && this.value.length <= 70 ) {
			$( "#charCountTitle" ).css( "color", "green" );
		} else {
			$( "#charCountTitle" ).css( "color", "red" );
		}
	});

	$( '#input_meta_description' ).on( "keyup", function() {
	    $( "#charCountDescription" ).text( this.value.length );
		if ( this.value.length < 120 ) {
			$( "#charCountDescription" ).css( "color", "red" );
		} else if ( this.value.length >= 120 && this.value.length <= 158 ) {
			$( "#charCountDescription" ).css( "color", "green" );
		} else {
			$( "#charCountDescription" ).css( "color", "red" );
		}
	});

	// Get and display word count of article
	counterBody = function() {
	    var valueBody = $('#article-body').val();

	    if (valueBody.length == 0) {
	        $('#wordCountBody').html(0);
	        $('#totalCharsBody').html(0);
	        $('#charCountBody').html(0);
	        $('#charCountNoSpaceBody').html(0);
	        return;
	    }

	    var regexBody = /\s+/gi;
	    var wordCountBody = valueBody.trim().replace(regexBody, ' ').split(' ').length;
	    var totalCharsBody = valueBody.length;
	    var charCountBody = valueBody.trim().length;
	    var charCountNoSpaceBody = valueBody.replace(regexBody, '').length;

	    $('#wordCountBody').html(wordCountBody);
	    $('#totalCharsBody').html(totalCharsBody);
	    $('#charCountBody').html(charCountBody);
	    $('#charCountNoSpaceBody').html(charCountNoSpaceBody);
	};

	$(document).ready(function() {
	    $('#countBody').click(counterBody);
	    $('#article-body').change(counterBody);
	    $('#article-body').keydown(counterBody);
	    $('#article-body').keypress(counterBody);
	    $('#article-body').keyup(counterBody);
	    $('#article-body').blur(counterBody);
	    $('#article-body').focus(counterBody);
	});

	function getSelectionText() {
		var text = "";
		var activeEl = document.activeElement;
		var activeElTagName = activeEl ? activeEl.tagName.toLowerCase() : null;
		if (
			(activeElTagName == "textarea") || (activeElTagName == "input" &&
			/^(?:text|search|password|tel|url)$/i.test(activeEl.type)) &&
			(typeof activeEl.selectionStart == "number")
		) {
			text = activeEl.value.slice(activeEl.selectionStart, activeEl.selectionEnd);
		} else if (window.getSelection) {
			text = window.getSelection().toString();
		}

		return text;
	}

	function addTags( tag, selection ) {
		var modified_selection = selection;
		switch ( tag ) {
			case "b":
			case "i":
			case "u":
				modified_selection = "<" + tag + ">" + selection + "</" + tag + ">";
				break;
			case "h1":
			case "h2":
			case "h3":
				modified_selection = "</p><" + tag + ">" + selection + "</" + tag + "><p>";
				break;
			case "a":
				modified_selection = "<" + tag + " href=\"\">" + selection + "</" + tag + ">";
				break;
			case "img":
				modified_selection = "<" + tag + " src=\"\"/>";
				break;
		}
		return modified_selection;
	}

	meta_title = $( "#input_meta_title" ).val();
	meta_description = $( "#input_meta_description" ).val();
	slug = $( "#input_slug" ).val();

	$( "#input_title" ).keyup( function() {
		if ( $( "#sluglock" ).prop( "checked" ) == false ) {
			$( "#input_slug" ).val( $( this ).val().toLowerCase().split( " " ).join( "-" ) );
			$( "#slug" ).text( $( "#input_slug" ).val() );
		}
	});

	$( "#input_meta_title" ).on( "keyup", function() {
		input_meta_title = $( "#input_meta_title" ).val();
		$( "#meta_title" ).text( input_meta_title );
	});

	$( "#input_meta_description" ).on( "keyup", function() {
		input_meta_description = $( "#input_meta_description" ).val();
		$( "#meta_description" ).text( input_meta_description );
	});

	$( "#input_slug" ).on( "keyup", function() {
		$( "#slug" ).text( $( "#input_slug" ).val().toLowerCase() );
		$( "#input_slug" ).val( $( "#input_slug" ).val().toLowerCase() );
	});

	document.onmouseup = document.onkeyup = document.onselectionchange = function() {
		selection = getSelectionText();
	};

	$( "#bold, #italic, #underline, #header2, #header3" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( addTags( html_tags[ this.id ][ "tag" ], selection ) );
	} );

	// Insert Image Picker Widget
	$( ".insert-image-picker-image" ).on( "click", function () {
		$( "#article-body" ).replaceSelectedText( "<img src=\"" + this.dataset.src + "\" alt=\"" + $( this ).attr( "alt" ) + "\"/>" );
		$( "#insert-image-picker-modal" ).hide();
	} );

	$( "#choose-insert-image" ).on( "click", function () {
		$( "#insert-image-picker-modal" ).show();
	} );

	$( "#insert-image-picker-close" ).on( "click", function () {
		$( "#insert-image-picker-modal" ).hide();
	} );

	// Insert video Picker Widget
	$( ".insert-video-picker-video" ).on( "click", function () {
		$( "#article-body" ).replaceSelectedText(
			"<video style=\"display: block; margin: 0 auto; border: 2px solid #CCCCCC; max-width: 500px; width: 50%; min-width: 260px;\" controls><source src=\"" + this.dataset.src + "\" type=\"" + this.dataset.type + "\">Your browser does not support the video tag.</video>"
		);
		$( "#insert-video-picker-modal" ).hide();
	} );

	$( "#choose-insert-video" ).on( "click", function () {
		$( "#insert-video-picker-modal" ).show();
	} );

	$( "#insert-video-picker-close" ).on( "click", function () {
		$( "#insert-video-picker-modal" ).hide();
	} );

	$( "#anchor" ).on( "click", function () {
		$( "#anchor-widget" ).show();
		$( "#anchor-text" ).val( selection );
	} );

	$( "#close-anchor" ).on( "click", function () {
		$( "#anchor-widget" ).hide();
		$( "#href" ).val( "" );
		$( "#anchor-text" ).val( "" );
	} );

	$( "#link-button" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( "<a href=\"" + $( "#href" ).val() + "\">" + $( "#anchor-text" ).val() + "</a>");
		$( "#href" ).val( "" );
		$( "#anchor-text" ).val( "" );
		$( "#anchor-widget" ).hide();
	} );

	$( "#add-button" ).on( "click", function () {
		$( "#button-widget" ).show();
		$( "#button-text" ).val( selection );
	} );

	$( "#close-button" ).on( "click", function () {
		$( "#button-widget" ).hide();
		$( "#button-href" ).val( "" );
		$( "#button-text" ).val( "" );
	} );

	$( "#button-button" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( "<a class=\"button-link mat-hov cursor-pt\" href=\"" + $( "#button-href" ).val() + "\">" + $( "#button-text" ).val() + "</a>");
		$( "#button-href" ).val( "" );
		$( "#button-text" ).val( "" );
		$( "#button-widget" ).hide();
	} );

} );
