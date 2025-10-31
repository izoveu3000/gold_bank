
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php include 'header.php'; ?>
<!-- Header is now outside dashboard-flex for proper shifting -->
<div class="dashboard-flex">
    <?php include 'nav.php'; ?>
    <div id="content" class="dashboard-main" style="margin-left:0; transition:margin-left -10s;">
<script>
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.getElementById('sidebar');
    var content = document.getElementById('content');
    var header = document.querySelector('nav.header-shiftable');
    var toggleBtn = document.getElementById('toggleSidebar');
    // Always open sidebar by default on desktop
    function openSidebar() {
        sidebar.style.transform = 'translateX(0)';
        sidebar.style.boxShadow = '2px 0 8px rgba(0,0,0,0.08)';
        sidebar.style.width = '240px';
        if(window.innerWidth >= 992) {
            content.style.marginLeft = '240px';
            content.style.width = '';
        } else {
            content.style.marginLeft = '0';
            content.style.width = '';
        }
        if(header) header.classList.add('header-shifted');
    }
    function closeSidebar() {
        sidebar.style.transform = 'translateX(-100%)';
        sidebar.style.boxShadow = 'none';
        sidebar.style.width = '240px';
        content.style.marginLeft = '0';
        if(window.innerWidth >= 992) {
            content.style.width = '100vw';
        } else {
            content.style.width = '';
        }
        if(header) header.classList.remove('header-shifted');
    }
    if(toggleBtn) {
        toggleBtn.onclick = function(e) {
            e.stopPropagation();
            if(sidebar.style.transform === 'translateX(-100%)') {
                openSidebar();
            } else {
                closeSidebar();
            }
        };
    }
    // Responsive: only close sidebar on small screens
    function handleResize() {
        if(window.innerWidth < 992) {
            closeSidebar();
        } else {
            openSidebar();
        }
    }
    // buy gold now 
    const buyGoldButton = document.getElementById('buyGoldNowBtn');
    if (buyGoldButton) {
        buyGoldButton.addEventListener('click', function() {
            // Redirects the user to the buygold(user).php page
            window.location.href = 'buygold(user).php';
        });
    }
    window.addEventListener('resize', handleResize);
    handleResize();
});
</script>
<main>
    <div class="dashboard-hero mb-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    
                    <h1 class="dashboard-title">Gold Investment Dashboard</h1>
                    <p class="dashboard-subtitle">Track your precious metals portfolio and market trends</p>
                    <div class="dashboard-growth">&#8593; <span>Portfolio growing +1.24% today</span></div>
                </div>
                <div class="dashboard-hero-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24"><path d="M12 2l4 8h-8l4-8zm0 20v-6m0 0l-4-8m4 8l4-8" stroke="#ffe082" stroke-width="2"/></svg>
                </div>
            </div>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="dashboard-card-title">Wallet Balance</div>
                        <div class="dashboard-card-value" id="wallet-balance-value">...</div>
                        <div class="dashboard-card-desc text-success">Available for investment</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="dashboard-card-title gold">Gold Holdings</div>
                        <div class="dashboard-card-value gold" id="gold-holdings-value">....</div>
                        <div class="dashboard-card-desc">Total precious metals</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="dashboard-card-title">Portfolio Value</div>
                        <div class="dashboard-card-value"  id="portfolio-value-value">...</div>
                        <div class="dashboard-card-desc">Current market value</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card h-100 dashboard-card-pnl">
                    <div class="card-body">
                        <div class="dashboard-card-title">Today's P&amp;L</div>
                        <div class="dashboard-card-value" id="pnl-value">...</div> 
                        <div class="dashboard-card-desc" id="pnl-description">Loading calculation...</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <!-- gold price -->
                        <div class="dashboard-card-title gold">Live Gold Price</div>
                        <div class="dashboard-card-value gold" id="live-gold-price-value">$2645.30</div>
                        <div class="dashboard-card-desc text-success" id="gold-price-diff">+2.4% &nbsp; +$62.50 Today</div>
                        <div class="dashboard-card-desc">Per troy ounce (USD) •
                             <span id="live-price-timestamp">...</span>
                        </div>
                        <button  id="buyGoldNowBtn" class="btn dashboard-buy-btn mt-3">Buy Gold Now</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-body">
                        <div class="dashboard-card-title">24h Price Movement</div>
                        <div class="dashboard-card-chart mb-2" style="height: 180px;">
                            <canvas id="goldPriceChart"></canvas>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="dashboard-card-desc">24h Low<br><span id="price-low-24h" class="text-danger">$2,635.50</span></div>
                            <div class="dashboard-card-desc">24h High<br><span id="price-high-24h" class="text-success">$2,658.20</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       <!-- Quick Actions Section -->
