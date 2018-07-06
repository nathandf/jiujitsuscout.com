$( function() {

  $( "#input-slug" ).on( "keyup", function() {
    input_slug = $( "#input-slug" ).val();
    $( "#slug" ).text( input_slug );
  });

});
