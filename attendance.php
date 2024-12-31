<!DOCTYPE html>
<html>
<head>
    <title>Punch In/Out with Geolocation</title>
    <script>
        function updateTime(initialTime) {
            const now = initialTime ? new Date(initialTime) : new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const currentTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;

            document.getElementById('time').innerText = currentTime;
            document.getElementById('timeInput').value = currentTime;

            // Update the time every second
            setTimeout(() => updateTime(), 1000);
        }

        window.onload = function() {
            const initialTime = "<?php echo date('Y-m-d H:i:s'); ?>";
            updateTime(initialTime);
        };

        function getGeolocationAndPunch(action) {
            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const timestamp = new Date().toISOString();

                    getGeolocationDetails(action, timestamp, latitude, longitude);
                }, function(error) {
                    console.error("Geolocation error: " + error.message);
                    alert("Unable to fetch your location. Please try again.");
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function getGeolocationDetails(action, timestamp, latitude, longitude) {
            const geocodeUrl = `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`;

            fetch(geocodeUrl)
                .then(response => response.json())
                .then(data => {
                    console.log('Nominatim API Response:', data); // Log the response

                    if (data && data.address) {
                        const address = data.address;
                        const city = address.city || address.town || address.village || '';
                        const area = address.suburb || address.neighbourhood || '';

                        sendPunchData(action, timestamp, latitude, longitude, city, area);
                    } else {
                        console.error('Geocode error: Invalid response data');
                        alert('Unable to fetch location details.');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Unable to fetch location details. Please try again.');
                });
        }

        function sendPunchData(action, timestamp, latitude, longitude, city, area) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "punch.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };
            xhr.send(`action=${action}&timestamp=${timestamp}&latitude=${latitude}&longitude=${longitude}&city=${city}&area=${area}`);
        }
    </script>
</head>
<body>
    <h1>Punch In/Out</h1>
    <button onclick="getGeolocationAndPunch('in')">Punch In</button>
    <button onclick="getGeolocationAndPunch('out')">Punch Out</button>
    <p><span id="time"></span></p>
    <input type="text" id="timeInput" value="">
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $timestamp = $_POST['timestamp'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $city = $_POST['city'];
    $area = $_POST['area'];

    // Save the punch data to the database or perform any other necessary action
    // For demonstration purposes, we'll just echo the received data

    echo "Action: $action<br>";
    echo "Timestamp: $timestamp<br>";
    echo "Latitude: $latitude<br>";
    echo "Longitude: $longitude<br>";
    echo "City: $city<br>";
    echo "Area: $area<br>";
}
?>
