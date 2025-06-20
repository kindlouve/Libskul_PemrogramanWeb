<?php
session_start();
include dirname(__DIR__) . '/koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role     = $_POST['role'] ?? '';
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($role === 'admin') {
        $sql  = "SELECT * FROM admin WHERE LOWER(username) = LOWER(?) LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($admin = $result->fetch_assoc()) {
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin'] = $admin['username'];
                header("Location: /libskul/admin/dashboard.php");
                exit();
            } else {
                $error = "Password admin salah!";
            }
        } else {
            $error = "Admin tidak ditemukan!";
        }

    } elseif ($role === 'siswa') {
        $sql  = "SELECT * FROM siswa WHERE nis = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['siswa_id'] = $user['id'];
                $_SESSION['nama']     = $user['nama'];
                header("Location: /libskul/dashboard_user.php");
                exit();
            } else {
                $error = "Password siswa salah!";
            }
        } else {
            $error = "NIS tidak ditemukan!";
        }

    } else {
        $error = "Peran login tidak valid!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Login | Libskul</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen flex items-center justify-center">
  <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-sm flex flex-col items-center">
    <img src="../../img/logo.png" alt="Logo Libskul" class="w-20 h-20 object-contain rounded-full shadow mb-4 border-4 border-gray-200">
    <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">
      Login ke <span class="text-gray-500">Libskul</span>
    </h2>

    <?php if ($error): ?>
      <div class="bg-red-100 text-red-700 p-3 mb-4 w-full rounded text-sm text-center">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form action="" method="post" class="w-full">
      <label class="block mb-4">
        <span class="text-gray-700 font-medium">Login sebagai</span>
        <select name="role" class="w-full mt-1 p-2 border rounded focus:ring-2 focus:ring-gray-400" required>
          <option value="siswa">Siswa</option>
          <option value="admin">Admin</option>
        </select>
      </label>

      <input type="text" name="username"
             placeholder="NIS atau Username"
             class="w-full p-2 mb-4 border rounded focus:ring-2 focus:ring-gray-400"
             required>

      <input type="password" name="password"
             placeholder="Password"
             class="w-full p-2 mb-6 border rounded focus:ring-2 focus:ring-gray-400"
             required>

      <button type="submit"
              class="bg-gradient-to-r from-gray-500 to-gray-700 text-white px-4 py-2 rounded-lg w-full
                     hover:from-gray-600 hover:to-gray-800 transition font-semibold text-base shadow">
        Login
      </button>
    </form>

    <p class="mt-6 text-sm text-center text-gray-600">
      Belum punya akun?
      <a href="register_siswa.php" class="text-gray-700 underline hover:text-gray-900">Daftar di sini</a>
    </p>
  </div>
</body>
</html>
