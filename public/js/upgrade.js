$( function() {
    var pro_monthly = 49;
    var pro_monthly_product_number = 1;
    var pro_yearly = 44;
    var pro_yearly_product_number = 3;
    var business_monthly = 99;
    var business_monthly_product_number = 2;
    var business_yearly = 90;
    var business_yearly_product_number = 4;

    $( "#billing-interval-monthly" ).click( function() {
        if ( $( "#billing-interval-monthly" ).is( ":checked" ) ) {
            $( "#pro-price" ).text( pro_monthly );
            $( "#business-price" ).text( business_monthly );
            $( "#pro-product" ).val( pro_monthly_product_number );
            $( "#business-product" ).val( business_monthly_product_number );
        }
    });
    $( "#billing-interval-yearly" ).click( function() {
        if ( $( "#billing-interval-yearly" ).is( ":checked" ) ) {
            $( "#pro-price" ).text( pro_yearly );
            $( "#business-price" ).text( business_yearly );
            $( "#pro-product" ).val( pro_yearly_product_number );
            $( "#business-product" ).val( business_yearly_product_number );
        }
    });
});
