<style lang="sass" scoped>

</style>

<template>
    <div id="map-canvas"></div>
</template>

<script>
    export default {
        data() {
            return {};
        },

        ready() {
            google.maps.event.addDomListener(window, 'load', this.initMap());
        },

        methods: {
            initMap() {
                /* Data points defined as an array of LatLng objects */
                var heatmapData = [
                    new google.maps.LatLng(40.730610, -73.935242),
                    new google.maps.LatLng(40.730610, -73.945242),
                    new google.maps.LatLng(40.730610, -73.955242),
                    new google.maps.LatLng(40.730610, -73.965242),

                    new google.maps.LatLng(40.750610, -73.975242),
                    new google.maps.LatLng(40.750610, -73.965242),
                    new google.maps.LatLng(40.750610, -73.965242),
                    new google.maps.LatLng(40.750610, -73.965242),
                ];

                var styledMapType = new google.maps.StyledMapType(
                    [
                      {
                        "elementType": "geometry",
                        "stylers": [
                          {
                            "color": "#f5f5f5"
                          }
                        ]
                      },
                      {
                        "elementType": "labels.icon",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      },
                      {
                        "elementType": "labels.text.fill",
                        "stylers": [
                          {
                            "color": "#616161"
                          }
                        ]
                      },
                      {
                        "elementType": "labels.text.stroke",
                        "stylers": [
                          {
                            "color": "#f5f5f5"
                          }
                        ]
                      },
                      {
                        "featureType": "administrative",
                        "elementType": "geometry",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      },
                      {
                        "featureType": "administrative.land_parcel",
                        "elementType": "labels.text.fill",
                        "stylers": [
                          {
                            "color": "#bdbdbd"
                          }
                        ]
                      },
                      {
                        "featureType": "poi",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      },
                      {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [
                          {
                            "color": "#eeeeee"
                          }
                        ]
                      },
                      {
                        "featureType": "poi",
                        "elementType": "labels.text.fill",
                        "stylers": [
                          {
                            "color": "#757575"
                          }
                        ]
                      },
                      {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [
                          {
                            "color": "#e5e5e5"
                          }
                        ]
                      },
                      {
                        "featureType": "poi.park",
                        "elementType": "labels.text.fill",
                        "stylers": [
                          {
                            "color": "#9e9e9e"
                          }
                        ]
                      },
                      {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [
                          {
                            "color": "#ffffff"
                          }
                        ]
                      },
                      {
                        "featureType": "road",
                        "elementType": "labels.icon",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      },
                      {
                        "featureType": "road.arterial",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      },
                      {
                        "featureType": "road.arterial",
                        "elementType": "labels.text.fill",
                        "stylers": [
                          {
                            "color": "#757575"
                          }
                        ]
                      },
                      {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [
                          {
                            "color": "#dadada"
                          }
                        ]
                      },
                      {
                        "featureType": "road.highway",
                        "elementType": "labels",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      },
                      {
                        "featureType": "road.highway",
                        "elementType": "labels.text.fill",
                        "stylers": [
                          {
                            "color": "#616161"
                          }
                        ]
                      },
                      {
                        "featureType": "road.local",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      },
                      {
                        "featureType": "road.local",
                        "elementType": "labels.text.fill",
                        "stylers": [
                          {
                            "color": "#9e9e9e"
                          }
                        ]
                      },
                      {
                        "featureType": "transit",
                        "stylers": [
                          {
                            "visibility": "off"
                          }
                        ]
                      },
                      {
                        "featureType": "transit.line",
                        "elementType": "geometry",
                        "stylers": [
                          {
                            "color": "#e5e5e5"
                          }
                        ]
                      },
                      {
                        "featureType": "transit.station",
                        "elementType": "geometry",
                        "stylers": [
                          {
                            "color": "#eeeeee"
                          }
                        ]
                      },
                      {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                          {
                            "color": "#c9c9c9"
                          }
                        ]
                      },
                      {
                        "featureType": "water",
                        "elementType": "labels.text.fill",
                        "stylers": [
                          {
                            "color": "#9e9e9e"
                          }
                        ]
                      }
                    ]
                );

                var nyc = new google.maps.LatLng(40.730610, -73.935242);

                var map = new google.maps.Map(document.getElementById('map-canvas'), {
                  center: nyc,
                  zoom: 13,
                  mapTypeId: 'styled_map',
                  disableDefaultUI: true
                });

                var heatmap = new google.maps.visualization.HeatmapLayer({
                  data: heatmapData
                });
                heatmap.setMap(map);
                map.mapTypes.set('styled_map', styledMapType);
            }
        }
    }
</script>
