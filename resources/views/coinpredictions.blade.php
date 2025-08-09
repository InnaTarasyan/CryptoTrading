@extends('layouts.base')
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
    .prediction-card { 
        background: #fff; 
        border-radius: 1.5em; 
        box-shadow: 0 4px 24px rgba(67,206,162,0.08); 
        margin-bottom: 2em; 
        padding: 2em; 
        transition: all 0.3s ease;
    }
    
    .prediction-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 32px rgba(67,206,162,0.15);
    }
    
    .prediction-title { 
        font-size: 1.5em; 
        font-weight: 700; 
        color: #222; 
        margin-bottom: 0.5em; 
    }
    
    .chart-container { 
        position: relative; 
        height: 350px; 
        margin-bottom: 1.5em; 
    }
    
    .legend-dot { 
        display: inline-block; 
        width: 12px; 
        height: 12px; 
        border-radius: 50%; 
        margin-right: 6px; 
    }

    /* Loading Interface Styles */
    .loading-container {
        min-height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 3rem;
        margin: 2rem 0;
        color: white;
        text-align: center;
    }

    .loading-spinner {
        width: 80px;
        height: 80px;
        border: 8px solid rgba(255, 255, 255, 0.3);
        border-top: 8px solid #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 2rem;
    }

    .loading-pulse {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
        background-size: 400% 400%;
        animation: pulse 2s ease-in-out infinite;
        margin-bottom: 2rem;
        position: relative;
    }

    .loading-pulse::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        z-index: 1;
    }

    .loading-pulse::before {
        content: '📊';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2rem;
        z-index: 2;
    }

    .loading-text {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .loading-subtext {
        font-size: 1.1rem;
        opacity: 0.9;
        line-height: 1.6;
    }

    .loading-progress {
        width: 100%;
        max-width: 400px;
        height: 8px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 4px;
        overflow: hidden;
        margin: 1rem 0;
    }

    .loading-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #4ecdc4, #44a08d);
        border-radius: 4px;
        animation: progress 3s ease-in-out infinite;
    }

    .loading-steps {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .loading-step {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .loading-step.active {
        background: rgba(255, 255, 255, 0.4);
        transform: scale(1.05);
    }

    /* Animations */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes pulse {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    @keyframes progress {
        0% { width: 0%; }
        50% { width: 70%; }
        100% { width: 100%; }
    }

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

    .fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Error state */
    .error-container {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        border-radius: 20px;
        padding: 3rem;
        margin: 2rem 0;
        color: white;
        text-align: center;
    }

    .error-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    /* Success state */
    .success-container {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        border-radius: 20px;
        padding: 2rem;
        margin: 2rem 0;
        color: white;
        text-align: center;
    }

    .success-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .loading-container {
            padding: 2rem 1rem;
            margin: 1rem 0;
        }
        
        .loading-spinner {
            width: 60px;
            height: 60px;
            border-width: 6px;
        }
        
        .loading-pulse {
            width: 80px;
            height: 80px;
        }
        
        .loading-text {
            font-size: 1.3rem;
        }
        
        .loading-subtext {
            font-size: 1rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Cryptocurrency Price Predictions</h2>

    <!-- Search Form: user-friendly input for coin name or symbol -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form id="coinSearchForm" class="row g-3 align-items-center" autocomplete="off">
                <div class="col-md-8">
                    <label for="coinQuery" class="form-label fw-semibold">Search coin by name or symbol</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-end-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242 1.656a5 5 0 1 1 0-10 5 5 0 0 1 0 10"/></svg></span>
                        <input list="coinSuggestions" type="text" class="form-control border-start-0" id="coinQuery" placeholder="Try: BTC, ETH, SOL or 'Bitcoin'" aria-describedby="searchHelp" required>
                        <datalist id="coinSuggestions">
                            <option value="BTC">
                            <option value="ETH">
                            <option value="BNB">
                            <option value="SOL">
                            <option value="ADA">
                            <option value="XRP">
                            <option value="DOGE">
                            <option value="LTC">
                            <option value="DOT">
                            <option value="LINK">
                            <option value="Bitcoin">
                            <option value="Ethereum">
                            <option value="Binance Coin">
                            <option value="Solana">
                            <option value="Cardano">
                            <option value="Ripple">
                            <option value="Dogecoin">
                            <option value="Litecoin">
                            <option value="Polkadot">
                            <option value="Chainlink">
                        </datalist>
                    </div>
                    <div id="searchHelp" class="form-text">Type a symbol (e.g., BTC) or a coin name (e.g., Bitcoin), then press Enter or click Search.</div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-lg w-100" id="coinSearchBtn">
                        <span class="default-label">Search & Predict</span>
                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true" id="coinSearchSpinner"></span>
                    </button>
                </div>
            </form>
            <div id="coinSearchFeedback" class="mt-3"></div>
        </div>
    </div>

    <!-- Dynamic single coin result will be injected here -->
    <div id="singlePredictionContainer" class="mb-4"></div>
    
    <!-- Loading Interface -->
    <div id="loadingInterface" class="loading-container">
        <div class="loading-pulse"></div>
        <div class="loading-text">Coin Price Predictions Loading...</div>
        <div class="loading-subtext">Analyzing market data and generating predictions for top cryptocurrencies</div>
        
        <div class="loading-progress">
            <div class="loading-progress-bar"></div>
        </div>
        
        <div class="loading-steps">
            <div class="loading-step active" id="step1">📊 Fetching Data</div>
            <div class="loading-step" id="step2">🧮 Calculating Predictions</div>
            <div class="loading-step" id="step3">📈 Generating Charts</div>
            <div class="loading-step" id="step4">✅ Ready!</div>
        </div>
    </div>

    <!-- Error Interface -->
    <div id="errorInterface" class="error-container" style="display: none;">
        <div class="error-icon">⚠️</div>
        <h3>Oops! Something went wrong</h3>
        <p id="errorMessage">We encountered an error while loading the predictions.</p>
        <button class="btn btn-light mt-3" onclick="retryLoading()">🔄 Try Again</button>
    </div>

    <!-- Success Interface -->
    <div id="successInterface" class="success-container" style="display: none;">
        <div class="success-icon">🎉</div>
        <h3>Predictions Loaded Successfully!</h3>
        <p>All cryptocurrency predictions have been generated and are ready to view.</p>
    </div>

    <!-- Results Container -->
    <div id="resultsContainer" style="display: none;">
        <div class="row" id="predictionsRow">
            <!-- Results will be populated here via AJAX -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Start loading process for top coins
    loadPredictions();

    // Wire up search form
    const form = document.getElementById('coinSearchForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        performCoinSearch();
    });
});

let currentStep = 1;
let loadingSteps = ['📊 Fetching Data', '🧮 Calculating Predictions', '📈 Generating Charts', '✅ Ready!'];

function performCoinSearch() {
    const input = document.getElementById('coinQuery');
    const btn = document.getElementById('coinSearchBtn');
    const spinner = document.getElementById('coinSearchSpinner');
    const feedback = document.getElementById('coinSearchFeedback');
    const container = document.getElementById('singlePredictionContainer');

    const query = (input.value || '').trim();
    if (!query) {
        input.focus();
        return;
    }

    // UI state
    btn.disabled = true;
    spinner.classList.remove('d-none');
    feedback.innerHTML = '';
    container.innerHTML = '';

    fetch(`/api/coin-prediction?query=${encodeURIComponent(query)}`)
        .then(r => {
            if (!r.ok) throw new Error(`HTTP ${r.status}`);
            return r.json();
        })
        .then(data => {
            if (!data.success || !data.result) {
                throw new Error(data.message || 'No data returned');
            }
            const result = data.result;
            // Render card and chart
            const html = createSingleResultCard(result);
            container.innerHTML = html;
            setTimeout(() => {
                initializeChartForResult(result, `chart-search-${result.symbol}`);
            }, 50);
        })
        .catch(err => {
            feedback.innerHTML = `<div class="alert alert-warning">Could not load prediction for "${query}". ${err.message}</div>`;
        })
        .finally(() => {
            btn.disabled = false;
            spinner.classList.add('d-none');
        });
}

function loadPredictions() {
    // Show loading interface
    document.getElementById('loadingInterface').style.display = 'flex';
    document.getElementById('errorInterface').style.display = 'none';
    document.getElementById('successInterface').style.display = 'none';
    document.getElementById('resultsContainer').style.display = 'none';

    // Simulate loading steps
    simulateLoadingSteps();

    // Make AJAX request
    fetch('/api/coin-predictions')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            // Hide loading interface
            document.getElementById('loadingInterface').style.display = 'none';
            
            // Show success message briefly
            showSuccessMessage();
            
            // Process and display results
            setTimeout(() => {
                displayResults(data);
            }, 1500);
        })
        .catch(error => {
            console.error('Error loading predictions:', error);
            showErrorMessage(error.message);
        });
}

