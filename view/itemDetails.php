<div style="max-width: 600px; margin: 20px auto; font-family: sans-serif;">
    <?php if ($item): ?>
        <h2>Item Details</h2>
        <ul style="list-style: none; padding: 0;">
            <li><strong>ID:</strong> <?= htmlspecialchars($item->id) ?></li>
            <li><strong>Name:</strong> <?= htmlspecialchars($item->name) ?></li>
            <li><strong>Price:</strong> <?= $item->price !== null ? '$' . number_format($item->price, 2) : 'N/A' ?></li>
            <li><strong>Volume:</strong> <?= $item->volume ?? 'N/A' ?></li>
        </ul>
       
    <?php else: ?>
        <p>Item not found.</p>
    <?php endif; ?>

    <div id="pricePerformance">Price performance: </div>
    <canvas id="priceChart" width="600" height="300"></canvas>
    <canvas id="volumeChart" width="600" height="300"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>

<script>

const item = <?php echo json_encode($item); ?>

const labels = item.history.map(h => h.timestamp);
const priceData = item.history.map(h => h.price);
const volumeData = item.history.map(h => h.volume);

const initialPrice = priceData[0]; // P_o
const currentPrice = priceData[priceData.length - 1]; // P_i
const pricePerformance = ((currentPrice - initialPrice) / initialPrice) * 100;

console.log(pricePerformance);

document.getElementById('pricePerformance').innerHTML += `<b>${pricePerformance.toFixed(2)}%</b>`;

// Price Chart
const ctxPrice = document.getElementById('priceChart').getContext('2d');
const priceChart = new Chart(ctxPrice, {
    type: 'line',
    data: {
    labels: labels,
    datasets: [{
        label: 'Price ($)',
        data: priceData,
        borderColor: 'rgb(75, 192, 192)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        tension: 0.3,
        fill: true,
    }]
    },
    options: {
    responsive: true,
    plugins: {
        title: {
        display: true,
        text: item.name + " - Price History"
        }
    },
    scales: {
        y: {
        beginAtZero: false
        }
    }
    }
});

// Volume Chart
const ctxVolume = document.getElementById('volumeChart').getContext('2d');
const volumeChart = new Chart(ctxVolume, {
    type: 'line',
    data: {
    labels: labels,
    datasets: [{
        label: 'Volume',
        data: volumeData,
        borderColor: 'rgb(255, 99, 132)',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        tension: 0.3,
        fill: true,
    }]
    },
    options: {
    responsive: true,
    plugins: {
        title: {
        display: true,
        text: item.name + " - Volume History"
        }
    },
    scales: {
        y: {
        beginAtZero: true
        }
    }
    }
});

</script>