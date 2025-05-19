<?php
require 'db_connect.php';
session_start();

$email = trim($_POST['email']);
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, name, password FROM clients WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $name, $hashed);
    $stmt->fetch();
    if (password_verify($password, $hashed)) {
        $_SESSION['client_id'] = $id;
        $_SESSION['client_name'] = $name;
        header("Location: client_dashboard.php");
        exit;
    }
}
// SweetAlert for invalid login
echo '
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
Swal.fire({
    icon: "error",
    title: "Login Failed",
    text: "Invalid email or password!",
    confirmButtonText: "OK"
}).then(() => {
    window.location.href = "client_login.html";
});
</script>
</body>
</html>
';
?>
