<style lang="sass" scoped>
#map-canvas {
  height: 100%;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
}

.current-feedback {
    position: fixed;
    top: 4em;

    left: 1em;

    max-width: 400px;

    background: #fff;
    padding: 1em;

    z-index: 1000;

    button {
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
        color: #fff;
        background-color: #337ab7;
        border-color: #2e6da4;
    }
}
</style>

<template>
    <navigation></navigation>

    <div id="map-canvas"></div>

    <feedback></feedback>

    <div v-if="showCurrentFeedback" class="current-feedback">
        <h2>{{ currentFeedback.address }}</h2>

        <img src="http://dummyimage.com/370x180/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image">

        <hr>

        <button @click="removeCurrentFeedback">I fixed it!</button>
    </div>
</template>

<script>
    import Locator from './Locator';
    import Feedback from './Feedback';
    import MapSettings from './MapSettings';
    import Navigation from './Navigation';

    export default {
        data() {
            return {
                'showCurrentFeedback': false,
                'currentFeedback' : {}
            };
        },

        ready() {
            google.maps.event.addDomListener(window, 'load', this.initMap());
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

                    map.addListener('click', (e) => {
                        var lat = e.latLng.lat();
                        var lng = e.latLng.lng();

                        this.$http.get(`api/feedback-score?longitude=${lng}&latitude=${lat}`).then((res) => {
                            var res = _.first(res.json());

                            var score = Math.round(res.score);
                            var propVal = Math.round(res.score * 0.3);

                            var infowindow = new google.maps.InfoWindow({
                                content: '<div>' +
                                    `<label>Locationscore: </label> <span>${score}</span>` +
                                    '<br/>' +
                                    `<label>Effect on property value: </label> <span>${propVal}</span>` +
                                '</div>'
                            });

                            infowindow.open(map);

                            infowindow.setPosition(new google.maps.LatLng(lat, lng));
                        });
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

                        this.fetchDataPoints(heatmap, sw.lng(), ne.lat(), ne.lng(), sw.lat(), map);
                    });
                }, (errorMsg) => {
                    alert(errorMsg);
                });
            },

            fetchDataPoints(heatmap, long_min, lat_min, long_max, lat_max, map) {
                var heatmapData = [];

                // fake the bounds of the map.
                long_min=-74.5;
                lat_min=40.0;
                long_max=-74.0;
                lat_max=40.5;

                this.$http.get(`/api/feedback?longitude_min=${long_min}&latitude_min=${lat_min}&longitude_max=${long_max}&latitude_max=${lat_max}&status=1`).then((res) => {

                    _.each(res.json(), (item) => {
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(item.lat, item.lon),
                            map: map
                        });

                        marker.addListener('click', () => {
                            map.setCenter(marker.getPosition());

                            item.marker = marker;

                            this.$set('currentFeedback', item);
                            this.$set('showCurrentFeedback', true);
                        });
                    });
                });

                this.$http.get(`/api/feedback?longitude_min=${long_min}&latitude_min=${lat_min}&longitude_max=${long_max}&latitude_max=${lat_max}&status=2`).then((res) => {

                    _.each(res.json(), (item) => {
                        heatmapData.push(new google.maps.LatLng(item.lat, item.lon));
                    });

                    heatmap.setData(heatmapData);
                });
            },

            removeCurrentFeedback(marker) {
                this.currentFeedback.marker.setMap(null);
                this.$set('currentFeedback', {});
                this.$set('showCurrentFeedback', false);
            }
        },

        components: { Feedback, Navigation }
    }
</script>
