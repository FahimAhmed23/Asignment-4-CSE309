<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="weather_info.css">
    <title>Weather Forecast</title>
</head>

<body>
    <section class="container">
        <h2>Weather Forecast</h2>

        <form method="post" action="">
            <label for="city">Enter City Name:</label>
            <input type="text" id="city" name="city" required>
            <input type="submit" value="Search">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $city = urlencode($_POST["city"]);
            $api_url = "https://api.openweathermap.org/data/2.5/forecast?q={$city}&appid=5d22eb04b7e182e914ae9e92986ebdb8&units=metric";

            $json_data = @file_get_contents($api_url);

            if ($json_data === false) {
                echo '<p>Please enter a valid city name!</p>';
            } else {
                $weather_data = json_decode($json_data, true);

                if ($weather_data && isset($weather_data['list'])) {
                    echo '<h3>5-Day Forecast for ' . $weather_data['city']['name'] . '</h3>';
                    echo '<table>';
                    echo '<tr><th>Date</th><th>Temperature (°C)</th><th>Feels Like (°C)</th><th>Min Temp (°C)</th><th>Max Temp (°C)</th></tr>';

                    foreach ($weather_data['list'] as $data) {
                        $date = date('Y-m-d H:i A', $data['dt']);
                        $tempIcon = "https://openweathermap.org/img/w/{$data['weather'][0]['icon']}.png";
                        echo '<tr>';
                        echo '<td>' . $date . '</td>';
                        echo '<td><img class="weather-icon" src="' . $tempIcon . '" alt="Temperature Icon">' . $data['main']['temp'] . '</td>';
                        echo '<td>' . $data['main']['feels_like'] . '</td>';
                        echo '<td>' . $data['main']['temp_min'] . '</td>';
                        echo '<td>' . $data['main']['temp_max'] . '</td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                }
            }
        }
        ?>
    </section>
</body>

</html>