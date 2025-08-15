<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Health Office Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>
<body>

<style>
    :root {
        --primary-color: #2563eb;
        --secondary-color: #1e40af;
        --accent-color: #3b82f6;
        --success-color: #059669;
        --danger-color: #dc2626;
        --warning-color: #d97706;
        --info-color: #0891b2;
        --light-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: var(--text-primary);
        position: relative;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.2) 0%, transparent 50%);
        z-index: -1;
    }

    .main-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        margin: 0px;
        padding: 32px;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .dashboard-header {
        text-align: center;
        margin-bottom: 48px;
        position: relative;
    }

    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 2px;
    }

    .dashboard-title {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-bottom: 8px;
    }

    .dashboard-subtitle {
        color: var(--text-secondary);
        font-size: 1.125rem;
        font-weight: 500;
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 32px;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--border-color);
        position: relative;
    }

    .section-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
        font-size: 20px;
        color: white;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        box-shadow: var(--shadow-md);
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        letter-spacing: -0.01em;
    }

    .section-description {
        color: var(--text-secondary);
        font-size: 0.95rem;
        margin-top: 4px;
        font-weight: 500;
    }

    .stats-card {
        background: var(--card-bg);
        border-radius: 20px;
        padding: 24px;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }

    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: var(--accent-color);
    }

    .card-header-modern {
        display: flex;
        justify-content: between;
        align-items: flex-start;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        line-height: 1.4;
    }

    .card-subtitle {
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 4px;
    }

    .card-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        color: white;
        font-size: 16px;
        flex-shrink: 0;
    }

    .chart-container {
        position: relative;
        height: 320px;
        margin-top: 16px;
    }

    .chart-container canvas {
        border-radius: 12px;
    }

    /* Immunization specific colors */
    .immunization-card::before {
        background: linear-gradient(90deg, var(--success-color), #10b981);
    }

    .immunization-card .card-icon {
        background: linear-gradient(135deg, var(--success-color), #10b981);
    }

    /* Morbidity specific colors */
    .morbidity-card::before {
        background: linear-gradient(90deg, var(--warning-color), #f59e0b);
    }

    .morbidity-card .card-icon {
        background: linear-gradient(135deg, var(--warning-color), #f59e0b);
    }

    /* Mortality specific colors */
    .mortality-card::before {
        background: linear-gradient(90deg, var(--danger-color), #ef4444);
    }

    .mortality-card .card-icon {
        background: linear-gradient(135deg, var(--danger-color), #ef4444);
    }

    /* Vital statistics specific colors */
    .vital-stats-card::before {
        background: linear-gradient(90deg, var(--info-color), #06b6d4);
    }

    .vital-stats-card .card-icon {
        background: linear-gradient(135deg, var(--info-color), #06b6d4);
    }

    /* Responsive design improvements */
    @media (max-width: 768px) {
        .main-container {
            margin: 10px;
            padding: 20px;
            border-radius: 16px;
        }
        
        .dashboard-title {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .stats-card {
            margin-bottom: 20px;
        }
        
        .chart-container {
            height: 280px;
        }
    }

    /* Loading animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stats-card {
        animation: fadeInUp 0.6s ease-out;
    }

    .stats-card:nth-child(1) { animation-delay: 0.1s; }
    .stats-card:nth-child(2) { animation-delay: 0.2s; }
    .stats-card:nth-child(3) { animation-delay: 0.3s; }
    .stats-card:nth-child(4) { animation-delay: 0.4s; }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--light-bg);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--secondary-color);
    }
</style>

<div class="main-container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="dashboard-title">
            <i class="fas fa-hospital-user me-3"></i>
            CITY HEALTH OFFICE
        </h1>
        <p class="dashboard-subtitle">Administrative Overview & Health Statistics Dashboard</p>
    </div>

    <!-- Admin Overview Section -->
    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-chart-line"></i>
        </div>
        <div>
            <h2 class="section-title">ADMINISTRATIVE OVERVIEW</h2>
            <p class="section-description">Real-time health system performance metrics</p>
        </div>
    </div>

    <!-- Immunization Section -->
    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-syringe"></i>
        </div>
        <div>
            <h2 class="section-title">IMMUNIZATION PROGRAMS</h2>
            <p class="section-description">Vaccination coverage and distribution statistics</p>
        </div>
    </div>

    <div class="row g-4">
        @foreach($immunizationData as $data)
        <div class="col-12 col-xl-6">
            <div class="stats-card immunization-card">
                <div class="card-header-modern">
                    <div>
                        <h3 class="card-title">{{ $data->vaccine_name }} Vaccination</h3>
                        <p class="card-subtitle">
                            <i class="fas fa-calendar-alt me-2"></i>{{ $data->date }}
                        </p>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-shield-virus"></i>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="chart-{{ $data->id }}"></canvas>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Morbidity & Mortality Section -->
    <div class="section-header mt-5">
        <div class="section-icon">
            <i class="fas fa-heartbeat"></i>
        </div>
        <div>
            <h2 class="section-title">MORBIDITY & MORTALITY</h2>
            <p class="section-description">Disease patterns and mortality trends analysis</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-6">
            <div class="stats-card morbidity-card">
                <div class="card-header-modern">
                    <div>
                        <h3 class="card-title">Morbidity Cases</h3>
                        <p class="card-subtitle">
                            <i class="fas fa-user-injured me-2"></i>Gender-based case distribution
                        </p>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-procedures"></i>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="morbidityCasesChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="stats-card mortality-card">
                <div class="card-header-modern">
                    <div>
                        <h3 class="card-title">Mortality Cases</h3>
                        <p class="card-subtitle">
                            <i class="fas fa-cross me-2"></i>Gender-based mortality statistics
                        </p>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-memorial"></i>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="mortalityCasesChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Vital Statistics Section -->
    <div class="section-header mt-5">
        <div class="section-icon">
            <i class="fas fa-users"></i>
        </div>
        <div>
            <h2 class="section-title">VITAL STATISTICS & POPULATION</h2>
            <p class="section-description">Population dynamics and demographic trends</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-6">
            <div class="stats-card vital-stats-card">
                <div class="card-header-modern">
                    <div>
                        <h3 class="card-title">Population Growth</h3>
                        <p class="card-subtitle">
                            <i class="fas fa-chart-area me-2"></i>Annual population trends
                        </p>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="populationChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="stats-card vital-stats-card">
                <div class="card-header-modern">
                    <div>
                        <h3 class="card-title">Birth and Death Rates</h3>
                        <p class="card-subtitle">
                            <i class="fas fa-baby me-2"></i>Live births vs total deaths
                        </p>
                    </div>
                    <div class="card-icon">
                        <i class="fas fa-baby"></i>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="birthDeathChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Enhanced Chart.js default configuration
    Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif";
    Chart.defaults.font.size = 12;
    Chart.defaults.color = '#64748b';
    Chart.defaults.plugins.legend.labels.usePointStyle = true;
    Chart.defaults.plugins.legend.labels.boxHeight = 6;

    document.addEventListener("DOMContentLoaded", function() {
        // Enhanced color palettes
        const colorPalettes = {
            immunization: {
                primary: ['#059669', '#10b981'],
                gradient: 'linear-gradient(135deg, #059669, #10b981)'
            },
            morbidity: {
                primary: ['#3b82f6', '#ec4899'],
                secondary: ['#1e40af', '#be185d']
            },
            mortality: {
                primary: ['#1e40af', '#be185d'],
                secondary: ['#1e3a8a', '#9d174d']
            },
            vital: {
                population: '#3b82f6',
                births: '#059669',
                deaths: '#dc2626'
            }
        };

        // Common chart options
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        padding: 20,
                        font: {
                            weight: '600'
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        font: {
                            weight: '500'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9'
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        font: {
                            weight: '500'
                        }
                    }
                }
            },
            elements: {
                bar: {
                    borderRadius: 6
                }
            }
        };

        // Immunization charts
        @foreach($immunizationData as $data)
            new Chart(document.getElementById("chart-{{ $data->id }}"), {
                type: "bar",
                data: {
                    labels: ["Male", "Female"],
                    datasets: [{
                        label: "Number Vaccinated",
                        backgroundColor: colorPalettes.immunization.primary,
                        borderColor: colorPalettes.immunization.primary,
                        borderWidth: 2,
                        data: [{{ $data->male_vaccinated }}, {{ $data->female_vaccinated }}]
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        ...commonOptions.plugins,
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#059669',
                            borderWidth: 1
                        }
                    }
                }
            });
        @endforeach

        // Morbidity chart
        new Chart(document.getElementById("morbidityCasesChart"), {
            type: "bar",
            data: {
                labels: {!! json_encode($morbidityCases->pluck('case_name')) !!},
                datasets: [{
                    label: "Male",
                    backgroundColor: colorPalettes.morbidity.primary[0],
                    borderColor: colorPalettes.morbidity.secondary[0],
                    borderWidth: 2,
                    data: {!! json_encode($morbidityCases->pluck('male_count')) !!}
                }, {
                    label: "Female",
                    backgroundColor: colorPalettes.morbidity.primary[1],
                    borderColor: colorPalettes.morbidity.secondary[1],
                    borderWidth: 2,
                    data: {!! json_encode($morbidityCases->pluck('female_count')) !!}
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#d97706',
                        borderWidth: 1
                    }
                }
            }
        });

        // Mortality chart
        new Chart(document.getElementById("mortalityCasesChart"), {
            type: "bar",
            data: {
                labels: {!! json_encode($mortalityCases->pluck('case_name')) !!},
                datasets: [{
                    label: "Male",
                    backgroundColor: colorPalettes.mortality.primary[0],
                    borderColor: colorPalettes.mortality.secondary[0],
                    borderWidth: 2,
                    data: {!! json_encode($mortalityCases->pluck('male_count')) !!}
                }, {
                    label: "Female",
                    backgroundColor: colorPalettes.mortality.primary[1],
                    borderColor: colorPalettes.mortality.secondary[1],
                    borderWidth: 2,
                    data: {!! json_encode($mortalityCases->pluck('female_count')) !!}
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#dc2626',
                        borderWidth: 1
                    }
                }
            }
        });

        // Population chart
        new Chart(document.getElementById("populationChart"), {
            type: "line",
            data: {
                labels: {!! json_encode($vitalStatisticsData->pluck('year')) !!},
                datasets: [{
                    label: "Total Population",
                    borderColor: colorPalettes.vital.population,
                    backgroundColor: colorPalettes.vital.population + '20',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: colorPalettes.vital.population,
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    data: {!! json_encode($vitalStatisticsData->pluck('total_population')) !!}
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#0891b2',
                        borderWidth: 1
                    }
                }
            }
        });

        // Birth and Death chart
        new Chart(document.getElementById("birthDeathChart"), {
            type: "bar",
            data: {
                labels: {!! json_encode($vitalStatisticsData->pluck('year')) !!},
                datasets: [
                    { 
                        label: "Live Births", 
                        backgroundColor: colorPalettes.vital.births,
                        borderColor: colorPalettes.vital.births,
                        borderWidth: 2,
                        data: {!! json_encode($vitalStatisticsData->pluck('total_live_births')) !!}
                    },
                    { 
                        label: "Total Deaths", 
                        backgroundColor: colorPalettes.vital.deaths,
                        borderColor: colorPalettes.vital.deaths,
                        borderWidth: 2,
                        data: {!! json_encode($vitalStatisticsData->pluck('total_deaths')) !!}
                    }
                ]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#0891b2',
                        borderWidth: 1
                    }
                }
            }
        });
    });
</script>

</body>
</html>