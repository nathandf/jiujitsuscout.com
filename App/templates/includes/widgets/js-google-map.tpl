{if isset($business->latitude,$business->longitude)}
    <div style="height: 300px; margin: 0; padding: 0;">
        <div id="map" style="height: 100%; margin: 0; padding: 0;"></div>
    </div>
    {literal}
    <script>
        var map;
        function initMap() {
            map = new google.maps.Map( document.getElementById( "map" ), {
                center: {lat: {/literal}{$business->latitude}{literal}, lng: {/literal}{$business->longitude}{literal}},
                zoom: 13
            }) ;

            var marker = new google.maps.Marker({
                position:{lat:{/literal}{$business->latitude}{literal},lng:{/literal}{$business->longitude}{literal}},
                map:map
            });

            var infoWindow = new google.maps.InfoWindow({
                content:"{/literal}{$business->business_name}{literal}"
            });

            marker.addListener( "click", function() {
                infoWindow.open( map, marker );
            } );
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={/literal}{$google_api_key}{literal}&callback=initMap" async defer></script>
    {/literal}
{/if}
