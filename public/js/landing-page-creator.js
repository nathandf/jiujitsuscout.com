$( function() {

  headline_initial = $( "#headline" ).text();
  text_a_initial = $( "#text_a" ).text();
  text_b_initial = $( "#text_b" ).text();
  text_c_initial = $( "#text_c" ).text();
  form_button_initial = $( ".form-button" ).val();
  text_form_initial = $( ".form-title" ).text();

  $( "#input_headline" ).val( headline_initial );
  $( "#input_text_a" ).val( text_a_initial );
  $( "#input_text_b" ).val( text_b_initial );
  $( "#input_text_c" ).val( text_c_initial );
  
  $( "#input_call_to_action_form" ).val( form_button_initial );
  $( "#input_text_form" ).val( text_form_initial );

  $( "#input_headline" ).on( "keyup", function() {
    input_headline = $( "#input_headline" ).val();
    $( "#headline" ).text( input_headline );
  });

  $( "#input_headline" ).on( "focus", function() {
    $( "html, body, .content" ).animate({
      scrollTop: ( $( "#headline" ).offset().top )
    }, 500 );
  });

  $( "#input_text_a" ).on( "keyup", function() {
    input_text_a = $( "#input_text_a" ).val();
    $( "#text_a" ).text( input_text_a );
  });

  $( "#input_text_a" ).on( "focus", function() {
    $( "html, body, .content" ).animate({
      scrollTop: ( $( "#text_a" ).offset().top )
    }, 500 );
  });

  $( "#input_text_b" ).on( "keyup", function() {
    input_text_b = $( "#input_text_b" ).val();
    $( "#text_b" ).text( input_text_b );
  });

  $( "#input_text_b" ).on( "click", function() {
    $( "html, body, .content" ).animate({
      scrollTop: ( $( "#text_b" ).offset().top )
    }, 500 );
  });

  $( "#input_text_c" ).on( "keyup", function() {
    input_text_c = $( "#input_text_c" ).val();
    $( "#text_c" ).text( input_text_c );
  });

  $( "#input_text_c" ).on( "focus", function() {
    $( "html, body, .content" ).animate({
      scrollTop: ( $( "#text_c" ).offset().top )
    }, 500 );
  });

  $( "#input_call_to_action" ).on( "keyup", function() {
    input_call_to_action = $( "#input_call_to_action" ).val();
    $( ".cta-button" ).html( input_call_to_action );
  });

  $( "#input_call_to_action" ).on( "focus", function() {
    $( "html, body, .content" ).animate({
      scrollTop: ( $( ".cta-button" ).offset().top )
    }, 500 );
  });

  $( "#input_text_form" ).on( "keyup", function() {
    input_text_form = $( "#input_text_form" ).val();
    $( ".form-title" ).text( input_text_form );
  });

  $( "#input_text_form" ).on( "focus", function() {
    $( "html, body, .content" ).animate({
      scrollTop: ( $( ".form-title" ).offset().top )
    }, 500 );
  });

  $( "#input_call_to_action_form" ).on( "keyup", function() {
    input_call_to_action_form = $( "#input_call_to_action_form" ).val();
    $( ".form-button" ).val( input_call_to_action_form );
  });

  $( "#input_call_to_action_form" ).on( "focus", function() {
    $( "html, body, .content" ).animate({
      scrollTop: ( $( ".form-button" ).offset().top )
    }, 500 );
  });

  $( "#upload_image_background" ).change( function () {
      //Check if a file has been selected or not
      if ( this.files && this.files[ 0 ] ) {
          //Check if the uploaded file is an Image file
          if ( this.files[ 0 ].type.startsWith( "image/" ) ) {
              var reader = new FileReader();
              reader.readAsDataURL( this.files[ 0 ] );
              reader.onloadend = function () {
                $( "#image_background_creator" ).attr( "src", reader.result );
                $( "#image_background" ).attr( "src", reader.result );
                image = "url(\"" + reader.result + "\");";
                $( "#cover" ).css( "background-image", image );
              }
          } else {
              //If an image is not selected then show an other image.
              $( "#image_background" ).attr
              ( "src", "http://placehold.it/550x270&text=No+PreView!" );
          }
      }
  });

  $( "#upload_image_a" ).change( function () {
      //Check if a file has been selected or not
      if ( this.files && this.files[ 0 ] ) {
          //Check if the uploaded file is an Image file
          if ( this.files[ 0 ].type.startsWith( "image/" ) ) {
              var reader = new FileReader();
              reader.readAsDataURL( this.files[ 0 ] );
              reader.onloadend = function () {
                $( "#image_a_creator" ).attr( "src", reader.result );
                $( "#image_a" ).attr( "src", reader.result );
              }

              $( "html, body, .content" ).animate({
                scrollTop: ( $( "#image_a" ).offset().top )
              }, 500 );

          } else {
              //If an image is not selected then show an other image.
              $( "#image_a" ).attr
              ( "src", "http://placehold.it/550x270&text=No+PreView!" );
          }
      }
  });

  $( "#upload_image_b" ).change( function () {
      //Check if a file has been selected or not
      if ( this.files && this.files[ 0 ] ) {
          //Check if the uploaded file is an Image file
          if ( this.files[ 0 ].type.startsWith( "image/" ) ) {
              var reader = new FileReader();
              reader.readAsDataURL( this.files[ 0 ] );
              reader.onloadend = function () {
                $( "#image_b_creator" ).attr( "src", reader.result );
                $( "#image_b" ).attr( "src", reader.result );
              }

              $( "html, body, .content" ).animate({
                scrollTop: ( $( "#image_b" ).offset().top )
              }, 500 );

          } else {
              //If an image is not selected then show an other image.
              $( "#image_b" ).attr
              ( "src", "http://placehold.it/550x270&text=No+PreView!" );
          }
      }
  });

  $( "#upload_image_c" ).change( function () {
      //Check if a file has been selected or not
      if ( this.files && this.files[ 0 ] ) {
          //Check if the uploaded file is an Image file
          if ( this.files[ 0 ].type.startsWith( "image/" ) ) {
              var reader = new FileReader();
              reader.readAsDataURL( this.files[ 0 ] );
              reader.onloadend = function () {
                $( "#image_c_creator" ).attr( "src", reader.result );
                $( "#image_c" ).attr( "src", reader.result );
              }

              $( "html, body, .content" ).animate({
                scrollTop: ( $( "#image_c" ).offset().top )
              }, 500 );
          } else {
              //If an image is not selected then show an other image.
              $( "#image_c" ).attr
              ( "src", "http://placehold.it/550x270&text=No+PreView!" );
          }
      }
  });

});