<div class="container-fluid mt-4">
    <div class="card p-4" style="background: #f7fcf5; border-radius: 16px; border: none;">
        <div style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem;">Quick Actions</div>
        <div style="color: #757575; margin-bottom: 1.5rem;">Manage your gold investment portfolio</div>
        <div class="row g-3 text-center">
            
            <div class="col-md-3 col-6">
                <a href="buygold(user).php" 
                   class="card h-100 text-decoration-none" 
                   style="border: 1.5px solid #ffe7a6; border-radius: 12px; background: #fff7cc; display: block; color: inherit; cursor: pointer;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 2rem 1rem;">
                        <div style="font-size: 1.5rem; color: #fbc02d; margin-bottom: 0.5rem;">
                            <i data-feather="dollar-sign"></i>
                        </div>
                        <div style="font-weight: 600;">Buy Gold</div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="rechargecoin(user).php" 
                   class="card h-100 text-decoration-none" 
                   style="border: 1.5px solid #c8dfcd; border-radius: 12px; background: #eaf6ee; display: block; color: inherit; cursor: pointer;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 2rem 1rem;">
                        <div style="font-size: 1.5rem; color: #388e3c; margin-bottom: 0.5rem;">
                            <i data-feather="credit-card"></i>
                        </div>
                        <div style="font-weight: 600;">Add Funds</div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="withdraw(user).php" 
                   class="card h-100 text-decoration-none" 
                   style="border: 1.5px solid #f8c1c1; border-radius: 12px; background: #fff0f0; display: block; color: inherit; cursor: pointer;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 2rem 1rem;">
                        <div style="font-size: 1.5rem; color: #e57373; margin-bottom: 0.5rem;">
                            <i data-feather="arrow-down-left"></i>
                        </div>
                        <div style="font-weight: 600;">Withdraw</div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-3 col-6">
                <a href="history(user).php" 
                   class="card h-100 text-decoration-none" 
                   style="border: 1.5px solid #c8dfcd; border-radius: 12px; background: #eaf6ee; display: block; color: inherit; cursor: pointer;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center" style="padding: 2rem 1rem;">
                        <div style="font-size: 1.5rem; color: #388e3c; margin-bottom: 0.5rem;">
                            <i data-feather="trending-up"></i>
                        </div>
                        <div style="font-weight: 600;">History</div>
                    </div>
                </a>
            </div>
            
        </div>
    </div>
</div>

    </main>
