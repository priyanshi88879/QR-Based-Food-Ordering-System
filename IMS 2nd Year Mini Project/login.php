<?php
session_start();
include 'config.php';

// Agar already logged in hai → index.php par bhejo
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Email check
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Email match mila?
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Password verify
        if (password_verify($password, $user['password'])) {

            // Session set
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            header("Location: index.php");
            exit();
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Email not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
  body  {
    background-color: antiquewhite;
  }
</style>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-4">Login</h2>

    <?php if (!empty($error)): ?>
        <p class="bg-red-100 text-red-700 p-2 rounded text-center mb-3"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" required class="w-full p-2 border rounded" placeholder="Email">
        </div>

        <div>
            <label class="block text-sm font-medium"placeholder="Password">Password</label>
            <input type="password" name="password" required class="w-full p-2 border rounded" placeholder="Password">
        </div>

        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Login
        </button>

    </form>

    <p class="text-center mt-3 text-sm">
        Don’t have an account?
        <a href="signup.php" class="text-blue-600 underline">Sign Up</a>
    </p>
</div>

</body>
</html>
