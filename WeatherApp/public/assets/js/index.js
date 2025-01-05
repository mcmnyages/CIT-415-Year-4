document.getElementById('weatherForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);

    try {
        const response = await fetch('index.php', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        
        const result = await response.json();
        
        if ( result.error) {
            document.getElementById('errorMessage').textContent = result.error;
            document.getElementById('errorMessage').classList.remove('hidden');
            document.getElementById('weatherResult').classList.add('hidden');
        } else {
            document.getElementById('errorMessage').classList.add('hidden');
            document.getElementById('weatherResult').classList.remove('hidden');
            
            const data = result.data;

            document.getElementById('longtitude').textContent= `${data.longtitude}`;
            document.getElementById('latitude').textContent= `${data.latitude}`;
            document.getElementById('cityName').textContent = `${data.cityName},   ${data.country}`;
            document.getElementById('temperature').textContent = `${data.temperature}°C`;
            document.getElementById('description').textContent = data.description;
            document.getElementById('humidity').textContent = `${data.humidity}%`;
            document.getElementById('windSpeed').textContent = `${data.windSpeed} m/s`;
            document.getElementById('description').textContent = data.description;
            document.getElementById('feelsLike').textContent = `${data.feelsLike}°C`;
            document.getElementById('weatherIcon').src = `http://openweathermap.org/img/w/${data.weatherIcon}.png`;
        }
    } catch (error) {
        document.getElementById('errorMessage').textContent = 'An error occurred while fetching weather data.';
        document.getElementById('errorMessage').classList.remove('hidden');
        document.getElementById('weatherResult').classList.add('hidden');
    }
});