<?php
require_once 'config.php';
require_once 'WeatherService.php';

$weatherData = null;
$error = null;

$weatherService = new WeatherService(API_KEY, API_BASE_URL);

if (isset($_POST['city'])) {
    try {
        $rawData = $weatherService->getWeatherByCity($_POST['city']);
        $weatherData = $weatherService->formatWeatherData($rawData);

        if (!$weatherData) {
            $error = "Unable to fetch weather data for the specified city.";
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'data' => $weatherData,
                'error' => $error
            ]);
            exit;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'data' => null,
                'error' => $error
            ]);
            exit;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .loading {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .weather-icon {
            font-size: 2rem;
            text-align: center;
            margin: 0.5rem 0;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-12 px-4">
    <div class="max-w-md mx-auto glass-card overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Weather Forecast</h1>
            
            <form id="weatherForm" method="POST" class="mb-6">
                <div class="relative">
                    <input type="text" 
                           name="city" 
                           placeholder="Enter city name" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                           required>
                    <button type="submit" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-blue-500 hover:text-blue-700">
                        🔍
                    </button>
                </div>
            </form>

            <div class="loading">
                <div class="loading-spinner"></div>
            </div>

            <div id="weatherResult" class="space-y-4 <?php echo isset($weatherData) && $weatherData ? '' : 'hidden'; ?>">
                <div class="text-center">
                    <h2 class="text-xl font-semibold text-gray-800" id="cityName">
                        <?php echo isset($weatherData) ? "{$weatherData['cityName']}, {$weatherData['country']}" : ''; ?>
                    </h2>
                    <div class="weather-icon">
                        <?php echo isset($weatherData) ? $weatherData['icon'] : ''; ?>
                    </div>
                    <p class="text-4xl font-bold text-gray-900 my-2" id="temperature">
                        <?php echo isset($weatherData) ? "{$weatherData['temperature']}°C" : ''; ?>
                    </p>
                    <p class="text-gray-600" id="description">
                        <?php echo isset($weatherData) ? $weatherData['description'] : ''; ?>
                    </p>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-gray-600">Humidity 💧</p>
                        <p class="text-lg font-semibold" id="humidity">
                            <?php echo isset($weatherData) ? "{$weatherData['humidity']}%" : ''; ?>
                        </p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <p class="text-gray-600">Wind Speed 🌪️</p>
                        <p class="text-lg font-semibold" id="windSpeed">
                            <?php echo isset($weatherData) ? "{$weatherData['windSpeed']} m/s" : ''; ?>
                        </p>
                    </div>
                </div>
                
                <?php if (isset($weatherData)): ?>
                <div class="text-center text-sm text-gray-500 mt-4">
                    Last updated: <?php echo date('Y-m-d H:i:s'); ?>
                </div>
                <?php endif; ?>
            </div>

            <div id="errorMessage" class="text-red-500 mt-4 text-center <?php echo isset($error) && $error ? '' : 'hidden'; ?>">
                <?php echo isset($error) ? $error : ''; ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('weatherForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const loadingEl = document.querySelector('.loading');
            const resultEl = document.getElementById('weatherResult');
            const errorEl = document.getElementById('errorMessage');
            
            loadingEl.style.display = 'block';
            if (resultEl) resultEl.style.opacity = '0.5';
            errorEl.classList.add('hidden');

            try {
                const formData = new FormData(form);
                const response = await fetch('', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                const result = await response.json();
                
                if (result.error) {
                    errorEl.textContent = result.error;
                    errorEl.classList.remove('hidden');
                    resultEl.classList.add('hidden');
                } else {
                    const data = result.data;
                    document.getElementById('cityName').textContent = `${data.cityName}, ${data.country}`;
                    document.getElementById('temperature').textContent = `${data.temperature}°C`;
                    document.getElementById('description').textContent = data.description;
                    document.getElementById('humidity').textContent = `${data.humidity}%`;
                    document.getElementById('windSpeed').textContent = `${data.windSpeed} m/s`;
                    
                    errorEl.classList.add('hidden');
                    resultEl.classList.remove('hidden');
                }
            } catch (error) {
                errorEl.textContent = 'An error occurred while fetching weather data.';
                errorEl.classList.remove('hidden');
                resultEl.classList.add('hidden');
            } finally {
                loadingEl.style.display = 'none';
                if (resultEl) resultEl.style.opacity = '1';
            }
        });
    </script>
</body>
</html>
