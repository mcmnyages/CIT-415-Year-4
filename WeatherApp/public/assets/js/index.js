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

            document.getElementById('weatherStatus').textContent= `${data.weatherStatus}`;
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




document.getElementById("weatherForm").addEventListener("submit", async function (event) {
    event.preventDefault();
    const cityName = event.target.city.value.trim();
    if (!cityName) return alert("Please enter a city name.");

    // Fetch and display city data
    await displayCityData(cityName);

    // You can also add weather fetching here if needed
});



async function fetchCityData(cityName) {
    const apiUrl = `https://en.wikipedia.org/api/rest_v1/page/summary/${cityName}`;
    try {
        const response = await fetch(apiUrl);
        if (!response.ok) throw new Error("City not found");
        const data = await response.json();

        // Adjust thumbnail quality if available
        if (data.thumbnail && data.thumbnail.source) {
            data.thumbnail.source = data.thumbnail.source.replace(
                /\/\d+px-/,
                "/800px-"
            );
        }

        if (data.originalimage && data.originalimage.source) {
            imageUrl = data.originalimage.source;
        } else if (data.thumbnail && data.thumbnail.source) {
            imageUrl = data.thumbnail.source.replace(/\/\d+px-/, "/3000px-");
        } else {
            imageUrl = "/public/assets/images/logos/white_on_black.png";
        }
        

        
        return data;
    } catch (error) {
        console.error("Error fetching city data:", error);
        return null;
    }
}





async function displayCityData(cityName) {
    const cityData = await fetchCityData(cityName);
    if (cityData) {

        document.getElementById("forId").classList.remove("hidden");
        document.getElementById("cityFacts").classList.remove("hidden");
        document.getElementById("cityTitle").textContent = cityData.title;
        document.getElementById("cityDescription").textContent = cityData.extract;

        // Set the background image of the target element
        const targetElement = document.getElementById("body");
        targetElement.style.backgroundImage = `url(${cityData.thumbnail ? cityData.thumbnail.source : "http://localhost/CIT%20415%20Year%204/WeatherApp/public/assets/images/logos/white_on_black.png"})`; // make sure you give a fall back image url
        targetElement.style.backgroundSize = "cover";
        targetElement.style.backgroundPosition = "center";
    } else {
        alert("City data could not be retrieved.");
    }
}