function simulateLoadingSteps() {
    const steps = document.querySelectorAll('.loading-step');
    
    const stepInterval = setInterval(() => {
        if (currentStep <= steps.length) {
            // Update current step
            steps.forEach((step, index) => {
                if (index + 1 === currentStep) {
                    step.classList.add('active');
                } else if (index + 1 < currentStep) {
                    step.classList.remove('active');
                    step.style.background = 'rgba(255, 255, 255, 0.6)';
                }
            });
            
            currentStep++;
        } else {
            clearInterval(stepInterval);
        }
    }, 800);
}

function showSuccessMessage() {
    document.getElementById('successInterface').style.display = 'block';
}

function showErrorMessage(message) {
    document.getElementById('loadingInterface').style.display = 'none';
    document.getElementById('errorInterface').style.display = 'block';
    document.getElementById('errorMessage').textContent = message || 'We encountered an error while loading the predictions.';
}

function retryLoading() {
    currentStep = 1;
    loadPredictions();
}

function displayResults(data) {
    const resultsContainer = document.getElementById('resultsContainer');
    const predictionsRow = document.getElementById('predictionsRow');
    
    // Hide success message
    document.getElementById('successInterface').style.display = 'none';
    
    // Clear previous results
    predictionsRow.innerHTML = '';
    
    // Display results
    if (data.results && data.results.length > 0) {
        data.results.forEach((result, index) => {
            const resultHtml = createResultCard(result, index);
            predictionsRow.innerHTML += resultHtml;
        });
        
        // Show results container
        resultsContainer.style.display = 'block';
        
        // Initialize charts after a brief delay
        setTimeout(() => {
            initializeCharts(data.results);
        }, 100);
    } else {
        showErrorMessage('No prediction data available.');
    }
}

