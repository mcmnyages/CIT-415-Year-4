<?php
class WeatherService {
    private $apiKey;
    private $baseUrl;

    public function __construct($apiKey, $baseUrl) {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    public function getWeatherByCity($city) {
        $url = sprintf(
            '%s?q=%s&appid=%s&units=metric',
            $this->baseUrl,
            urlencode($city),
            $this->apiKey
        );

        $response = @file_get_contents($url); // Use @ to suppress warnings

        if (!$response) {
            throw new Exception("Failed to fetch data from OpenWeatherMap. Check your network connection or API URL.");
        }

        $data = json_decode($response, true);

        // Check for API error responses
        if (isset($data['cod']) && $data['cod'] != 200) {
            throw new Exception("OpenWeatherMap API Error: " . $data['message']);
        }

        return $data;
    }

    public function formatWeatherData($data) {
        if (!isset($data['main']) || !isset($data['weather'][0])) {
            return null;
        }

        return [
            'temperature' => round($data['main']['temp']),
            'description' => ucfirst($data['weather'][0]['description']),
            'humidity' => $data['main']['humidity'],
            'windSpeed' => $data['wind']['speed'],
            'cityName' => $data['name'],
            'country' => $data['sys']['country']
        ];
    }
}
