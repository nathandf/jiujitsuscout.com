$( function () {
	var propertyBuilder = {
		iteration: 0,
		iterate: function () {
			this.iteration++;
		},
		newPropertyRow: function () {
			this.iterate();
			var property_columns, property_name, data_type, value_length, is_null, is_primary, table_open, table_close;

			table_open = "<tr class=\"table-row\">";
			hidden_properties_tracker = "<input type='hidden' name='property_indicies[]' value='" + this.iteration + "'>";
			value_length_options = "<option selected=\"selected\" hidden=\"hidden\"value=\"\">Choose</option><option value=\"bigint\">BIGINT</option><option value=\"tinyint\">TINYINT</option><option value=\"tinyint\">VARCHAR</option><option value=\"mediumtext\">MEDIUMTEXT</option>";
			property_name = "<td style=\"text-align: center;\"><input name=\"property_row_" + this.iteration + "[ property_name ]\" class=\"inp col-100\" required=\"required\"></td>";
			data_type = "<td style=\"text-align: center;\"><select name=\"property_row_" + this.iteration + "[ data_type ]\" class=\"inp col-100 cursor-pt\" required=\"required\">" + value_length_options + "</select></td>";
			value_length = "<td style=\"text-align: center;\"><input name=\"property_row_" + this.iteration + "[ value_length ]\" class=\"inp col-100\"></td>";
			is_null = "<td style=\"text-align: center;\"><input type=\"checkbox\" class=\"checkbox\" name=\"property_row_" + this.iteration + "[ is_null ]\"></td>";
			is_primary = "<td style=\"text-align: center;\"><input type=\"checkbox\" class=\"checkbox\" name=\"property_row_" + this.iteration + "[ is_primary ]\"></td>";
			auto_increment = "<td style=\"text-align: center;\"><input type=\"checkbox\" class=\"checkbox\" name=\"property_row_" + this.iteration + "[ auto_increment ]\"></td>";
			trash = "<td style=\"text-align: center;\"><p class=\"tc-red text-xlrg-heavy cursor-pt table-row-trash\">x</p></td>";
			table_close = "</tr>"

			return property_columns = table_open + hidden_properties_tracker + property_name + data_type + value_length + is_null + is_primary + auto_increment + trash;
		}
	};

	$( "#model-name" ).on( "keyup", function() {
		$( "#model-name" ).val( $( this ).val().toLowerCase().split( " " ).join( "-" ) );
    });

	$( "#add-property" ).on( "click", function () {
		$( "#property-table" ).append( propertyBuilder.newPropertyRow() );
	} );

	$( "#property-table" ).on( "click", ".table-row-trash", function () {
		confirmation = confirm( "Are you sure you want to delete this?" );
        if ( confirmation !== false ) {
            $( this ).parent().parent().remove();
        }
	} );
} );
