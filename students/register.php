<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "testt");

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Kiểm tra nếu sinh viên chưa đăng nhập
if (!isset($_SESSION['MaSV'])) {
    echo "<script>alert('Vui lòng đăng nhập để đăng ký học phần!'); window.location.href='login.php';</script>";
    exit;
}

$maSV = $_SESSION['MaSV'];  // Lấy mã sinh viên từ session
$maHP = $_GET['MaHP'];      // Lấy mã học phần từ URL

// Kiểm tra nếu học phần đã đăng ký
$sql_check = "SELECT * FROM DangKy WHERE MaSV = '$maSV' AND MaHP = '$maHP'";
$result_check = $mysqli->query($sql_check);

// Nếu học phần đã đăng ký, hiển thị thông báo
if ($result_check->num_rows > 0) {
    echo "<script>alert('Bạn đã đăng ký học phần này rồi!'); window.location.href='hocphan.php';</script>";
    exit;
}

// Lấy thông tin học phần từ cơ sở dữ liệu
$sql_course = "SELECT * FROM HocPhan WHERE MaHP = '$maHP'";
$result_course = $mysqli->query($sql_course);
$course = $result_course->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Đăng ký học phần
    $sql_register = "INSERT INTO DangKy (MaSV, MaHP) VALUES ('$maSV', '$maHP')";
    
    if ($mysqli->query($sql_register) === TRUE) {
        echo "<script>alert('Đăng ký học phần thành công!'); window.location.href='hocphan.php';</script>";
    } else {
        echo "Lỗi khi đăng ký học phần: " . $mysqli->error;
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Học Phần</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .btn-register {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: block;
            width: 100%;
            text-align: center;
        }

        .btn-register:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Đăng Ký Học Phần</h1>

        <form method="POST">
            <p><strong>Mã Học Phần:</strong> <?php echo $course['MaHP']; ?></p>
            <p><strong>Tên Học Phần:</strong> <?php echo $course['TenHP']; ?></p>
            <p><strong>Số Tín Chỉ:</strong> <?php echo $course['SoTinChi']; ?></p>
            <button type="submit" class="btn-register">Đăng Ký</button>
        </form>
    </div>

</body>
</html>
