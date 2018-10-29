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
		return "<" + tag + ">" + selection + "</" + tag + ">";
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

	$( "#bold" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( addTags( html_tags[ this.id ][ "tag" ], selection ) );
	} );

	$( "#italic" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( addTags( html_tags[ this.id ][ "tag" ], selection ) );
	} );

	$( "#underline" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( addTags( html_tags[ this.id ][ "tag" ], selection ) );
	} );

	$( "#header2" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( "</p>" + addTags( html_tags[ this.id ][ "tag" ], selection ) + "<p>" );
	} );

	$( "#header3" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( "</p>" + addTags( html_tags[ this.id ][ "tag" ], selection ) + "<p>"  );
	} );

} );
