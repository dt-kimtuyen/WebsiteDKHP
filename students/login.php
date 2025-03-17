<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "testt");

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $maSV = $_POST['MaSV'];

    // Kiểm tra xem sinh viên có tồn tại trong CSDL không
    $sql = "SELECT * FROM SinhVien WHERE MaSV = '$maSV'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // Lưu mã sinh viên vào session
        $_SESSION['MaSV'] = $maSV;
        header("Location: hocphan.php");  // Chuyển hướng đến trang học phần
    } else {
        echo "<script>alert('Mã sinh viên không hợp lệ!');</script>";
    }
}

$mysqli->close();  // Đóng kết nối
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .login-form {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .login-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .login-form button:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <div class="login-form">
        <h2>Đăng Nhập</h2>
        <form method="POST">
            <label for="MaSV">Mã Sinh Viên:</label>
            <input type="text" id="MaSV" name="MaSV" required>
            <button type="submit">Đăng Nhập</button>
        </form>
    </div>

</body>
</html>