<script>
    // Initialize Feather Icons
    feather.replace();

    // Reusable function to fetch and update balance for a given currency ID
    function fetchAndDisplayBalance(currencyId, elementId, isGold = false) {
        fetch(`dashboard_user_db_sql.php?currency_id=${currencyId}`)
            .then(response => response.json())
            .then(data => {
                const balanceElement = document.getElementById(elementId);
                let formattedAmount;

                if (isGold) {
                    // For gold, format as a number with a specific unit
                    formattedAmount = `${parseFloat(data.amount).toFixed(2)} oz`;
                } else {
                    // For dollar, format as a currency string
                    formattedAmount = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(data.amount);
                }
                
                balanceElement.textContent = formattedAmount;
            })
            .catch(error => {
                console.error(`Error fetching balance for currency ID ${currencyId}:`, error);
                document.getElementById(elementId).textContent = isGold ? '-- oz' : '$--,--'; // Show error state
            });
    }
    function fetchAndDisplayPortfolioValue() {
        fetch('dashboard_user_db_sql.php?portfolio_value=true')
            .then(response => response.json())
            .then(data => {
                const portfolioElement = document.getElementById('portfolio-value-value');
                if (data.portfolio_value !== undefined) {
                    // Format the value as currency (e.g., $1,520.00)
                    const formattedValue = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD',
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(data.portfolio_value);
                    portfolioElement.textContent = formattedValue;
                } else {
                    portfolioElement.textContent = '$--,--';
                }
            })
            .catch(error => {
                console.error('Error fetching portfolio value:', error);
                document.getElementById('portfolio-value-value').textContent = '$--,--';
            });
    }
      function fetchAndDisplayGoldPrice() {
        fetch('dashboard_user_db_sql.php?gold_price=true')
            .then(response => response.json())
            .then(data => {
                const goldPriceElement = document.getElementById('live-gold-price-value');
                const priceDiffElement = document.getElementById('gold-price-diff');
                const lastUpdatedElement = document.getElementById('live-price-timestamp');

                const formattedPrice = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(data.price);
                goldPriceElement.textContent = formattedPrice;

                // Update the price difference and percentage
                const sign = data.is_up ? '+' : '-';
                const colorClass = data.is_up ? 'text-success' : 'text-danger';

                const formattedDifference = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(Math.abs(data.difference));

                // Change this line to show only the dollar value
                priceDiffElement.textContent = `${sign}${formattedDifference} Today`;
                priceDiffElement.className = `dashboard-card-desc ${colorClass}`;

                if (lastUpdatedElement && data.changed_at) {
                    const date = new Date(data.changed_at);
                    const formattedDateTime = date.toLocaleString('en-US', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true
                    });
                    lastUpdatedElement.textContent = `Last updated: ${formattedDateTime}`;
                }
            })
            .catch(error => {
                console.error('Error fetching live gold price:', error);
                document.getElementById('live-gold-price-value').textContent = '$--,--';
                document.getElementById('gold-price-diff').textContent = '--$ Today';
            });
    }

    // NEW function to fetch and display P&L
function fetchAndDisplayProfitLoss() {
    fetch('dashboard_user_db_sql.php?profit_loss=true')
        .then(response => response.json())
        .then(data => {
            const pnlElement = document.getElementById('pnl-value');
            const pnlDescElement = document.getElementById('pnl-description');

            if (data.profit_loss !== undefined) {
                const pnlValue = parseFloat(data.profit_loss);
                const isProfit = pnlValue >= 0;
                const sign = isProfit ? '+' : '-';
                const colorClass = isProfit ? 'text-success' : 'text-danger';

                // Format the value as currency (e.g., +$1,520.00 or -$50.25)
                const formattedValue = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(Math.abs(pnlValue));

                // Determine arrow direction (&#8599; is UP-RIGHT, &#8600; is DOWN-RIGHT)
                const arrow = isProfit ? '&#8599;' : '&#8600;'; 

                // Update UI elements
                pnlElement.textContent = `${sign}${formattedValue}`;
                pnlElement.className = `dashboard-card-value ${colorClass}`;
                
                pnlDescElement.innerHTML = `${arrow} Based on Total Investment`;
                pnlDescElement.className = `dashboard-card-desc ${colorClass}`;


            } else {
                pnlElement.textContent = '$--,--';
                pnlElement.className = 'dashboard-card-value';
                pnlDescElement.textContent = 'Data unavailable';
                pnlDescElement.className = 'dashboard-card-desc';
            }
        })
        .catch(error => {
            console.error('Error fetching Profit/Loss:', error);
            document.getElementById('pnl-value').textContent = '$--,--';
            document.getElementById('pnl-description').textContent = 'Error fetching data';
        });
}

