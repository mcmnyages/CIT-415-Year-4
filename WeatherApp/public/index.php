<?php
require_once '../includes/config.php';
require_once '../includes/WeatherService.php';

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

require 'index.html'

?>
