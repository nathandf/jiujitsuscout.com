{literal}
<script>
function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: {
      lat: <?= $business->lat;?>,
      lng: <?= $business->lng;?>
    },
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    zoom: 14,
    disableDefaultUI: true,
    zoomControl: true
  });
  map.setTilt(0);
  marker = new google.maps.Marker({
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
    position: {
      lat: <?= $business->lat;?>,
      lng: <?= $business->lng;?>
    }
  });
  google.maps.event.addListener(marker, 'dragend', function() {
    move_maarker_pop(marker.getPosition().lat(), marker.getPosition().lng())
  });

}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSArmnamh7DA_WZbXIUvpbLxA1eN5zBFo&libraries=drawing,places&callback=initMap" ></script>
<div id="map" style="width: 100%; height: 300px;" ></div>
{/literal}