// function to fetch and display the 24-hour gold price chart
function fetchAndDisplay24hChart() {
    fetch('dashboard_user_db_sql.php?gold_price_24h=true')
        .then(response => response.json())
        .then(data => {
            const history = data.price_history || [];

            // If there's no data, use the fallback text
            if (history.length === 0) {
                const chartContainer = document.querySelector('.dashboard-card-chart.mb-2');
                chartContainer.innerHTML = '<div class="text-center text-secondary pt-5">No 24-hour price data available.</div>';
                return; 
            }

            // Prepare data for Chart.js
            const labels = history.map(item => {
                const date = new Date(item.time);
                // Format time as HH:MM
                return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            });
            const prices = history.map(item => item.price);

            // Determine the chart's line color based on overall 24h movement
            const firstPrice = prices[0];
            const lastPrice = prices[prices.length - 1];
            const isUp = lastPrice >= firstPrice;
            const lineColor = isUp ? '#388e3c' : '#e57373'; // Success green or Danger red

            const ctx = document.getElementById('goldPriceChart').getContext('2d');
            
            // Destroy previous chart instance if it exists before creating a new one
            if (window.goldPriceChartInstance) {
                window.goldPriceChartInstance.destroy();
            }

            window.goldPriceChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Price (USD)',
                        data: prices,
                        borderColor: lineColor,
                        backgroundColor: isUp ? 'rgba(56, 142, 60, 0.1)' : 'rgba(229, 115, 115, 0.1)', // Light fill for the area
                        borderWidth: 2,
                        pointRadius: 0,
                        tension: 0.4, // Smoother line
                        fill: 'origin'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                title: function(tooltipItems) {
                                    // Show full timestamp in tooltip title
                                    const index = tooltipItems[0].dataIndex;
                                    const fullDate = new Date(history[index].time);
                                    return fullDate.toLocaleString(); // e.g., 10/05/2025, 05:35:00 PM
                                },
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: false // Hide X-axis labels for a clean look
                        },
                        y: {
                            beginAtZero: false,
                            ticks: {
                                // Only show dollar sign on the y-axis
                                callback: function(value) {
                                    return '$' + value.toFixed(2);
                                }
                            },
                            grid: {
                                display: false // Hide Y-axis grid lines
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching 24h gold price history:', error);
            const chartContainer = document.querySelector('.dashboard-card-chart.mb-2');
            chartContainer.innerHTML = '<div class="text-center text-danger pt-5">Error loading chart data.</div>';
        });
}

// NEW function to fetch and display 24-hour High and Low
function fetchAndDisplay24hStats() {
    fetch('dashboard_user_db_sql.php?gold_price_stats_24h=true')
        .then(response => response.json())
        .then(data => {
            const stats = data.price_stats_24h;

            const formatCurrency = (value) => new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'MMK',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(value);

            if (stats && stats.price_low !== null) {
                document.getElementById('price-low-24h').textContent = formatCurrency(stats.price_low);
            } else {
                document.getElementById('price-low-24h').textContent = '$--.--';
            }

            if (stats && stats.price_high !== null) {
                document.getElementById('price-high-24h').textContent = formatCurrency(stats.price_high);
            } else {
                document.getElementById('price-high-24h').textContent = '$--.--';
            }
        })
        .catch(error => {
            console.error('Error fetching 24h price stats:', error);
            document.getElementById('price-low-24h').textContent = 'Error';
            document.getElementById('price-high-24h').textContent = 'Error';
        });
}



    document.addEventListener('DOMContentLoaded', function() {
        // Fetch and update the wallet balance on page load
        fetchAndDisplayBalance(2, 'wallet-balance-value', false);
        // Fetch and update the gold holdings on page load
        fetchAndDisplayBalance(1, 'gold-holdings-value', true);

        fetchAndDisplayGoldPrice();

        fetchAndDisplayPortfolioValue(); 

        fetchAndDisplayProfitLoss(); 

         fetchAndDisplay24hChart();

           fetchAndDisplay24hStats();
        // Use setInterval to fetch and update both balances every 5 seconds
        setInterval(() => {
            fetchAndDisplayBalance(2, 'wallet-balance-value', false);
            fetchAndDisplayBalance(1, 'gold-holdings-value', true);
            fetchAndDisplayPortfolioValue();

            fetchAndDisplayGoldPrice();
            fetchAndDisplayProfitLoss(); 

        }, 5000);
        setInterval(() => {
            fetchAndDisplay24hChart();
            fetchAndDisplay24hStats();
        },  300000);
    });
</script>

<?php include 'footer.php'; ?>
