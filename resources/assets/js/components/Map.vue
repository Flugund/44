<style lang="sass" scoped>
#map-canvas {
  height: 100%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
}
</style>

<template>
    <navigation></navigation>

    <div id="map-canvas"></div>

    <feedback></feedback>
</template>

<script>
    import Locator from './Locator';
    import Feedback from './Feedback';
    import MapSettings from './MapSettings';
    import Navigation from './Navigation';

    export default {
        data() {
            return {};
        },

        ready() {
            // google.maps.event.addDomListener(window, 'load', this.initMap());
        },

        methods: {
            initMap() {
                Locator.getLocation((coordinates) => {
                    var styledMapType = new google.maps.StyledMapType(MapSettings);

                    var map = new google.maps.Map(document.getElementById('map-canvas'), {
                        center: new google.maps.LatLng(coordinates.lat, coordinates.lng),
                        zoom: 13,
                        mapTypeId: 'styled_map',
                        disableDefaultUI: false
                    });

                    var heatmap = new google.maps.visualization.HeatmapLayer({
                      data: []
                    });
                    heatmap.setMap(map);
                    map.mapTypes.set('styled_map', styledMapType);

                    google.maps.event.addListener(map, 'idle', () => {
                        var bb = map.getBounds();
                        var ne = bb.getNorthEast(); // top-left
                        var sw = bb.getSouthWest(); // bottom-right

                        this.fetchDataPoints(heatmap, sw.lng(), ne.lat(), ne.lng(), sw.lat());
                    });
                }, (errorMsg) => {
                    alert(errorMsg);
                });
            },

            fetchDataPoints(heatmap, long_min, lat_min, long_max, lat_max) {
                var heatmapData = [];

                // fake the bounds of the map.
                long_min=-74.5;
                lat_min=40.0;
                long_max=-74.0;
                lat_max=40.5;

                this.$http.get(`/api/feedback?longitude_min=${long_min}&latitude_min=${lat_min}&longitude_max=${long_max}&latitude_max=${lat_max}`).then((res) => {

                    _.each(res.json(), (item) => {
                        heatmapData.push(new google.maps.LatLng(item.lat, item.lon));
                    });

                    heatmap.setData(heatmapData);
                });
            }
        },

        components: { Feedback, Navigation }
    }
</script>
