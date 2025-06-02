<?php
session_start();
include("../database.php");


$bookedData = [
  "labels" => [],
  "Booked" => [],
  "Completed" => [],
  "Expired" => []
];

// Loop 30 hari terakhir
for ($i = 30; $i >= 0; $i--) {
  $date = date('Y-m-d', strtotime("-$i days"));
  $label = date('D', strtotime($date)); // ex: Mon, Tue

  // Simpan label
  $bookedData["labels"][] = $label;

  // Query per status per tanggal
  $statusCounts = [
    'Booked' => 0,
    'Completed' => 0,
    'Expired' => 0
  ];

  $s = "SELECT status, COUNT(*) as count 
        FROM booking 
        WHERE DATE(start_date) = '$date' 
        AND status IN ('Booked', 'Completed', 'Expired') 
        GROUP BY status";
  $q = mysqli_query($conn, $s);
  while ($r = mysqli_fetch_array($q)) {
    $statusCounts[$r['status']] = (int)$r['count'];
  }

  $bookedData["Booked"][] = $statusCounts['Booked'];
  $bookedData["Completed"][] = $statusCounts['Completed'];
  $bookedData["Expired"][] = $statusCounts['Expired'];
}

$total = array_sum($bookedData["Booked"]) +
  array_sum($bookedData["Completed"]) +
  array_sum($bookedData["Expired"]);

?>

<div class="card text-white bg-secondary mb-3">
  <div class="card-body">
    <h5 class="card-title text-white">Bookings</h5>
    <h2 class="card-text text-white"><?= $total ?></h2>
    <p class="card-text text-white"><small>in last 30 days</small></p>
    <canvas id="bookedStatusChart" height="100"></canvas>
  </div>
</div>

<script>
  const ctx = document.getElementById('bookedStatusChart').getContext('2d');
  const bookedChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?= json_encode($bookedData["labels"]) ?>,
      datasets: [{
          label: 'Booked',
          data: <?php echo json_encode($bookedData["Booked"]) ?>,
          borderColor: 'rgba(255, 255, 255, 0.9)',
          backgroundColor: 'transparent',
          tension: 0.3
        },
        {
          label: 'Completed',
          data: <?php echo json_encode($bookedData["Completed"]) ?>,
          borderColor: 'rgba(75, 192, 192, 1)',
          backgroundColor: 'transparent',
          tension: 0.3
        },
        {
          label: 'Expired',
          data: <?php echo json_encode($bookedData["Expired"]) ?>,
          borderColor: 'rgba(255, 99, 132, 1)',
          backgroundColor: 'transparent',
          tension: 0.3
        }
      ]
    },
    options: {
      plugins: {
        legend: {
          labels: {
            color: 'white'
          }
        }
      },
      scales: {
        x: {
          ticks: {
            color: 'white'
          }
        },
        y: {
          ticks: {
            color: 'white'
          },
          beginAtZero: true
        }
      }
    }
  });
</script>

<?php mysqli_close($conn); ?>