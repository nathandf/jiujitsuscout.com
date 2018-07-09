{if isset($business->latitude,$business->longitude)}
    <div style="height: 300px; margin: 0; padding: 0;">
        <div id="map" style="height: 100%; margin: 0; padding: 0;"></div>
    </div>
    {literal}
    <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: {/literal}{$business->latitude}{literal}, lng: {/literal}{$business->longitude}{literal}},
                zoom: 13
            });

            var marker = new google.maps.Marker({
                position:{lat:{/literal}{$business->latitude}{literal},lng:{/literal}{$business->longitude}{literal}},
                map:map
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAROndVkrCCoOGb2GDL5h9kuu9YF8zhHoM&callback=initMap" async defer></script>
    {/literal}
{/if}
