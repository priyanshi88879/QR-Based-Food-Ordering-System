<?php
session_start();
include 'config.php';

// Agar login nahi hua → login page par bhejo
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// Fetch Dashboard Counts
$totalOrders    = $conn->query("SELECT COUNT(*) AS c FROM orders")->fetch_assoc()['c'];
$pendingOrders  = $conn->query("SELECT COUNT(*) AS c FROM orders WHERE status='pending'")->fetch_assoc()['c'];
$completedOrders = $conn->query("SELECT COUNT(*) AS c FROM orders WHERE status='completed'")->fetch_assoc()['c'];

// Fetch all orders
$orders = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard | Smart QR</title>
<script src="https://cdn.tailwindcss.com"></script>

<!-- POPUP STYLE -->
<style>
.modal-bg { display: none; }
.modal-bg.active { display: flex; }
</style>
</head>

<body class="bg-gray-100">

<!-- ===== SIDEBAR + MAIN LAYOUT ===== -->
<div class="flex">

    <!-- SIDEBAR -->
    <div class="w-64 bg-white shadow-lg min-h-screen p-6 hidden md:block">
        <h2 class="text-2xl font-bold mb-8">Smart QR</h2>

        <nav class="space-y-3">
            <a href="#" class="block p-3 rounded-lg bg-blue-600 text-white">Dashboard</a>
            <a href="review_dashboard.php" class="block p-3 rounded-lg hover:bg-gray-200">Reviews</a>
            <a href="#" class="block p-3 rounded-lg hover:bg-gray-200">QR Management</a>
            <a href="#" class="block p-3 rounded-lg hover:bg-gray-200">Profile</a>
            <a href="logout.php" class="block p-3 rounded-lg hover:bg-red-100 text-red-600">Logout</a>
        </nav>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-1">

        <!-- TOP NAV -->
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">Dashboard</h1>
            <p class="font-medium">👋 Welcome, <?php echo $_SESSION['user_name']; ?></p>
        </div>

        <!-- DASHBOARD CARDS -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-gray-500">Total Orders</h3>
                <p class="text-3xl font-bold"><?php echo $totalOrders; ?></p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-gray-500">Pending Orders</h3>
                <p class="text-3xl font-bold text-yellow-500"><?php echo $pendingOrders; ?></p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h3 class="text-gray-500">Completed</h3>
                <p class="text-3xl font-bold text-green-600"><?php echo $completedOrders; ?></p>
            </div>

        </div>

        <!-- ORDER TABLE -->
        <div class="p-6">
            <h2 class="text-xl font-bold mb-4">Recent Orders</h2>

            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="p-3 text-left">Order ID</th>
                            <th class="p-3 text-left">Table</th>
                            <th class="p-3 text-left">Amount</th>
                            <th class="p-3 text-left">Date</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php while ($row = $orders->fetch_assoc()) { ?>
                        <tr class="border-b hover:bg-gray-50">

                            <td class="p-3">#<?php echo $row['id']; ?></td>
                            <td class="p-3"><?php echo $row['table_number']; ?></td>
                            <td class="p-3 font-bold">₹<?php echo $row['grand_total']; ?></td>
                            <td class="p-3"><?php echo $row['created_at']; ?></td>

                           

                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>


<!-- MODAL POPUP (VIEW ORDER DETAILS) -->
<div id="orderModal" class="modal-bg fixed inset-0 bg-black bg-opacity-50 items-center justify-center">
    <div class="bg-white w-96 p-6 rounded-xl shadow-lg">

        <h2 class="text-xl font-bold mb-3">Order Details</h2>

        <div id="modalContent" class="text-gray-700"></div>

        <button onclick="closeModal()"
            class="mt-4 w-full bg-blue-600 text-white py-2 rounded-lg">
            Close
        </button>
    </div>
</div>

<script>
function openModal(id) {
    fetch("view_order.php?id=" + id)
    .then(res => res.text())
    .then(data => {
        document.getElementById("modalContent").innerHTML = data;
        document.getElementById("orderModal").classList.add("active");
    });
}

function closeModal() {
    document.getElementById("orderModal").classList.remove("active");
}
</script>

</body>
</html>
