<?php
session_start();  // Khởi tạo session

// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "testt");

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy mã sinh viên từ form
    $maSV = $_POST['MaSV'];

    // Kiểm tra thông tin đăng nhập (chỉ kiểm tra mã sinh viên)
    $sql = "SELECT * FROM SinhVien WHERE MaSV = '$maSV'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // Lưu mã sinh viên vào session
        $_SESSION['MaSV'] = $maSV;
        echo "<script>alert('Đăng nhập thành công!'); window.location.href='index.php';</script>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h1 {
            text-align: center;
            color: #333;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 15px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .input-field:focus {
            outline: none;
            border-color: #4CAF50;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #45a049;
        }
        .alert {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Đăng Nhập</h1>
        <form method="POST">
            <input type="text" id="MaSV" name="MaSV" class="input-field" placeholder="Nhập mã sinh viên" required>
            <button type="submit" class="btn-submit">Đăng Nhập</button>
        </form>
        <?php if (isset($result) && $result->num_rows == 0): ?>
            <div class="alert">Mã sinh viên không hợp lệ!</div>
        <?php endif; ?>
    </div>
</body>
</html>
