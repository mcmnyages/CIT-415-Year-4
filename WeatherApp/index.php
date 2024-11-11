<?php
require_once 'config.php';
require_once 'WeatherService.php';

$weatherData = null;
$error = null;

// Initialize WeatherService with API key and URL
$weatherService = new WeatherService(API_KEY, API_BASE_URL);

if (isset($_POST['city'])) {
    try {
        // Fetch and format weather data
        $rawData = $weatherService->getWeatherByCity($_POST['city']);
        $weatherData = $weatherService->formatWeatherData($rawData);

        if (!$weatherData) {
            $error = "Unable to fetch weather data for the specified city.";
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Convert data and error to JSON
$jsonWeatherData = json_encode($weatherData);
$jsonError = json_encode($error);

// AJAX response for JavaScript
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode([
        'data' => $weatherData,
        'error' => $error
    ]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen py-12 px-4">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Weather Forecast</h1>

            <!-- Weather Form -->
            <form id="weatherForm" method="POST">
                <div class="flex gap-2">
                    <input type="text" name="city" placeholder="Enter city name" class="flex-1 px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none">Search</button>
                </div>
            </form>

            <!-- Weather Result Section -->
            <div id="weatherResult" class="space-y-4 hidden">
                <div class="text-center">
                    <h2 class="text-xl font-semibold text-gray-800" id="cityName"></h2>
                    <p class="text-4xl font-bold text-gray-900 my-2" id="temperature"></p>
                    <p class="text-gray-600" id="description"></p>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-gray-600">Humidity</p>
                        <p class="text-lg font-semibold" id="humidity"></p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-gray-600">Wind Speed</p>
                        <p class="text-lg font-semibold" id="windSpeed"></p>
                    </div>
                </div>
            </div>

            <!-- Error Message Section -->
            <div id="errorMessage" class="text-red-500 mt-4 text-center hidden"></div>
        </div>
    </div>

    <!-- JavaScript to handle form submission and display -->
    <script>
        document.getElementById('weatherForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);

            try {
                const response = await fetch('', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                const result = await response.json();
                
                if (result.error) {
                    document.getElementById('errorMessage').textContent = result.error;
                    document.getElementById('errorMessage').classList.remove('hidden');
                    document.getElementById('weatherResult').classList.add('hidden');
                } else {
                    document.getElementById('errorMessage').classList.add('hidden');
                    document.getElementById('weatherResult').classList.remove('hidden');
                    
                    const data = result.data;
                    document.getElementById('cityName').textContent = `${data.cityName}, ${data.country}`;
                    document.getElementById('temperature').textContent = `${data.temperature}°C`;
                    document.getElementById('description').textContent = data.description;
                    document.getElementById('humidity').textContent = `${data.humidity}%`;
                    document.getElementById('windSpeed').textContent = `${data.windSpeed} m/s`;
                }
            } catch (error) {
                document.getElementById('errorMessage').textContent = 'An error occurred while fetching weather data.';
                document.getElementById('errorMessage').classList.remove('hidden');
                document.getElementById('weatherResult').classList.add('hidden');
            }
        });
    </script>
</body>
</html>
