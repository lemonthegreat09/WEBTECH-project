<?php
require 'db_connect.php';

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    echo '
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
    <script>
    Swal.fire({
        icon: "error",
        title: "Registration Failed",
        text: "Passwords do not match!",
        confirmButtonText: "OK"
    }).then(() => {
        window.location.href = "client_login.html";
    });
    </script>
    </body>
    </html>
    ';
    exit;
}

if (empty($name) || empty($email) || empty($password)) {
    echo '
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
    <script>
    Swal.fire({
        icon: "error",
        title: "Registration Failed",
        text: "All fields are required!",
        confirmButtonText: "OK"
    }).then(() => {
        window.location.href = "client_login.html";
    });
    </script>
    </body>
    </html>
    ';
    exit;
}

$check = $conn->prepare("SELECT id FROM clients WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo '
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
    <script>
    Swal.fire({
        icon: "error",
        title: "Registration Failed",
        text: "Email already registered!",
        confirmButtonText: "OK"
    }).then(() => {
        window.location.href = "client_login.html";
    });
    </script>
    </body>
    </html>
    ';
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO clients (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed);

if ($stmt->execute()) {
    echo '
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
    <script>
    Swal.fire({
        icon: "success",
        title: "Registration Successful",
        text: "You can now login.",
        confirmButtonText: "OK"
    }).then(() => {
        window.location.href = "client_login.html";
    });
    </script>
    </body>
    </html>
    ';
} else {
    echo '
    <html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
    <script>
    Swal.fire({
        icon: "error",
        title: "Registration Failed",
        text: "Registration failed! Please try again.",
        confirmButtonText: "OK"
    }).then(() => {
        window.location.href = "client_login.html";
    });
    </script>
    </body>
    </html>
    ';
}
?>
