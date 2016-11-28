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
    <div id="map-canvas"></div>

    <feedback></feedback>
</template>

<script>
    import Feedback from './Feedback';
    import MapSettings from './MapSettings';

    export default {
        route: {
            data(transition) {
                // fetch data-points
                var apiData = [
                    {long: 40.730610, lat: -73.935242},
                    {long: 40.730610, lat: -73.945242},
                    {long: 40.730610, lat: -73.955242},
                    {long: 40.730610, lat: -73.965242},

                    {long: 40.750610, lat: -73.975242},
                    {long: 40.750610, lat: -73.975242},
                    {long: 40.750610, lat: -73.975242},
                    {long: 40.750610, lat: -73.975242},
                ];

                _.each(apiData, (item) => {
                    this.heatmapData.push(new google.maps.LatLng(item.long, item.lat));
                });

                transition.next(transition);
            }
        },

        data() {
            return {
                heatmapData: [],
                map: {}
            };
        },

        ready() {
            google.maps.event.addDomListener(window, 'load', this.initMap());
        },

        methods: {
            initMap() {
                var styledMapType = new google.maps.StyledMapType(MapSettings);

                var nyc = new google.maps.LatLng(40.730610, -73.935242);

                var map = new google.maps.Map(document.getElementById('map-canvas'), {
                  center: nyc,
                  zoom: 13,
                  mapTypeId: 'styled_map',
                  disableDefaultUI: true
                });

                var heatmap = new google.maps.visualization.HeatmapLayer({
                  data: this.heatmapData
                });
                heatmap.setMap(map);
                map.mapTypes.set('styled_map', styledMapType);
            }
        },

        components: { Feedback }
    }
</script>
