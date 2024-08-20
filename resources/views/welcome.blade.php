<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dunder Mifflin Museum Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container my-5">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Dunder Mifflin Museum Management</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <button class="btn btn-outline-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#loginModal">Login</button>
                </div>
            </div>
        </nav>
        <!-- Button Group Section -->
        <div class="container my-3">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button id="btn-search-museums" class="btn btn-secondary" title="Search Museums">
                    <i class="bi bi-search"></i> Search Museums
                </button>
                <button id="btn-add-museum" class="btn btn-secondary" title="Add Museum">
                    <i class="bi bi-plus-circle"></i> Add Museum
                </button>
                <button id="btn-upload-museums" class="btn btn-secondary" title="Upload Museums">
                    <i class="bi bi-upload"></i> Upload Museums
                </button>
                <button id="reset-map-btn" class="btn btn-primary" title="Reset Map">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset Map
                </button>
            </div>
        </div>

        <!-- Map Section -->
        <div class="container">
            <div id="map"></div>
        </div>

        <!-- Search Museums Section -->
        <div id="search-section" class="my-5">
            <h3>Search Museums</h3>
            <form id="search-form">
                <div class="mb-3">
                    <label for="search-municipality" class="form-label">Municipality</label>
                    <input type="text" class="form-control" id="search-municipality" required>
                </div>
                <div class="mb-3">
                    <label for="search-lat" class="form-label">Latitude</label>
                    <input type="number" step="any"class="form-control" id="search-lat" required>
                </div>
                <div class="mb-3">
                    <label for="search-long" class="form-label">Longitude</label>
                    <input type="number" step="any"class="form-control" id="search-long" required>
                </div>
                <div class="mb-3">
                    <label for="search-radius" class="form-label">Radius (optional)</label>
                    <input type="number" class="form-control" id="search-radius" value="5">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <ul id="search-results" class="list-group mt-3"></ul>
        </div>

        <!-- Add Museum Section -->
        <div id="add-museum-section" class="my-5">
            <h3>Add Museum</h3>
            <form id="add-museum-form">
                <div class="mb-3">
                    <label for="add-name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="add-name" required>
                </div>
                <div class="mb-3">
                    <label for="add-lat" class="form-label">Latitude</label>
                    <input type="number" step="any" class="form-control" id="add-lat" required>
                </div>
                <div class="mb-3">
                    <label for="add-long" class="form-label">Longitude</label>
                    <input type="number" step="any" class="form-control" id="add-long" required>
                </div>
                <div class="mb-3">
                    <label for="add-region" class="form-label">Region</label>
                    <input type="text" class="form-control" id="add-region" required>
                </div>
                <div class="mb-3">
                    <label for="add-province" class="form-label">Province</label>
                    <input type="text" class="form-control" id="add-province" required>
                </div>
                <div class="mb-3">
                    <label for="add-municipality" class="form-label">Municipality</label>
                    <input type="text" class="form-control" id="add-municipality" required>
                </div>
                <button type="submit" class="btn btn-success">Add Museum</button>
            </form>
        </div>

        <!-- Import Museums Section -->
        <div id="import-section" class="my-5">
            <h3>Import Museums from JSON</h3>
            <form id="import-form" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="import-file" class="form-label">Select JSON File</label>
                    <input type="file" class="form-control" id="import-file" accept=".json" required>
                </div>
                <button type="submit" class="btn btn-warning">Import Museums</button>
            </form>
        </div>

        <!-- Message Area -->
        <div id="message-area" class="mt-3"></div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modal-login-form">
                        <div class="mb-3">
                            <label for="modal-login-email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="modal-login-email" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal-login-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="modal-login-password" required>
                        </div>
                        <!-- Error message container -->
                        <div id="login-error-message" class="text-danger mb-3" style="display: none;"></div>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 1050;"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script>
        let token = '';
        let userEmail = '';

        // Initially hide all sections except the search section
        document.getElementById('add-museum-section').style.display = 'none';
        document.getElementById('import-section').style.display = 'none';

        // Button click event listeners to show/hide sections
        document.getElementById('btn-search-museums').addEventListener('click', () => {
            document.getElementById('search-section').style.display = 'block';
            document.getElementById('add-museum-section').style.display = 'none';
            document.getElementById('import-section').style.display = 'none';
        });

        document.getElementById('btn-add-museum').addEventListener('click', () => {
            document.getElementById('search-section').style.display = 'none';
            document.getElementById('add-museum-section').style.display = 'block';
            document.getElementById('import-section').style.display = 'none';
        });

        document.getElementById('btn-upload-museums').addEventListener('click', () => {
            document.getElementById('search-section').style.display = 'none';
            document.getElementById('add-museum-section').style.display = 'none';
            document.getElementById('import-section').style.display = 'block';
        });

        document.getElementById('reset-map-btn').addEventListener('click', () => {
            if (routingControl) {
                map.removeControl(routingControl);
                routingControl = null;
            }
            loadMuseumsOnMap();
        });

        // Array to hold map markers so they can be removed
        let mapMarkers = [];

        // Initialize the map
        const map = L.map('map').setView([41.9028, 12.4964], 6); // Focus on Rome, Italy

        // Load and display the tile layer on the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);


        // Initialize the routing control (but don't add it to the map yet)
        let routingControl = null;

        // Function to clear existing markers from the map
        function clearMapMarkers() {
            mapMarkers.forEach(marker => marker.remove());
            mapMarkers = [];
        }

        // Function to load and display museums on the map
        function loadMuseumsOnMap() {
            // Check if there are any markers on the map
            if (mapMarkers.length > 0) {
                clearMapMarkers(); // Clear existing markers only if there are any
            }
            axios.get('/api/museums')
                .then(response => {
                    const museums = response.data;
                    museums.forEach(museum => {
                        const marker = L.marker([museum.latitude, museum.longitude]).addTo(map);
                        marker.bindPopup(`<b>${museum.name}</b><br>${museum.municipality}, ${museum.region}`);
                        mapMarkers.push(marker); // Keep track of the markers
                    });

                    // Optionally reset the map view to the default
                    map.setView([41.9028, 12.4964], 6); // Default view: Rome, Italy
                })
                .catch(error => {
                    console.error('Error loading museums:', error);
                });
        }

        // Handle Search Museums
        document.getElementById('search-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            const municipality = document.getElementById('search-municipality').value;
            const latitude = parseFloat(document.getElementById('search-lat').value);
            const longitude = parseFloat(document.getElementById('search-long').value);
            const radius = parseFloat(document.getElementById('search-radius').value);

            // Check if the parsed values are valid numbers
            if (isNaN(latitude) || isNaN(longitude)) {
                showAlert('Latitude and Longitude must be valid numbers.', 'danger');
                return;
            }

            try {
                // Make the API request to search for museums
                const response = await axios.get('/api/museum', {
                    params: {
                        m: municipality,
                        latitude: latitude,
                        longitude: longitude,
                        r: radius
                    }
                });

                const results = response.data;
                clearMapMarkers(); // Clear existing markers from the map

                // Display the new markers on the map
                results.forEach(museum => {
                    const marker = L.marker([museum.latitude, museum.longitude]).addTo(map);
                    marker.bindPopup(
                        `<b>${museum.name}</b><br>${museum.municipality}, ${museum.region}`);
                    mapMarkers.push(marker); // Keep track of the new marker
                });

                // Optionally center the map around the search area
                if (results.length > 0) {
                    map.setView([latitude, longitude], 12); // Zoom level 12 to focus on the area
                }

                // Display results in the list
                const list = document.getElementById('search-results');
                list.innerHTML = '';
                results.forEach(museum => {
                    const item = document.createElement('li');
                    item.className =
                        'list-group-item d-flex justify-content-between align-items-center';
                    item.innerHTML = `
                    ${museum.name} - ${museum.municipality}, ${museum.region}
                    <button class="btn btn-outline-primary btn-sm geolocate-btn">
                        <i class="bi bi-geo-alt"></i> Navigate
                    </button>
                `;
                    list.appendChild(item);

                    // Add event listener to the geolocate button
                    item.querySelector('.geolocate-btn').addEventListener('click', () => {
                        navigateToMuseum(museum.latitude, museum.longitude);
                    });
                });

                showAlert('Search completed successfully!', 'success');

            } catch (error) {
                showAlert('Search failed. Please try again.', 'danger');
            }
        });

        // Function to navigate to a museum from the user's current location
        function navigateToMuseum(museumLat, museumLong) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const userLat = position.coords.latitude;
                    const userLong = position.coords.longitude;

                    // Remove any existing routing control
                    if (routingControl) {
                        map.removeControl(routingControl);
                    }

                    // Add routing control to the map
                    routingControl = L.Routing.control({
                        waypoints: [
                            L.latLng(userLat, userLong),
                            L.latLng(museumLat, museumLong)
                        ],
                        routeWhileDragging: true
                    }).addTo(map);

                    // Center the map on the user's current location
                    map.setView([userLat, userLong], 12);
                }, error => {
                    showAlert('Geolocation failed. Please allow access to your location.', 'danger');
                });
            } else {
                showAlert('Geolocation is not supported by this browser.', 'danger');
            }
        }

        // Event listener for the "Reset Map" button
        document.getElementById('reset-map-btn').addEventListener('click', () => {
            // Remove any existing routing control
            if (routingControl) {
                map.removeControl(routingControl);
                routingControl = null; // Reset the routingControl variable
            }

            loadMuseumsOnMap();
        });

        // Load museums when the page is loaded
        document.addEventListener('DOMContentLoaded', function() {
            loadMuseumsOnMap();
        });

        // Handle Login from Modal
        document.getElementById('modal-login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('modal-login-email').value;
            const password = document.getElementById('modal-login-password').value;

            try {
                const response = await axios.post('/api/login', {
                    email,
                    password
                });
                token = response.data.access_token;
                userEmail = email;

                // Close the modal
                const loginModalElement = document.getElementById('loginModal');
                const loginModal = bootstrap.Modal.getInstance(loginModalElement);
                loginModal.hide();

                // Update the navbar to show the user's email
                document.getElementById('navbarNav').innerHTML = `
            <span class="navbar-text">Logged in as ${userEmail}</span>
        `;

                showAlert('Logged in successfully!', 'success');

            } catch (error) {
                const errorMessageContainer = document.getElementById('login-error-message');
                errorMessageContainer.style.display = 'block';
                errorMessageContainer.textContent = error.response?.data?.message ||
                    'Login failed. Please check your credentials.';
            }
        });

        // Handle Add Museum
        document.getElementById('add-museum-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!token) {
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
                return;
            }

            const name = document.getElementById('add-name').value;
            const latitude = document.getElementById('add-lat').value;
            const longitude = document.getElementById('add-long').value;
            const region = document.getElementById('add-region').value;
            const province = document.getElementById('add-province').value;
            const municipality = document.getElementById('add-municipality').value;

            try {
                const response = await axios.post('/api/museum', {
                    name,
                    latitude,
                    longitude,
                    region,
                    province,
                    municipality
                }, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                showAlert('Museum added successfully!', 'success');
                loadMuseumsOnMap();
            } catch (error) {
                showAlert('Failed to add museum!', 'danger');

            }
        });

        // Handle Import Museums
        document.getElementById('import-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!token) {
                const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                loginModal.show();
                return;
            }

            const formData = new FormData();
            formData.append('file', document.getElementById('import-file').files[0]);

            try {
                const response = await axios.post('/api/museums/import', formData, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'multipart/form-data'
                    }
                });

                showAlert('Museums imported successfully!', 'success');
                loadMuseumsOnMap();
            } catch (error) {
                showAlert('Failed to import museums.', 'danger');
            }
        });

        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');

            // Create the alert div
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.style.position = 'relative';
            alertDiv.style.marginBottom = '10px';
            alertDiv.style.opacity = '0';
            alertDiv.style.transition = 'opacity 0.5s ease-in-out';

            alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

            // Append the alert to the container
            alertContainer.appendChild(alertDiv);

            // Trigger the slide-in animation
            setTimeout(() => {
                alertDiv.style.opacity = '1';
            }, 100);

            // Remove the alert after 4 seconds
            setTimeout(() => {
                alertDiv.style.opacity = '0';
                setTimeout(() => {
                    alertDiv.remove();
                }, 500); // Match the transition duration
            }, 4000);
        }
    </script>
</body>

</html>
