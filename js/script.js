let map, userMarker, userLocation, directionsService, directionsRenderer;

// Initialize and add the map
function initMap() {
    const luukSulu = { lat: 5.9646, lng: 121.2787 };

    // Create the map centered on Luuk, Sulu
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: luukSulu,
    });

    // Initialize Directions Service and Renderer
    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer();
    directionsRenderer.setMap(map);
    directionsRenderer.setPanel(document.getElementById("directions-panel"));

    // Add a marker for Luuk, Sulu
    new google.maps.Marker({
        position: luukSulu,
        map: map,
        title: "Luuk, Sulu",
    });

    // Automatically locate the user when the page loads
    locateUser();

    // Initialize the gallery interactivity
    initGalleryInteraction();
}

function locateUser() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };

                // Center the map on the user's location
                map.setCenter(userLocation);

                // Add or update the user's location marker
                if (userMarker) {
                    userMarker.setPosition(userLocation);
                } else {
                    userMarker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: "Your Location",
                        icon: {
                            url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                        },
                    });
                }

                // Update distance to the selected destination if available
                if (window.selectedDestination) {
                    updateDistance(userLocation, window.selectedDestination);
                }
            },
            () => {
                alert("Unable to retrieve your location.");
            }
        );
    } else {
        alert("Geolocation is not supported by your browser.");
    }
}

function initGalleryInteraction() {
    const images = document.querySelectorAll(".gallery img");
    images.forEach((img) => {
        img.addEventListener("click", () => {
            const lat = parseFloat(img.getAttribute("data-lat"));
            const lng = parseFloat(img.getAttribute("data-lng"));

            // Ensure the map is initialized
            if (map) {
                // Center map on the clicked location
                const destination = { lat, lng };
                map.setCenter(destination);

                // Add a marker for the destination
                new google.maps.Marker({
                    position: destination,
                    map: map,
                    title: img.alt,
                });

                // Save the destination location for directions
                window.selectedDestination = destination;

                // Update distance if user's location is available
                if (userLocation) {
                    updateDistance(userLocation, destination);
                    getDirections(); // Automatically get directions after selecting a destination
                } else {
                    document.getElementById("distance").textContent = "Your location is being retrieved. Please wait...";
                }
            } else {
                alert("Map is not initialized.");
            }
        });
    });
}

function getDirections() {
    if (userLocation && window.selectedDestination) {
        const request = {
            origin: userLocation,
            destination: window.selectedDestination,
            travelMode: google.maps.TravelMode.DRIVING, // or WALKING, BICYCLING, TRANSIT
        };

        directionsService.route(request, (result, status) => {
            if (status === google.maps.DirectionsStatus.OK) {
                directionsRenderer.setDirections(result);
            } else {
                alert("Directions request failed due to " + status);
            }
        });
    } else {
        alert("Select a destination and ensure your location is available.");
    }
}

function updateDistance(userLocation, destination) {
    const distance = calculateDistance(
        userLocation.lat,
        userLocation.lng,
        destination.lat,
        destination.lng
    );

    // Display distance in a div
    document.getElementById("distance").textContent = `Distance from your location: ${distance.toFixed(2)} km`;
}

// Function to calculate the distance between two coordinates using the Haversine formula
function calculateDistance(lat1, lng1, lat2, lng2) {
    const R = 6371; // Radius of the Earth in kilometers
    const dLat = deg2rad(lat2 - lat1);
    const dLng = deg2rad(lng2 - lng1);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
        Math.sin(dLng / 2) * Math.sin(dLng / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c; // Distance in kilometers
}

function deg2rad(deg) {
    return deg * (Math.PI / 180);
}

// Wait for the DOM content to load before attaching event listeners
document.addEventListener("DOMContentLoaded", () => {
    initMap();
});
