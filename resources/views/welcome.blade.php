<!DOCTYPE html>
<html>
  <head>
    <title>Team Fourtyfour: USGCB</title>

    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

    <link rel=stylesheet href="{{ asset('/css/styles.css') }}">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://sdk.amazonaws.com/js/aws-sdk-2.5.1.min.js"></script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyDi2LVi_cyDP9ibCRsm-KWlKUX40slMn6g&libraries=visualization">// <![CDATA[

    // ]]></script>

  </head>
  <body id="app">

    <router-view></router-view>

    <script src="{{ asset('/js/app.js') }}"></script>

  </body>
</html>
