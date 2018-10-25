$( function() {

	var html_tags = {
		"paragraph": {
			"tag": "p"
		},
		"bold": {
			"tag": "b"
		},
		"italic": {
			"tag": "i"
		},
		"underline": {
			"tag": "u"
		},
		"header": {
			"tag": "h2"
		}
	};

	var selection = null;

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

	$( "#paragraph" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( addTags( html_tags[ this.id ][ "tag" ], selection ) );
	} );

	$( "#bold" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( addTags( html_tags[ this.id ][ "tag" ], selection ) );
	} );

	$( "#italic" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( addTags( html_tags[ this.id ][ "tag" ], selection ) );
	} );

	$( "#underline" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( addTags( html_tags[ this.id ][ "tag" ], selection ) );
	} );

	$( "#header" ).on( "click", function() {
		$( "#article-body" ).replaceSelectedText( addTags( html_tags[ this.id ][ "tag" ], selection ) );
	} );

} );
