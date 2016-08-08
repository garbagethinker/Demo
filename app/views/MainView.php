<!DOCTYPE html>
<html>
    <head>
        <style>
            #map {
                width: 500px;
                height: 400px;
            }
            #pathJson {
                width: 500px;
                height: 400px;
            }
        </style>
    </head>
    <body>
        <div id="map"></div>
        <div id="pathJson"></div>
        <div id="contentContainer"></div>
        <input type="button" name="button" value="Click" onclick="fun()">
        <script>
            var temp = 0;
            function fun() {
                var xmlhttp;
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById('contentContainer').innerHTML = xmlhttp.responseText;

                        window.history.pushState({"html":xmlhttp.responseText,"pageTitle":"Alpha"}, "", urlPath);
                        alert(window.location.href);

                    }
                };
                window.onhashchange = function (e){
                   alert("hashchange"); 
                };
                window.onpopstate = function (e) {
                    alert("Hello " + JSON.stringify(e.state));
                    if (e.state) {
                        
                        document.getElementById("contentContainer").innerHTML = e.state.html;
                        document.title = e.state.pageTitle;
                    }
                };
                var urlPath = "/main/test";
                if(temp==0){
                    temp++;
                    urlPath = "/main/test";
                }else{
                    urlPath = "/main/fun";
                }
                xmlhttp.open("GET", urlPath, true);
                xmlhttp.send();
            }
            function initMap1() {

                window.history.pushState({"html":document.getElementById("contentContainer")
                            .innerHTML,"pageTitle":"Alpha"}
                , "", window.location.href);
                var mapDiv = document.getElementById('map');
                var delhi = new google.maps.LatLng(28.632267, 77.220351);
                var mapOptions = {
                    zoom: 10


                };
                var directionsDisplay;
                directionsDisplay = new google.maps.DirectionsRenderer();
                var map = new google.maps.Map(mapDiv, mapOptions);
                var option = {
                    //types: ['(cities)'],
                    componentRestrictions: {country: "in"}
                };
                var input = /** @type {!HTMLInputElement} */(
                        document.getElementById('txtSource'));
                //	new google.maps.places.Autocomplete(input);
                directionsDisplay.setMap(map);
                google.maps.event.addDomListener(window, 'load', function () {
                    //new google.maps.places.Autocomplete(document.getElementById('txtSource'),option);
                    //new google.maps.places.Autocomplete(document.getElementById('txtDestination'),option);
                    directionsDisplay = new google.maps.DirectionsRenderer({'draggable': true});

                });



                var marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    title: "Bhupendra Singh Yadav",
                    description: "This is the first user who have created the event",
                    animation: google.maps.Animation.DROP,
                    position: {lat: 28.632267, lng: 77.220351}
                });




                var directionsService = new google.maps.DirectionsService();

                var start = "Aliganj, Etah";
                var end = "Kanpur";
                var waypts = [];
                var cities = ['Farrukhabad', 'Hardoi', 'Kannauj', 'Bilhaur', 'Auraiya', 'Mumbai', 'Kanyakumari'];
                for (var i = 0; i < cities.length; i++) {
                    waypts.push(
                            {
                                location: cities[i],
                                stopover: true
                            }
                    );

                }
                var request = {
                    origin: start,
                    destination: end,
                    waypoints: waypts,
                    travelMode: google.maps.TravelMode.DRIVING
                };

                directionsService.route(request, function (response, status) {
                    if (status === google.maps.DirectionsStatus.OK) {
                        var summaryPanel = document.getElementById("pathJson");
                        summaryPanel.innerHTML = "";
                        var route = response.routes[0];
                        // For each route, display summary information.
                        for (var i = 0; i < route.legs.length; i++) {
                            var routeSegment = i + 1;
                            summaryPanel.innerHTML += "<b>Route Segment: " + routeSegment + "</b><br />";
                            summaryPanel.innerHTML += route.legs[i].start_address + " to ";
                            summaryPanel.innerHTML += route.legs[i].end_address + "<br />";
                            summaryPanel.innerHTML += route.legs[i].distance.text + "<br /><br />";
                        }
                        summaryPanel.innerHTML = JSON.stringify(route.bounds);
                        console.log(computeTotalDistance(response))
                        directionsDisplay.setDirections(response);
                    }
                });

            }
            function computeTotalDistance(result) {
                var totalDist = 0;
                var totalTime = 0;
                var myroute = result.routes[0];
                for (i = 0; i < myroute.legs.length; i++) {
                    totalDist += myroute.legs[i].distance.value;
                    totalTime += myroute.legs[i].duration.value;
                }
                totalDist = totalDist / 1000;
                return totalDist;
            }

        </script>

        <script src="https://maps.googleapis.com/maps/api/js?callback=initMap1"
        async defer></script>
    </body>
</html>