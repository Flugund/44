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
    import Locator from './Locator';
    import Feedback from './Feedback';
    import MapSettings from './MapSettings';

    export default {
        route: {
            data(transition) {
                // fetch data-points
                // var apiData = [
                //     {long: 40.730610, lat: -73.935242},
                //     {long: 40.730610, lat: -73.945242},
                //     {long: 40.730610, lat: -73.955242},
                //     {long: 40.730610, lat: -73.965242},

                //     {long: 40.750610, lat: -73.975242},
                //     {long: 40.750610, lat: -73.975242},
                //     {long: 40.750610, lat: -73.975242},
                //     {long: 40.750610, lat: -73.975242},
                // ];

                // _.each(apiData, (item) => {
                //     this.heatmapData.push(new google.maps.LatLng(item.long, item.lat));
                // });

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

                Locator.getLocation((coordinates) => {
                    var styledMapType = new google.maps.StyledMapType(MapSettings);
                    console.log(coordinates.lat, coordinates.lng);
                    var map = new google.maps.Map(document.getElementById('map-canvas'), {
                      center: new google.maps.LatLng(coordinates.lat, coordinates.lng),
                      zoom: 13,
                      mapTypeId: 'styled_map',
                      disableDefaultUI: true
                    });

                    var heatmap = new google.maps.visualization.HeatmapLayer({
                      data: this.heatmapData
                    });
                    heatmap.setMap(map);
                    map.mapTypes.set('styled_map', styledMapType);

                    google.maps.event.addListener(map, 'idle', () => {
                        var bb = map.getBounds();
                        var ne = bb.getNorthEast(); // top-left
                        var sw = bb.getSouthWest(); // bottom-right

                        this.fetchDataPoints(sw.lng(), ne.lat(), ne.lng(), sw.lat());
                    });
                }, (errorMsg) => {
                    alert(errorMsg);
                });
            },

            fetchDataPoints(long_min, lat_min, long_max, lat_max) {
                console.log(long_min, lat_min, long_max, lat_max);
                return;

                this.$http.get(`/api/feedback?longitude_min=${long_min}&latitude_min=${lat_min}&longitude_max=${long_max}&latitude_max=${lat_max}`).then((res) => {
                    console.log(res.json);
                });

                // _.each(apiData, (item) => {
                //     this.heatmapData.push(new google.maps.LatLng(item.long, item.lat));
                // });
            }
        },

        components: { Feedback }
    }
</script>
