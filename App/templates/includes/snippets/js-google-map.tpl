<div style="height: 300px;">
    <div id="map" style="height: 100%;"></div>
</div>
{literal}
<script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAROndVkrCCoOGb2GDL5h9kuu9YF8zhHoM&callback=initMap" async defer>
</script>
{/literal}
