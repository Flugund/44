module.exports = {
    getLocation(successCb, failCb) {
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                // successCb({
                //     lat: position.coords.latitude,
                //     lng: position.coords.longitude
                // });

                // Fake location to NYC
                successCb({lat: 40.6349, lng: -74.1344});
            }, () => {
                failCb('Error: The Geolocation service failed.');
            });
        } else {
            failCb('Error: Your browser doesn\'t support geolocation.');
        }
    }
};
