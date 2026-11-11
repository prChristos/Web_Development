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
     <script src = "https://code.jquery.com/jquery-3.6.4.min.js"></script>
     <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
     <style>
        #map {position: center; height: 400px; padding-left: 200px; padding-right: 500px; padding-top: 500px; max-width: 500px;}
    .box{justify-content: center; align-items: center;}
    .menu {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }

    .btn {
        padding: 5px 10px;
        font-size: 16px;
    }
    </style>
    <link rel="stylesheet" href="style/style.css">
    <title>Menu Διασώστη</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p>Menu Διασώστη</p>
        </div>

        <div class="right-links">
            <?php
                $username = $_SESSION['username'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE username='$username'");
                $queryy = mysqli_query($con,"SELECT*FROM diasostes WHERE username='$username'");

                while($result = mysqli_fetch_assoc($query)){
                    $res_usname = $result['username'];
                    $res_name = $result['name'];
    
                }
        
                while($result = mysqli_fetch_assoc($queryy)){
                    $car_id = $result['car_id'];
    
                }
                $_SESSION['name'] = $res_usname;
                $_SESSION['carid'] = $car_id;  
            ?>
            
            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>

        </div>
    </div>
    <main>

        <div class="main-box top">
           <div class="top">
             <div class="box">
                 <p>Name: <b><?php echo $res_name ?></b>, username: <b><?php echo $res_usname ?></b>, car id: <b><?php echo $car_id?></b></p>
                 <input type="hidden" id="currentUsername" value="<?php echo htmlspecialchars($username); ?>">
                 <input type="hidden" id="carId" value="<?php echo htmlspecialchars($car_id); ?>">
             </div>
             <hr>
            <div class="menu">
            <hr>
            <a href = "diasostisHome.php"><button class = "btn">Αρχική</button></a><hr><a href = "diasostisMap.php"><button class = "btn">Χάρτης</button></a> 
            </hr>
            <hr></hr>
          </div>
          <hr>

        </div>
        <hr>
        <hr>
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
      <input type="checkbox" id="filter4"> Hide Request polylines
   </label>
   <span> | </span>
   <label>
      <input type="checkbox" id="filter5"> Hide Donation polylines
   </label>
</div>
            <div class="map" id="map">Χάρτης</div>
            <hr><hr><br>
            <div class="panel">
                <section class="panel_header">
                    <h2>Task List</h2>
                </section>    
                <section class="panel_body">
                    <table border=1>
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Mobile</th>
                                <th>Item</th>
                                <th>Quantity(per indivdual)</th>
                                <th>Task Reg Date</th>
                                <th>Status</th> 
                            </tr>
                        </thead>
                        <tbody id="data">
                            <tr>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </div> 
            <style>
                div[class="panel"] {width: 82vw; height: 90vh; background-color: #fff5; backdrop-filter: blur(7px); box-shadow: 0 .4rem .8rem #0005; border-radius: .8rem; overflow: hidden;}
                section[class="panel_header"] {width: 100%; height: 10%; backgraound-color: #fff4; padding .8rem .1rem; }
                section[class="panel_body"] {width: 95%; max-height: calc(85% - .8rem); background-color: #fffb; margin: .8rem auto; border-radius: .6rem; vertical-align: middle; overflow: auto;}
                #panel, th, td {border-collapse: collapse; padding: 1rem;}
                #thead th {position: sticky; top: 0; left: 0; background-color: #d5d1defe;}
            </style>
        </div>
        
     </main>
     
     <script>

     function initMap() {

        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 38.246, lng: 21.735 },
            zoom: 13
        });

        const marker = new google.maps.Marker({
            position: { lat: 38.246, lng: 21.735 },
            map: map,
            title: "Βάση"
        });

        function makeIcon(url) {
            return {
                url: url,
                scaledSize: new google.maps.Size(32, 32),
                anchor: new google.maps.Point(16, 16)
            };
        }

        var carIcon = makeIcon('car-svgrepo-com.svg');
        var wait_ait = makeIcon('marker-16.png');
        var rescuerIcon = makeIcon('person.png');
        var takenReq = makeIcon('takenRequest.png');
        var takenDon = makeIcon('takenDonation.png');

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

        function toPath(pairs) {
            return pairs.map(function (c) {
                return { lat: Number(c[0]), lng: Number(c[1]) };
            });
        }

        function fitPolyline(pl) {
            var bounds = new google.maps.LatLngBounds();
            pl.getPath().forEach(function (pt) { bounds.extend(pt); });
            map.fitBounds(bounds);
        }

        function samePosition(a, b) {
            return Math.abs(a.lat() - b.lat()) < 1e-9 && Math.abs(a.lng() - b.lng()) < 1e-9;
        }

        var xhr = new XMLHttpRequest();
        var method = "GET";
        var url = "load_info_diasosti.php";
        var asynchronous = true;

        xhr.open(method, url, asynchronous);

        xhr.send();

        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var res = JSON.parse(this.responseText);
                for (var i = 0; i < res.length; i++) {

                    var latitude = Number(res[i].latitude);
                    var longitude = Number(res[i].longitude);

                    var resMarker = new google.maps.Marker({
                        position: { lat: latitude, lng: longitude },
                        map: map,
                        title: "Η θέση μου",
                        icon: rescuerIcon
                    });
                }
            }
        }

        var latlng = [];
        var donlatlng = [];

        var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "load_car_diasosti.php";
        var asynchronous = true;

        var defaultLatitude;
        var defaultLongitude;

        ajax.open(method, url, asynchronous);

        ajax.send();

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var car = JSON.parse(this.responseText);
                let carMarkers = [];
                for (var i = 0; i < car.length; i++) {
                    var username = car[i].username;
                    var latitude = car[i].latitude;
                    var longitude = car[i].longitude;

                    var savedPosition = JSON.parse(localStorage.getItem('carPosition_' + username));

                    if (savedPosition) {
                        latitude = savedPosition.lat;
                        longitude = savedPosition.lng;
                    }

                    latlng.push([latitude, longitude]);
                    donlatlng.push([latitude, longitude]);
                    
                    const thisCar = new google.maps.Marker({
                        position: { lat: Number(latitude), lng: Number(longitude) },
                        map: map,
                        title: "Όχημα: " + username,
                        icon: carIcon,
                        draggable: true
                    });
                    bindPopup(thisCar, "Username: " + username);

                    thisCar.addListener('dragend', function (event) {
                        var confirmed = window.confirm('Are you sure you want to change the car\'s position?');
                        if (confirmed) {
                            var newCarPosition = { lat: event.latLng.lat(), lng: event.latLng.lng() };
                            console.log('New Car Position:', newCarPosition);

                            var oldIndex = latlng.findIndex(coord => coord[0] === latitude && coord[1] === longitude);
                            if (oldIndex !== -1) {
                                latlng.splice(oldIndex, 1);
                            }

                            latlng.push([newCarPosition.lat, newCarPosition.lng]);

                            var oldIndexdon = donlatlng.findIndex(coords => coords[0] === latitude && coords[1] === longitude);
                            if (oldIndexdon !== -1) {
                                donlatlng.splice(oldIndexdon, 1);
                            }

                            donlatlng.push([newCarPosition.lat, newCarPosition.lng]);

                            localStorage.setItem('carPosition_' + username, JSON.stringify(newCarPosition));
                        } else {
                            thisCar.setPosition({ lat: Number(latitude), lng: Number(longitude) });
                        }
                    });
                }
                
            }
        }
        var donationMarkers = [];
        var requestMarkers = [];
        var polylines = [];
        var donpolylines = [];

        var xml = new XMLHttpRequest();
        var method = "GET";
        var url = "get_aithmata.php";
        var asynchronous = true;

        xml.open(method, url, asynchronous);

        xml.send();

        xml.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var ait = JSON.parse(this.responseText);

                for (var username in ait) {
                    var userAithma = ait[username];

                    var popupContent = "";
                    for (var i = 0; i < userAithma.length; i++) {
                        var aithma = userAithma[i];
                        popupContent += "Όνομα: " + aithma.onoma + "<br>Κινητό: " + aithma.mobile + "<br>Προϊόν: " + aithma.proion + "<br>Ποσότητα: " + aithma.atoma + "<br>Ημερομηνία Αίτησης: " + aithma.hmerominia_aitisis + "<br><button class='btn' onclick='handleButtonClick(\"" + username + "\", " + aithma.latitude + "," + aithma.longitude + ", \"" + aithma.proion + "\", \"" + aithma.onoma + "\", " + aithma.mobile + ", " + aithma.atoma + ")'>Ανάληψη</button><br><hr><br>";
                    }
                
                    var latitude = Number(userAithma[0].latitude);
                    var longitude = Number(userAithma[0].longitude);

                    var storedIconState = JSON.parse(localStorage.getItem('aithmaIconState_' + username));
                    var markerIcon = storedIconState ? storedIconState : wait_ait;

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

        var carId = document.getElementById('carId').value;
        var polyline;

        function handleButtonClick(username, latitude, longitude, proion, onoma, mobile, atoma) {
            var checkIfTaken = new XMLHttpRequest();
                var checkIfTakenUrl = "checkTasks.php";
                var checkIfTakenData = "latitude=" + latitude + "&longitude=" + longitude + "&proion=" + proion;

                checkIfTaken.open("GET", checkIfTakenUrl + "?" + checkIfTakenData, true);
                checkIfTaken.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                checkIfTaken.onreadystatechange = function () {
                    if (checkIfTaken.readyState === 4) {
                        if (checkIfTaken.status === 200) {
                            var response = JSON.parse(checkIfTaken.responseText);

                            if (response.hasOwnProperty('message') && response.message === 'No task has been taken') {
                                const confirmYes = confirm("None has taken this task. Do you want to take it?");
                                if(confirmYes){
                                    latlng.push([latitude, longitude]);
                                    if(!polyline){
                                        polyline = new google.maps.Polyline({ path: toPath(latlng), strokeColor: "blue", map: map });
                                    }else{
                                        polyline.setPath(toPath(latlng));
                                    }
                                    polylines.push(polyline);

                                    fitPolyline(polyline);
                                    localStorage.setItem(currentUsername + "_polylineCoords", JSON.stringify(latlng));

                                    var updateRequest = new XMLHttpRequest();
                                    var updateMethod = "POST";
                                    var url = "update_requests.php";

                                    updateRequest.open(updateMethod, url, true);
                                    updateRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                    updateRequest.send("latitude=" + latitude + "&longitude=" + longitude + "&proion=" + proion +  "&carId=" + carId + "&username=" + currentUsername + "&onoma=" + onoma + "&mobile=" + mobile + "&atoma=" + atoma);
                                    updateRequest.onreadystatechange = function () {
                                        if (updateRequest.readyState === 4 && updateRequest.status === 200){
                                            alert("Request accepted successfully!");
                                            var markerIndex = aithmaMarkers.findIndex(function(marker) {
        var markerLatLng = marker.getPosition();
        return markerLatLng.lat() === latitude && markerLatLng.lng() === longitude;
    });

    if (markerIndex !== -1) {
        aithmaMarkers[markerIndex].setIcon(takenReq);

        localStorage.setItem('aithmaIconState_' + username, JSON.stringify(takenReq));

        infoWindow.close();
    }
                                        }
                                    }

                                }
                            } else {
                                var res_username = response[0]['username_res'];
                                var citizenName = response[0]['citizen_name'];
                                var message = `The ${citizenName}'s request has already been taken by ${res_username}`;
                                alert(message);
                            }
                        } else {
                            console.log("Error: HTTP status code", checkIfTaken.status);
                            alert("Error: Unable to check task status.");
                        }
                    }
                };

                checkIfTaken.send();
            }

        var currentUsername = document.getElementById('currentUsername').value;
        var storedCoords = localStorage.getItem(currentUsername + "_polylineCoords");
        if (storedCoords) {
            latlng = JSON.parse(storedCoords);
            polyline = new google.maps.Polyline({ path: toPath(latlng), strokeColor: "blue", map: map });
            fitPolyline(polyline);
        }

        var wait_don = makeIcon('yellowMarker-16 .png');

        var don = new XMLHttpRequest();
        var method = "GET";
        var url = "get_dorees.php";
        var asynchronous = true;

        don.open(method, url, asynchronous);

        don.send();

        don.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var donations = JSON.parse(this.responseText);

                    for (var username in donations) {
                    var userDonations = donations[username];

                    var popupContent = "";
                    for (var i = 0; i < userDonations.length; i++) {
                        var donation = userDonations[i];
                        popupContent += "Όνομα: " + donation.onoma + "<br>Κινητό: " + donation.mobile + "<br>Προϊόν: " + donation.proion + "<br>Ποσότητα: " + donation.atoma + "<br>Ημερομηνία Αίτησης: " + donation.hmerominia_doreas + "<br><button class='btn' onclick='handleDonButtonClick(" + donation.latitude + "," + donation.longitude + ", \"" + donation.proion + "\", \"" + donation.onoma + "\", " + donation.mobile + ", " + donation.atoma + ")'>Ανάληψη</button><br><br>";
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
        var storedDonationsIconState = localStorage.getItem(currentUsername + '_donationsIconState');
        if (storedDonationsIconState) {
            var donationsIconState = JSON.parse(storedDonationsIconState);
            donationMarker.setIcon(donationsIconState);
        }
        
        var donpolyline;

        function handleDonButtonClick(latitude, longitude, proion, onoma, mobile, atoma) {
            var checkIfTaken = new XMLHttpRequest();
                var checkIfTakenUrl = "checkTasks.php";
                var checkIfTakenData = "latitude=" + latitude + "&longitude=" + longitude + "&proion=" + proion;

                checkIfTaken.open("GET", checkIfTakenUrl + "?" + checkIfTakenData, true);
                checkIfTaken.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                checkIfTaken.onreadystatechange = function () {
                    if (checkIfTaken.readyState === 4) {
                        if (checkIfTaken.status === 200) {
                            var response = JSON.parse(checkIfTaken.responseText);

                            if (response.hasOwnProperty('message') && response.message === 'No task has been taken') {
                                const confirmYes = confirm("None has taken this task. Do you want to take it?");
                                if(confirmYes){
                                    donlatlng.push([latitude, longitude]);
                                    if(!donpolyline){
                                        donpolyline = new google.maps.Polyline({ path: toPath(donlatlng), strokeColor: "green", map: map });
                                        
                                    }else{
                                        donpolyline.setPath(toPath(donlatlng));
                                    }
                                    donpolylines.push(donpolyline);

                                    fitPolyline(donpolyline);
                                    localStorage.setItem(currentUsername + "_donpolylineCoords", JSON.stringify(donlatlng));

                                    var updateRequest = new XMLHttpRequest();
                                    var updateMethod = "POST";
                                    var url = "update_donation.php";

                                    updateRequest.open(updateMethod, url, true);
                                    updateRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                    updateRequest.send("latitude=" + latitude + "&longitude=" + longitude + "&proion=" + proion +  "&carId=" + carId + "&username=" + currentUsername + "&onoma=" + onoma + "&mobile=" + mobile + "&atoma=" + atoma);
                                    updateRequest.onreadystatechange = function () {
                                        if (updateRequest.readyState === 4 && updateRequest.status === 200){
                                            alert("Donation accepted successfully!");
                                        }
                                    }

                                }
                            } else {
                                var res_username = response[0]['username_res'];
                                var citizenName = response[0]['citizen_name'];
                                var message = `The ${citizenName}'s donation has already been taken by ${res_username}`;
                                alert(message);
                            }
                        } else {
                            console.log("Error: HTTP status code", checkIfTaken.status);
                            alert("Error: Unable to check task status.");
                        }
                    }
                };

                checkIfTaken.send();
            }

        var donstoredCoords = localStorage.getItem(currentUsername + "_donpolylineCoords");
        if (donstoredCoords) {
            donlatlng = JSON.parse(donstoredCoords);
            donpolyline = new google.maps.Polyline({ path: toPath(donlatlng), strokeColor: "green", map: map });
            fitPolyline(donpolyline);
        }

    var ajax = new XMLHttpRequest();
        var method = "GET";
        var url = "getTasks.php";
        var asynchronous = true;

        ajax.open(method, url, asynchronous);

        ajax.send();

        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var data = JSON.parse(this.responseText);
                
                var html = "";
                for (var i = 0; i < data.length; i++) {
                    var taskId = data[i].id_task;
                    var taskType = data[i].eidos_task;
                    var citizen_name = data[i].citizen_name;
                    var citizen_mobile = data[i].citizen_mobile;
                    var proion = data[i].proion;
                    var atoma = data[i].atoma;
                    var hmerominia_analipsis = data[i].hmerominia_analipsis;
                    var task_status = data[i].task_status;
                        
                        html += "<tr id='row_" + taskId + "'>";
                        html += "<td>" + citizen_name + "</td>";
                        html += "<td>" + citizen_mobile + "</td>";
                        html += "<td>" + proion + "</td>";
                        html += "<td>" + atoma + "</td>";
                        html += "<td>" + hmerominia_analipsis + "</td>";
                        html += "<td>" + task_status + "</td>";
                        html += "<td><button onclick = 'completeTask(\"" + taskId + "\", \"" + taskType + "\", \"" + citizen_name + "\", \"" + citizen_mobile + "\", \"" + proion + "\", " + atoma + ")'><span class = 'tick-icon'>&#10003</span></button></td><td><button onclick = 'deleteTask(\"" + taskId + "\", \"" + taskType + "\", \"" + citizen_name + "\", \"" + citizen_mobile + "\", \"" + proion + "\")'><span class = 'delete-icon'>&#10007</span></button></td></tr>";
                }
                document.getElementById("data").innerHTML = html;
            }
        }

        function deleteTask(taskId, taskType, citizenName, citizenMobile, proion){
            var row = document.getElementById("row_" + taskId);
            row.parentNode.removeChild(row);
            
            if(taskType == 'Request'){
                if (polyline) {
                    polyline.setMap(null);
                    polyline = null;
                    localStorage.removeItem(currentUsername + "_polylineCoords");
                }

            }else{
                if (donpolyline) {
                    donpolyline.setMap(null);
                    donpolyline = null;
                    localStorage.removeItem(currentUsername + "_donpolylineCoords");
                }
            }

            var updateTasks = new XMLHttpRequest();
            var updateMethod = "POST";
            var url = "updateTasks.php";

            updateTasks.open(updateMethod, url, true);
            updateTasks.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            var params = "taskId=" + encodeURIComponent(taskId) + "&taskType=" + encodeURIComponent(taskType) + "&citizenName=" + encodeURIComponent(citizenName) + "&citizenMobile=" + encodeURIComponent(citizenMobile) + "&proion=" + encodeURIComponent(proion);
            updateTasks.send(params);
            updateTasks.onreadystatechange = function () {
                if (updateTasks.readyState === 4 && updateTasks.status === 200){
                    alert("Task deleted successfully!");
                    
                }
            }
        }

        function completeTask(taskId, taskType, citizenName, citizenMobile, proion, atoma){
            var row = document.getElementById("row_" + taskId);
            row.parentNode.removeChild(row);
            
            if(taskType == 'Request'){
                if (polyline) {
                    polyline.setMap(null);
                    polyline = null;
                    localStorage.removeItem(currentUsername + "_polylineCoords");
                }

            }else{
                if (donpolyline) {
                    donpolyline.setMap(null);
                    donpolyline = null;
                    localStorage.removeItem(currentUsername + "_donpolylineCoords");
                }
            }

            var updateTasks = new XMLHttpRequest();
            var updateMethod = "POST";
            var url = "completeTasks.php";

            updateTasks.open(updateMethod, url, true);
            updateTasks.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            var params = "carId" + encodeURIComponent(carId) +"&taskId=" + encodeURIComponent(taskId) + "&taskType=" + encodeURIComponent(taskType) + "&citizenName=" + encodeURIComponent(citizenName) + "&citizenMobile=" + encodeURIComponent(citizenMobile) + "&proion=" + encodeURIComponent(proion) + "&atoma" + encodeURIComponent(atoma);
            updateTasks.send(params);
            updateTasks.onreadystatechange = function () {
                if (updateTasks.readyState === 4 && updateTasks.status === 200){
                    alert("Task completed successfully!");
                    
                }
            }
        }

document.getElementById('filter1').addEventListener('change', function() {
    var isChecked = document.getElementById("filter1").checked;

    requestMarkers.forEach(marker => {
        var isTakenRequest = polylines.some(polyline => {
            return polyline.getPath().getArray().some(pt => samePosition(pt, marker.getPosition()));
        });

        if (isChecked && isTakenRequest) {
            marker.setMap(map);
        } else {
            marker.setMap(null);
        }
    });

    donationMarkers.forEach(marker => marker.setMap(null));
});

document.getElementById('filter2').addEventListener('change', function() {
    var isChecked = document.getElementById("filter2").checked;

    requestMarkers.forEach(marker => {
        var isWaitingRequest = !polylines.some(polyline => {
            return polyline.getPath().getArray().some(pt => samePosition(pt, marker.getPosition()));
        });

        if (isChecked && isWaitingRequest) {
            marker.setMap(map);
        } else {
            marker.setMap(null);
        }
    });

    donationMarkers.forEach(marker => marker.setMap(null));
});

document.getElementById('filter3').addEventListener('change', onlyDonMarkers);

function onlyDonMarkers() {
    var isChecked = document.getElementById("filter3").checked;

    requestMarkers.forEach(marker => marker.setMap(null));
}

document.getElementById('filter4').addEventListener('change', hideReqPolylines);

function hideReqPolylines() {
    var isChecked = document.getElementById("filter4").checked;

    for (var i = 0; i < polylines.length; i++) {
        polylines[i].setMap(null);
    }

    polylines = [];
}

document.getElementById('filter5').addEventListener('change', hideDonPolylines);

function hideDonPolylines() {
    var isChecked = document.getElementById("filter5").checked;

    for (var i = 0; i < donpolylines.length; i++) {
        donpolylines[i].setMap(null);
    }

    donpolylines = [];
}

fetch('drawReqPolylines.php')
    .then(response => response.json())
    .then(data => {
        console.log("Received data:", data);
        let uniqueTasks = new Map();

        data.forEach(task => {
            if (!uniqueTasks.has(task.id_task)) {
                uniqueTasks.set(task.id_task, task);
                
                console.log(`Task ID: ${task.id_task}, Lat: ${task.latitude}, Long: ${task.longitude}`);
                if (task.latitude && task.longitude && task.destination_lat && task.destination_lng) {
                    var taskLatLng = { lat: Number(task.destination_lat), lng: Number(task.destination_lng) };
                    var carLatLng = { lat: Number(task.latitude), lng: Number(task.longitude) };

                    let Reqlatlng = [];
                    Reqlatlng.push(taskLatLng, carLatLng);
                   
                    new google.maps.Polyline({ path: Reqlatlng, strokeColor: 'blue', map: map });
                }
            }
        });
    })
    .catch(error => console.error('Error loading the task data:', error));

window.handleButtonClick = handleButtonClick;
window.handleDonButtonClick = handleDonButtonClick;
window.deleteTask = deleteTask;
window.completeTask = completeTask;

     }

</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
</body>
</html>
