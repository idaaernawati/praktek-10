<?php
include('koneksi2.php');
$data = mysqli_query($koneksi,"select * from tb_covid");
while($row = mysqli_fetch_array($data)){
 $country[] = $row['country'];
 $total_cases[] = $row['total_cases'];
}
?>
<!doctype html>
<html>

<head>
 <title>Pie Chart</title>
 <script type="text/javascript" src="Chart.js"></script>
</head>

<body>
 <div id="canvas-holder" style="width:50%">
  <canvas id="chart-area"></canvas>
 </div>
 <script>
  var config = {
   type: 'pie',
   data: {
    datasets: [{
     data:<?php echo json_encode($total_cases); ?>,
     backgroundColor: [
     'rgba(205, 92, 92, 1)',
     'rgba(75, 0, 130, 1 )',
     'rgba(255, 255, 0, 1)',
     'rgba(100, 149, 237, 1)',
     'rgba(154, 205, 50, 1)',
     'rgba(220, 20, 60, 1)',
     'rgba(255, 165, 0, 1)',
     'rgba(0, 255, 127, 1)',
     'rgba(32, 178, 170, 1)',
     'rgba(0, 255, 255, 1)'
     ],
     borderColor: [
     'rgba(205, 92, 92, 1)',
     'rgba(75, 0, 130, 1 )',
     'rgba(255, 255, 0, 1)',
     'rgba(100, 149, 237, 1)',
     'rgba(154, 205, 50, 1)',
     'rgba(220, 20, 60, 1)',
     'rgba(255, 165, 0, 1)',
     'rgba(0, 255, 127, 1)',
     'rgba(32, 178, 170, 1)',
     'rgba(0, 255, 255, 1)'
     ],    
     label : 'Grafik Total Cases Covid-19' 
    }],
    labels: <?php echo json_encode($country); ?>},
   options: {
    responsive: true
   }
  };

  window.onload = function() {
   var ctx = document.getElementById('chart-area').getContext('2d');
   window.myPie = new Chart(ctx, config);
  };

  document.getElementById('randomizeData').addEventListener('click', function() {
   config.data.datasets.forEach(function(dataset) {
    dataset.data = dataset.data.map(function() {
     return randomScalingFactor();
    });
   });

   window.myPie.update();
  });

  var colorNames = Object.keys(window.chartColors);
  document.getElementById('addDataset').addEventListener('click', function() {
   var newDataset = {
    backgroundColor: [],
    data: [],
    label: 'New dataset ' + config.data.datasets.length,
   };

   for (var index = 0; index < config.data.labels.length; ++index) {
    newDataset.data.push(randomScalingFactor());

    var colorName = colorNames[index % colorNames.length];
    var newColor = window.chartColors[colorName];
    newDataset.backgroundColor.push(newColor);
   }

   config.data.datasets.push(newDataset);
   window.myPie.update();
  });

  document.getElementById('removeDataset').addEventListener('click', function() {
   config.data.datasets.splice(0, 1);
   window.myPie.update();
  });
 </script>
</body>

</html>