function createResultCard(result, index) {
    const lastPrice = result.history && result.history.length > 0 ? 
        `$${parseFloat(result.history[result.history.length - 1].rate).toFixed(4)}` : 'N/A';
    
    const predictionRange = result.predictions && result.predictions.length > 0 ? 
        `$${parseFloat(result.predictions[0].predicted_price).toFixed(4)} - $${parseFloat(result.predictions[result.predictions.length - 1].predicted_price).toFixed(4)}` : 'N/A';
    
    const marketCap = result.market_cap ? `$${parseInt(result.market_cap).toLocaleString()}` : 'N/A';
    const volume24h = result.volume_24h ? `$${parseInt(result.volume_24h).toLocaleString()}` : 'N/A';
    const volatility = result.volatility ? parseFloat(result.volatility).toFixed(4) : 'N/A';
    
    return `
        <div class="col-lg-6 col-md-12 mb-4 fade-in-up" style="animation-delay: ${index * 0.1}s;">
            <div class="card shadow prediction-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="prediction-title flex-grow-1">${result.symbol} / USD</div>
                    </div>
                    <div class="chart-container mb-3">
                        <canvas id="chart-${result.symbol}"></canvas>
                    </div>
                    <div class="mb-2">
                        <span class="legend-dot" style="background:#43cea2;"></span> Historical
                        <span class="legend-dot" style="background:#ffd200;"></span> Internal Prediction
                        <span class="legend-dot" style="background:#ff6a88;"></span> External Prediction
                    </div>
                    <div class="mb-2">
                        <b>Last Price:</b> ${lastPrice}<br>
                        <b>Next 7d Model Prediction:</b> ${predictionRange}<br>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <span class="badge bg-primary">Market Cap</span><br>
                            <span>${marketCap}</span>
                        </div>
                        <div class="col-4">
                            <span class="badge bg-success">24h Volume</span><br>
                            <span>${volume24h}</span>
                        </div>
                        <div class="col-4">
                            <span class="badge bg-warning text-dark">Volatility</span><br>
                            <span>${volatility}</span>
                        </div>
                    </div>
                    <div class="alert alert-info p-2 mt-2">
                        <small>
                            <b>Info:</b> Predictions are for informational purposes only. Internal predictions use mathematical regression on historical data.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function createSingleResultCard(result) {
    const lastPrice = result.history && result.history.length > 0 ? 
        `$${parseFloat(result.history[result.history.length - 1].rate).toFixed(4)}` : 'N/A';
    const predictionRange = result.predictions && result.predictions.length > 0 ? 
        `$${parseFloat(result.predictions[0].predicted_price).toFixed(4)} - $${parseFloat(result.predictions[result.predictions.length - 1].predicted_price).toFixed(4)}` : 'N/A';
    const marketCap = result.market_cap ? `$${parseInt(result.market_cap).toLocaleString()}` : 'N/A';
    const volume24h = result.volume_24h ? `$${parseInt(result.volume_24h).toLocaleString()}` : 'N/A';
    const volatility = result.volatility ? parseFloat(result.volatility).toFixed(4) : 'N/A';

    return `
        <div class="card shadow prediction-card fade-in-up">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="prediction-title flex-grow-1">Search: ${result.symbol} / USD</div>
                </div>
                <div class="chart-container mb-3">
                    <canvas id="chart-search-${result.symbol}"></canvas>
                </div>
                <div class="mb-2">
                    <span class="legend-dot" style="background:#43cea2;"></span> Historical
                    <span class="legend-dot" style="background:#ffd200;"></span> Internal Prediction
                    <span class="legend-dot" style="background:#ff6a88;"></span> External Prediction
                </div>
                <div class="mb-2">
                    <b>Last Price:</b> ${lastPrice}<br>
                    <b>Next 7d Model Prediction:</b> ${predictionRange}<br>
                </div>
                <div class="row mb-2">
                    <div class="col-4">
                        <span class="badge bg-primary">Market Cap</span><br>
                        <span>${marketCap}</span>
                    </div>
                    <div class="col-4">
                        <span class="badge bg-success">24h Volume</span><br>
                        <span>${volume24h}</span>
                    </div>
                    <div class="col-4">
                        <span class="badge bg-warning text-dark">Volatility</span><br>
                        <span>${volatility}</span>
                    </div>
                </div>
                <div class="alert alert-info p-2 mt-2">
                    <small>
                        <b>Info:</b> Predictions are for informational purposes only. Internal predictions use mathematical regression on historical data.
                    </small>
                </div>
            </div>
        </div>`
}

function initializeCharts(results) {
    results.forEach((result) => {
        if (!result.history || result.history.length === 0) return;
        const canvasId = `chart-${result.symbol}`;
        initializeChartForResult(result, canvasId);
    });
}

function initializeChartForResult(result, canvasId) {
    const ctx = document.getElementById(canvasId);
    if (!ctx) return;

    const history = result.history || [];
    const predictions = result.predictions || [];
    const external = result.external || [];

    // Prepare data
    let labels = history.map(x => x.date);
    let histPrices = history.map(x => x.rate);
    let predLabels = predictions.map(x => x.date);
    let predPrices = predictions.map(x => x.predicted_price);
    let extLabels = Array.isArray(external) ? external.map(x => x.date) : [];
    let extPrices = Array.isArray(external) ? external.map(x => x.predicted_price) : [];

    // Merge for full X axis
    let allLabels = labels.concat(predLabels.filter(d => !labels.includes(d)));

    // Datasets
    let internalPredictionData = [];
    if (labels.length > 0) {
        internalPredictionData = Array(labels.length - 1).fill(null)
            .concat([histPrices[histPrices.length - 1]])
            .concat(predPrices);
    }

    let datasets = [
        {
            label: 'Historical',
            data: histPrices,
            borderColor: '#43cea2',
            backgroundColor: 'rgba(67,206,162,0.1)',
            pointRadius: 2,
            fill: false,
            tension: 0.1,
            spanGaps: true,
        },
        {
            label: 'Internal Prediction',
            data: internalPredictionData,
            borderColor: '#ffd200',
            backgroundColor: 'rgba(255,210,0,0.1)',
            borderDash: [6, 4],
            pointRadius: 2,
            fill: false,
            tension: 0.1,
            spanGaps: true,
        }
    ];

    if (extPrices.length > 0) {
        // Align external predictions to the same X axis
        let extData = Array(labels.length).fill(null);
        extLabels.forEach((d, i) => {
            let idx = allLabels.indexOf(d);
            if (idx !== -1) extData[idx] = extPrices[i];
        });
        datasets.push({
            label: 'External Prediction',
            data: extData.concat(extPrices),
            borderColor: '#ff6a88',
            backgroundColor: 'rgba(255,106,136,0.1)',
            borderDash: [2, 2],
            pointRadius: 2,
            fill: false,
            tension: 0.1,
            spanGaps: true,
        });
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: allLabels.concat(predLabels.filter(d => !allLabels.includes(d))),
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            },
            scales: {
                x: { display: true, title: { display: true, text: 'Date' } },
                y: { display: true, title: { display: true, text: 'Price (USD)' } }
            }
        }
    });
}
</script>
@endsection