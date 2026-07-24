<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $checkQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Email already exists!";
    } else {
        $insertQuery = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Signup successful! Please login.'); window.location.href='login.php';</script>";
            exit;
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign Up | Smart QR</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">

  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-4">Create Account</h2>

    <?php if (!empty($error)): ?>
      <p class="bg-red-100 text-red-700 p-2 rounded text-center mb-3"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">

      <div>
        <label class="block text-sm font-medium">Full Name</label>
        <input 
          type="text" 
          name="name" 
          required 
          class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-400"
          placeholder="Name"
        />
      </div>

      <div>
        <label class="block text-sm font-medium">Email Address</label>
        <input 
          type="email" 
          name="email" 
          required 
          class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-400"
          placeholder="Email"
        />
      </div>

      <div>
        <label class="block text-sm font-medium">Password</label>
        <input 
          type="password" 
          name="password" 
          required 
          placeholder="Password"
          class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-400"
        />
      </div>

      <button 
        type="submit" 
        class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
        Sign Up
      </button>

    </form>

    <p class="text-center mt-3 text-sm">
      Already have an account?
      <a href="login.php" class="text-blue-600 underline">Login</a>
    </p>
  </div>

</body>
</html>
