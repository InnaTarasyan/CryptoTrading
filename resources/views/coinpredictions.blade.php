@extends('layouts.base')
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
    /*.prediction-card { background: #fff; border-radius: 1.5em; box-shadow: 0 4px 24px rgba(67,206,162,0.08); margin-bottom: 2em; padding: 2em; }*/
    /*.prediction-title { font-size: 1.5em; font-weight: 700; color: #222; margin-bottom: 0.5em; }*/
    /*.chart-container { position: relative; height: 350px; margin-bottom: 1.5em; }*/
    /*.legend-dot { display: inline-block; width: 12px; height: 12px; border-radius: 50%; margin-right: 6px; }*/
</style>
@endsection
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Cryptocurrency Price Predictions (AI + Advanced Models)</h2>
    @if(!empty($errors))
        <div class="alert alert-warning">
            @foreach($errors as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
    @endif
    <div class="row">
        @foreach($results as $result)
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="card shadow prediction-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="prediction-title flex-grow-1">{{ $result['symbol'] }} / USD</div>
                        </div>
                        <div class="chart-container mb-3">
                            <canvas id="chart-{{ $result['symbol'] }}"></canvas>
                        </div>
                        <div class="mb-2">
                            <span class="legend-dot" style="background:#43cea2;"></span> Historical
                            <span class="legend-dot" style="background:#ffd200;"></span> Internal Prediction
                            <span class="legend-dot" style="background:#ff6a88;"></span> AI/External Prediction
                        </div>
                        <div class="mb-2">
                            <b>Last Price:</b> @if($result['history']->count()) ${{ number_format($result['history']->last()['rate'], 4) }} @else N/A @endif<br>
                            <b>Next 7d Model Prediction:</b> @if($result['predictions']) ${{ number_format($result['predictions'][0]['predicted_price'] ?? 0, 4) }} - ${{ number_format($result['predictions'][count($result['predictions'])-1]['predicted_price'] ?? 0, 4) }} @else N/A @endif<br>
                            <b>External AI Prediction:</b> @if($result['external']) ${{ number_format($result['external'][0]['predicted_price'] ?? 0, 4) }} - ${{ number_format($result['external'][count($result['external'])-1]['predicted_price'] ?? 0, 4) }} @else N/A @endif
                        </div>
                        <div class="row mb-2">
                            <div class="col-4">
                                <span class="badge bg-primary">Market Cap</span><br>
                                <span>@if($result['market_cap']) ${{ number_format($result['market_cap'], 0) }} @else N/A @endif</span>
                            </div>
                            <div class="col-4">
                                <span class="badge bg-success">24h Volume</span><br>
                                <span>@if($result['volume_24h']) ${{ number_format($result['volume_24h'], 0) }} @else N/A @endif</span>
                            </div>
                            <div class="col-4">
                                <span class="badge bg-warning text-dark">Volatility (30d)</span><br>
                                <span>@if($result['volatility']) ${{ number_format($result['volatility'], 4) }} @else N/A @endif</span>
                            </div>
                        </div>
                        <div class="alert alert-info p-2 mt-2">
                            <small>
                                <b>Info:</b> Predictions are for informational purposes only. Internal predictions use polynomial regression on the last 60 days. External predictions are from Cryptics.tech AI.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @foreach($results as $result)
        (function() {
            const history = @json($result['history']);
            if (!history.length) return; // Skip chart if no historical data
            const ctx = document.getElementById('chart-{{ $result['symbol'] }}').getContext('2d');
            const predictions = @json($result['predictions']);
            const external = @json($result['external']);
            // X axis: dates (history + predictions)
            let labels = history.map(x => x.date);
            let histPrices = history.map(x => x.rate);
            let predLabels = predictions.map(x => x.date);
            let predPrices = predictions.map(x => x.predicted_price);
            let extLabels = external ? external.map(x => x.date) : [];
            let extPrices = external ? external.map(x => x.predicted_price) : [];
            // Merge for full X axis
            let allLabels = labels.concat(predLabels.filter(d => !labels.includes(d)));
            // Datasets
            let internalPredictionData = [];
            if (labels.length > 0) {
                internalPredictionData = Array(labels.length-1).fill(null)
                    .concat([histPrices[histPrices.length-1]])
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
                    borderDash: [6,4],
                    pointRadius: 2,
                    fill: false,
                    tension: 0.1,
                    spanGaps: true,
                }
            ];
            if (extPrices.length) {
                // Align external predictions to the same X axis
                let extData = Array(labels.length).fill(null);
                extLabels.forEach((d, i) => {
                    let idx = allLabels.indexOf(d);
                    if (idx !== -1) extData[idx] = extPrices[i];
                });
                datasets.push({
                    label: 'AI/External Prediction',
                    data: extData.concat(extPrices),
                    borderColor: '#ff6a88',
                    backgroundColor: 'rgba(255,106,136,0.1)',
                    borderDash: [2,2],
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
        })();
    @endforeach
});
</script>
@endsection