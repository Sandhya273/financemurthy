<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment Maturity Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 80%; margin: 0 auto;">
        <canvas id="maturityChart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('maturityChart').getContext('2d');
        var maturityData = <?php echo json_encode($chartData); ?>;

        
        var labels = [];
        var data = [];
        maturityData.split(',').forEach(function(item,index) {
          if(item[0]=='['){
            let data1=item.split('[')[1].replace(/^'|^'/g, "").replace(/'$|^'/g, "");
            labels.push(data1)
          }else{
            let data1=item.split(']')[0]
            data.push(data1)
          }
        });
        var chart = new Chart(ctx, {
            type: 'line', 
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Investment by Maturity Date',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Maturity Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Investment Amount'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
