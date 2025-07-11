<script src="admin/js/app.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Chart(document.getElementById("chartjs-mortality"), {
            type: "bar",
            data: {
                labels: ["Myocardial Infarction", "Pneumonia", "Cerebro Vascular Disease", "Kidney Disease", "Cancer"],
                datasets: [{
                    label: "Male",
                    backgroundColor: "#4A90E2",
                    borderColor: "#4A90E2",
                    data: [123, 102, 77, 63, 31]
                }, {
                    label: "Female",
                    backgroundColor: "#FF4081",
                    borderColor: "#FF4081",
                    data: [105, 88, 91, 51, 58]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        new Chart(document.getElementById("chartjs-morbidity"), {
            type: "bar",
            data: {
                labels: ["Animal Bite", "Acute Respiratory Infection", "Hypertension", "Skin Diseases", "Punctured/Lacerated Wound"],
                datasets: [{
                    label: "Male",
                    backgroundColor: "#4A90E2",
                    borderColor: "#4A90E2",
                    data: [4904, 2241, 927, 583, 667]
                }, {
                    label: "Female",
                    backgroundColor: "#FF4081",
                    borderColor: "#FF4081",
                    data: [6056, 3064, 1429, 649, 374]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
        // Line chart
        new Chart(document.getElementById("chartjs-dashboard-line"), {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Trend Line",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: window.theme.primary,
                    data: [
                        2115,
                        1562,
                        1584,
                        1892,
                        1587,
                        1923,
                        2566,
                        2448,
                        2805,
                        3438,
                        2917,
                        3327
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    intersect: false
                },
                hover: {
                    intersect: true
                },
                plugins: {
                    filler: {
                        propagate: false
                    }
                },
                scales: {
                    xAxes: [{
                        reverse: true,
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 1000
                        },
                        display: true,
                        borderDash: [3, 3],
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }]
                }
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pie chart
        new Chart(document.getElementById("chartjs-dashboard-pie"), {
            type: "pie",
            data: {
                labels: ["Chrome", "Firefox", "IE"],
                datasets: [{
                    data: [4306, 3801, 1689],
                    backgroundColor: [
                        window.theme.primary,
                        window.theme.warning,
                        window.theme.danger
                    ],
                    borderWidth: 5
                }]
            },
            options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                cutoutPercentage: 75
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize the map centered on Dagupan City
        var map = L.map('dagupanMap').setView([16.0439, 120.3333], 13);

        // Add OpenStreetMap tile layer (free)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // List of barangays with coordinates and population data
        var barangays = [
            { name: "Pugaro", coords: [16.06114, 120.31412], population: 12000 },
            { name: "Bonuan Gueset", coords: [16.0654, 120.3660], population: 18000 },
            { name: "Malued", coords: [16.0482, 120.3387], population: 9000 },
            { name: "Tapuac", coords: [16.0455, 120.3356], population: 7500 },
            { name: "Caranglaan", coords: [16.0523, 120.3312], population: 11000 },
            { name: "Lucao", coords: [16.0592, 120.3295], population: 9500 },
            { name: "Bolosan", coords: [16.0563, 120.3221], population: 8700 },
            { name: "Bacayao Norte", coords: [16.0551, 120.3420], population: 6500 },
            { name: "Bacayao Sur", coords: [16.0520, 120.3405], population: 7800 },
            { name: "Tapuac", coords: [16.0485, 120.3359], population: 8200 }
        ];

        // Add markers for each barangay
        barangays.forEach(function(barangay) {
            // Add marker for the barangay
            L.marker(barangay.coords).addTo(map)
                .bindPopup(`<b>${barangay.name}</b><br>Population: ${barangay.population}`);

            // Add population label above the marker
            L.marker(barangay.coords, {
                icon: L.divIcon({
                    className: 'population-label',
                    html: `<b>${barangay.population}</b>`,
                    iconSize: [40, 20],
                    iconAnchor: [20, -10]  // Adjusts position to be above the marker
                })
            }).addTo(map);
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Bar chart
        new Chart(document.getElementById("chartjs-dashboard-bar"), {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "This year",
                    backgroundColor: window.theme.primary,
                    borderColor: window.theme.primary,
                    hoverBackgroundColor: window.theme.primary,
                    hoverBorderColor: window.theme.primary,
                    data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
                    barPercentage: .75,
                    categoryPercentage: .5
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                        },
                        stacked: false,
                        ticks: {
                            stepSize: 20
                        }
                    }],
                    xAxes: [{
                        stacked: false,
                        gridLines: {
                            color: "transparent"
                        }
                    }]
                }
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var markers = [{
                coords: [31.230391, 121.473701],
                name: "Shanghai"
            },
            {
                coords: [28.704060, 77.102493],
                name: "Delhi"
            },
            {
                coords: [6.524379, 3.379206],
                name: "Lagos"
            },
            {
                coords: [35.689487, 139.691711],
                name: "Tokyo"
            },
            {
                coords: [23.129110, 113.264381],
                name: "Guangzhou"
            },
            {
                coords: [40.7127837, -74.0059413],
                name: "New York"
            },
            {
                coords: [34.052235, -118.243683],
                name: "Los Angeles"
            },
            {
                coords: [41.878113, -87.629799],
                name: "Chicago"
            },
            {
                coords: [51.507351, -0.127758],
                name: "London"
            },
            {
                coords: [40.416775, -3.703790],
                name: "Madrid "
            }
        ];
        var map = new jsVectorMap({
            map: "world",
            selector: "#world_map",
            zoomButtons: true,
            markers: markers,
            markerStyle: {
                initial: {
                    r: 9,
                    strokeWidth: 7,
                    stokeOpacity: .4,
                    fill: window.theme.primary
                },
                hover: {
                    fill: window.theme.primary,
                    stroke: window.theme.primary
                }
            },
            zoomOnScroll: false
        });
        window.addEventListener("resize", () => {
            map.updateSize();
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
        var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
        document.getElementById("datetimepicker-dashboard").flatpickr({
            inline: true,
            prevArrow: "<span title=\"Previous month\">&laquo;</span>",
            nextArrow: "<span title=\"Next month\">&raquo;</span>",
            defaultDate: defaultDate
        });
    });
</script>