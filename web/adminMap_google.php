<?php 
   session_start();

   include("php/config.php");

   if(!isset($_SESSION['username'])){
    header("Location: index.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"/>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
     <style>
         #map {position: center; height: 400px; padding-left: 200px; padding-right: 500px; padding-top: 500px; max-width: 500px;}
    .box{justify-content: center; align-items: center;}
    .menu {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .menu a {
        text-decoration: none;
    }

    .menu .btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        font-size: 18px;
        color: #fff;
        background-color: #4c44b6;
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .menu .btn:hover {
        background-color: #0056b3;
    }

    .menu .btn:active {
        background-color: #00f36f;
    }

    .btn {
        padding: 5px 10px;
        font-size: 16px;
    }
    </style>
    <link rel="stylesheet" href="style/style.css">
    
    <title>Menu</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Menu Διαχειριστή</p>
        </div>

        <div class="right-links">
            <?php

            $username = $_SESSION['username'];
            $query = mysqli_query($con,"SELECT*FROM users WHERE username='$username'");

            while($result = mysqli_fetch_assoc($query)){
                $res_uname = $result['username'];
                $res_name = $result['name'];
                
            }
            
            ?>
        
            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>

        </div>
    </div>

    <main>
    <div class="main-box top">
          <div class="top">
            <div class="box">
            <p>Name: <b><?php echo $res_name ?></b>, username: <b><?php echo $res_uname ?></b></p>
            </div>
            
            <div class="menu">
            <a href="adminHome.php"><button class="btn">Αποθήκη</button></a>
                    <a href="adminMap.php"><button class="btn">Χάρτης</button></a>
                    <a href="adminCrRescAcc.php"><button class="btn">Δημ. Λογ. Διασώστη</button></a>
                    <a href="adminStatistics.php"><button class="btn">Στατιστικά</button></a>
                    <a href="adminAnak.php"><button class="btn">Δημ. Ανακοίνωσης</button></a>            
            </div>
            
       </div>
       <hr><hr>
       <br>
       <div id="filters" class="filters">
   <label>
      <input type="checkbox" id="filter1"> Taken Requests
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter2"> Waiting Requests
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter3"> Only Donations
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter4"> Cars with tasks
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter5"> Cars without tasks
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter6"> Hide Request polylines
   </label>
   <br>
   <label>
      <input type="checkbox" id="filter7"> Hide Donation polylines
   </label>
</div>
       <div align="right" class="map" id="map">Χάρτης</div>

       <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
       
    </main>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    
    <script>
        function initMap() {

        function getMarkerPosition(){
            const savedPosition = localStorage.getItem('markerPosition');
            return savedPosition ? JSON.parse(savedPosition) : [38.246, 21.735];
        }

        function setMarkerPosition(position){
            localStorage.setItem('markerPosition', JSON.stringify(position));
        }

        const initialArr = getMarkerPosition();
        const initialPosition = { lat: Number(initialArr[0]), lng: Number(initialArr[1]) };

        const map = new google.maps.Map(document.getElementById('map'), {
            center: initialPosition,
            zoom: 13
        });

        const marker = new google.maps.Marker({
            position: initialPosition,
            map: map,
            draggable: true,
            title: "Βάση"
        });

        marker.addListener('dragend', function(){

            const confirmChange = confirm('Είστε σίγουρος πως θέλετε να αλλάξετε τη θέση του Marker;');

            if(!confirmChange){
                marker.setPosition(initialPosition);
            }
        
        });

        marker.addListener('dragend', function(){
            const newPosition = marker.getPosition();
            setMarkerPosition([newPosition.lat(), newPosition.lng()]);
        });

        var carIcon = {
            url: 'car-svgrepo-com.svg',
            scaledSize: new google.maps.Size(32, 32),
            anchor: new google.maps.Point(16, 16)
        };

        var carMarker1 = new google.maps.Marker({ position: {lat: 38.280, lng: 21.792}, map: map, title: "Όχημα 1 ", icon: carIcon });
        var carMarker2 = new google.maps.Marker({ position: {lat: 38.207, lng: 21.734}, map: map, title: "Όχημα 2 ", icon: carIcon });
        var carMarker3 = new google.maps.Marker({ position: {lat: 38.222, lng: 21.775}, map: map, title: "Όχημα 3 ", icon: carIcon });

        var carMarkersById = {
            '100': carMarker1,
            '200': carMarker2,
            '300': carMarker3
        };

        var infoWindow = new google.maps.InfoWindow();

        function bindPopup(m, html) {
            m.popupHtml = html;
            if (!m.popupBound) {
                m.addListener('click', function () {
                    infoWindow.setContent(m.popupHtml);
                    infoWindow.open({ anchor: m, map: map });
                });
                m.popupBound = true;
            }
        }

        function samePosition(a, b) {
            return Math.abs(a.lat() - b.lat()) < 1e-9 && Math.abs(a.lng() - b.lng()) < 1e-9;
        }
        
        var popupContentByCarId = {};

        function updateCarPopups() {
            for (var carId in popupContentByCarId) {
                if (popupContentByCarId.hasOwnProperty(carId)) {
                    var carMarker = carMarkersById[carId] || null;

                    if (carMarker) {
                        var popupContent = popupContentByCarId[carId].join('<br>');
                        console.log(popupContent);
                        bindPopup(carMarker, "Username: " + carId + "<hr><br>" + popupContent);
                    }
                }
            }
        }

        var loadsRequest = new XMLHttpRequest();
        var loadsUrl = "get_car_loads.php";

        loadsRequest.open("GET", loadsUrl, true);

        loadsRequest.send();

        loadsRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var loads = JSON.parse(this.responseText);

                loads.forEach(function (load) {
                    var carId = load.car_id;
                    var prName = load.pr_name;
                    var quantity = load.quantity;

                    if (!popupContentByCarId[carId]) {
                        popupContentByCarId[carId] = [];
                    }

                    popupContentByCarId[carId].push("<h3><b>Φορτίο: </h3></b><hr><br> Προϊόν: " + prName + "<br> Ποσότητα: " + quantity + "<br>");
                });

                updateCarPopups();
            }
        };

        var tasks = [];
        var tasksRequest = new XMLHttpRequest();
        var tasksUrl = "get_car_tasks.php";

        tasksRequest.open("GET", tasksUrl, true);

        tasksRequest.send();

        tasksRequest.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                tasks = JSON.parse(this.responseText);

                tasks.forEach(function (task) {
                    var carId = task.car_id;
                    var eidos_task = task.eidos_task;
                    var username_res = task.username_res;
                    var citizen_name = task.citizen_name;
                    var citizen_mobile = task.citizen_mobile;
                    var proion = task.proion;
                    var atoma = task.atoma;

                    if (!popupContentByCarId[carId]) {
                        popupContentByCarId[carId] = [];
                    }

                    popupContentByCarId[carId].push("<h3><b>Tasks: </h3></b><hr><br> Είδος Task: " + eidos_task + "<br> Διασώστης: " + username_res +"<br> Όνομα Πολίτη: " + citizen_name +"<br> Τηλέφωνο Πολίτη: " + citizen_mobile + "<br> Προϊόν: " + proion + "<br> Ποσότητα: " + atoma + "<br>");
                });

                updateCarPopups();
            }
        };

        var wait_ait = {
            url: 'marker-16.png',
            scaledSize: new google.maps.Size(32, 32),
            anchor: new google.maps.Point(16, 16)
        };

        var carMarkers = [];
        var requestMarkers = [];
        var donationMarkers = [];

        var xml = new XMLHttpRequest();
        var aitUrl = "get_aithmata.php";

        xml.open("GET", aitUrl, true);

        xml.send();

        xml.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var ait = JSON.parse(this.responseText);

                for (var username in ait) {
                    var userAithma = ait[username];

                    var popupContent = "";
                    for (var i = 0; i < userAithma.length; i++) {
                        var aithma = userAithma[i];
                        popupContent += "Όνομα: " + aithma.onoma + "<br>Κινητό: " + aithma.mobile + "<br>Προϊόν: " + aithma.proion + "<br>Ποσότητα: " + aithma.atoma + "<br>Ημερομηνία Αίτησης: " + aithma.hmerominia_aitisis + "<br><br>";
                    }
                
                    var latitude = Number(userAithma[0].latitude);
                    var longitude = Number(userAithma[0].longitude);

                    var aithmaMarker = new google.maps.Marker({
                        position: { lat: latitude, lng: longitude },
                        map: map,
                        title: "Αίτημα",
                        icon: wait_ait
                    });
                    aithmaMarker.egine_dekto = aithma.egine_dekto;
                    bindPopup(aithmaMarker, "Username: " + username + "<br>" + popupContent);
                    requestMarkers.push(aithmaMarker);
                }
            }
        } 
        
        var wait_don = {
            url: 'yellowMarker-16 .png',
            scaledSize: new google.maps.Size(32, 32),
            anchor: new google.maps.Point(16, 16)
        };

        var don = new XMLHttpRequest();
        var donUrl = "get_dorees.php";

        don.open("GET", donUrl, true);

        don.send();

        don.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var donations = JSON.parse(this.responseText);

                for (var username in donations) {
                    var userDonations = donations[username];

                    var popupContent = "";
                    for (var i = 0; i < userDonations.length; i++) {
                        var donation = userDonations[i];
                        popupContent += "Όνομα: " + donation.onoma + "<br>Κινητό: " + donation.mobile + "<br>Προϊόν: " + donation.proion + "<br>Ποσότητα: " + donation.atoma + "<br>Ημερομηνία Αίτησης: " + donation.hmerominia_doreas + "<br><br>";
                    }
                
                    var latitude = Number(userDonations[0].latitude);
                    var longitude = Number(userDonations[0].longitude);

                    var donationMarker = new google.maps.Marker({
                        position: { lat: latitude, lng: longitude },
                        map: map,
                        title: "Δωρεά",
                        icon: wait_don
                    });
                    bindPopup(donationMarker, "Username: " + username + "<br>" + popupContent);

                    donationMarkers.push(donationMarker);
                }
            }
        }

        var polyline;
        var polylines = [];
        var xmlReq = new XMLHttpRequest();
        var tasksReqUrl = "get_tasks.php";

        xmlReq.open("GET", tasksReqUrl, true);

        xmlReq.onload = function () {
            if (this.readyState == 4 && this.status == 200) {
                var get_tasks = JSON.parse(this.responseText);
                console.log("Tasks:", get_tasks);

                for (var i = 0; i < get_tasks.length; i++) {
                    var usernameRes = get_tasks[i].username_res;
                    var carId = get_tasks[i].car_id;
                    var destLat = get_tasks[i].destination_lat;
                    var destLng = get_tasks[i].destination_lng;

                    console.log("Processing task:", get_tasks[i]);

                    var carMarker = carMarkersById[carId];
                    if (carMarker) {
                        console.log("Drawing polyline for car " + carId);
                        drawPolyline(carMarker, destLat, destLng);
                    }
                }
            }
        };

        xmlReq.send();

        function drawPolyline(carMarker, destLat, destLng) {
            var latitude = carMarker.getPosition().lat();
            var longitude = carMarker.getPosition().lng();

            var latlng = [
                { lat: latitude, lng: longitude },
                { lat: Number(destLat), lng: Number(destLng) }
            ];
            console.log("Polyline coordinates:", latlng);

            polyline = new google.maps.Polyline({
                path: latlng,
                strokeColor: 'blue',
                map: map
            });
            console.log("Polyline drawn");
            polylines.push(polyline);
        }

        var donpolyline;
        var donpolylines = [];
        var xmlDon = new XMLHttpRequest();
        var donTasksUrl = "get_don_tasks.php";

        xmlDon.open("GET", donTasksUrl, true);

        xmlDon.onload = function () {
            if (this.readyState == 4 && this.status == 200) {
                var get_don_tasks = JSON.parse(this.responseText);
                console.log("Tasks:", get_don_tasks);

                for (var i = 0; i < get_don_tasks.length; i++) {
                    var usernameRes = get_don_tasks[i].username_res;
                    var carId = get_don_tasks[i].car_id;
                    var destLat = get_don_tasks[i].destination_lat;
                    var destLng = get_don_tasks[i].destination_lng;

                    console.log("Processing task:", get_don_tasks[i]);

                    var carMarker = carMarkersById[carId];
                    if (carMarker) {
                        console.log("Drawing polyline for car " + carId);
                        drawDonPolyline(carMarker, destLat, destLng);
                    }
                }
            }
        };

        xmlDon.send();

        function drawDonPolyline(carMarker, destLat, destLng) {
            var latitude = carMarker.getPosition().lat();
            var longitude = carMarker.getPosition().lng();

            var donlatlng = [
                { lat: latitude, lng: longitude },
                { lat: Number(destLat), lng: Number(destLng) }
            ];
            console.log("Polyline coordinates:", donlatlng);

            donpolyline = new google.maps.Polyline({
                path: donlatlng,
                strokeColor: 'green',
                map: map
            });
            console.log("Polyline drawn");
            donpolylines.push(donpolyline);
        }

        document.getElementById('filter1').addEventListener('change', function() {
            var isChecked = document.getElementById("filter1").checked;

            requestMarkers.forEach(marker => {
                var isTakenRequest = polylines.some(polyline => {
                    return polyline.getPath().getArray().some(latlng => samePosition(latlng, marker.getPosition()));
                });

                if (isChecked && isTakenRequest) {
                    marker.setMap(map);
                } else {
                    marker.setMap(null);
                }
            });

            carMarkers.forEach(marker => marker.setMap(null));
            donationMarkers.forEach(marker => marker.setMap(null));
        });

        document.getElementById('filter2').addEventListener('change', function() {
            var isChecked = document.getElementById("filter2").checked;

            requestMarkers.forEach(marker => {
                var isWaitingRequest = !polylines.some(polyline => {
                    return polyline.getPath().getArray().some(latlng => samePosition(latlng, marker.getPosition()));
                });

                if (isChecked && isWaitingRequest) {
                    marker.setMap(map);
                } else {
                    marker.setMap(null);
                }
            });

            carMarkers.forEach(marker => marker.setMap(null));
            donationMarkers.forEach(marker => marker.setMap(null));
        });

        document.getElementById('filter3').addEventListener('change', function() {
            var isChecked = document.getElementById("filter3").checked;

            if (isChecked) {
                donationMarkers.forEach(marker => marker.setMap(map));
                requestMarkers.forEach(marker => marker.setMap(null));
            } else {
                donationMarkers.forEach(marker => marker.setMap(null));
            }

            carMarkers.forEach(marker => marker.setMap(null));
        });

        document.getElementById('filter4').addEventListener('change', function () {
            var isChecked = document.getElementById("filter4").checked;
            if (isChecked) {
                carMarkers.forEach(marker => {
                    var carId = marker.getTitle().split(' ')[1];
                    var hasTask = tasks.some(task => task.car_id === carId);
                    if (hasTask) {
                        marker.setMap(map);
                    } else {
                        marker.setMap(null);
                    }
                });
            } else {
                carMarkers.forEach(marker => marker.setMap(map));
            }
        });

        document.getElementById('filter5').addEventListener('change', function () {
            var isChecked = document.getElementById("filter5").checked;
            if (isChecked) {
                carMarkers.forEach(marker => {
                    var carId = marker.getTitle().split(' ')[1];
                    var hasTask = tasks.some(task => task.car_id === carId);
                    if (!hasTask) {
                        marker.setMap(map);
                    } else {
                        marker.setMap(null);
                    }
                });
            } else {
                carMarkers.forEach(marker => marker.setMap(map));
            }
        });

        document.getElementById('filter6').addEventListener('change', hideReqPolylines);

        function hideReqPolylines() {
            var isChecked = document.getElementById("filter6").checked;

            for (var i = 0; i < polylines.length; i++) {
                polylines[i].setMap(null);
            }

            polylines = [];
        }

        document.getElementById('filter7').addEventListener('change', hideDonPolylines);

        function hideDonPolylines() {
            var isChecked = document.getElementById("filter7").checked;

            for (var i = 0; i < donpolylines.length; i++) {
                donpolylines[i].setMap(null);
            }

            donpolylines = [];
        }

        }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
</body>
</html>
