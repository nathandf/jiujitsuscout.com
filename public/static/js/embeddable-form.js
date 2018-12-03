function loadEmbeddableFormByJiuJitsuScoutCSS( filename ) {

   var file = document.createElement( "link" );
   file.setAttribute( "rel", "stylesheet" );
   file.setAttribute( "type", "text/css" );
   file.setAttribute( "href", filename );
   document.head.appendChild( file );

}

loadEmbeddableFormByJiuJitsuScoutCSS( "/jiujitsuscout.com/public/static/css/embeddable-form.css" );
