<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "testt");

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Kiểm tra nếu sinh viên chưa đăng nhập
if (!isset($_SESSION['MaSV'])) {
    echo "<script>alert('Vui lòng đăng nhập trước khi đăng ký!'); window.location.href='login.php';</script>";
    exit;
}

$maSV = $_SESSION['MaSV'];  // Lấy mã sinh viên từ session

// Kiểm tra mã học phần từ URL
if (!isset($_GET['MaHP'])) {
    echo "Mã học phần không hợp lệ!";
    exit;
}

$maHP = $_GET['MaHP'];

// Kiểm tra xem sinh viên đã đăng ký học phần này chưa
$sql_check = "SELECT * FROM DangKy WHERE MaSV = '$maSV' AND MaHP = '$maHP'";
$result_check = $mysqli->query($sql_check);

if ($result_check->num_rows > 0) {
    echo "<script>alert('Bạn đã đăng ký học phần này rồi!'); window.location.href='hocphan.php';</script>";
    exit;
}

// Thêm học phần vào bảng DangKy
$sql_register = "INSERT INTO DangKy (MaSV, MaHP) VALUES ('$maSV', '$maHP')";

if ($mysqli->query($sql_register) === TRUE) {
    echo "<script>alert('Đăng ký học phần thành công!'); window.location.href='hocphan.php';</script>";
} else {
    echo "Lỗi khi đăng ký: " . $mysqli->error;
}

$mysqli->close();  // Đóng kết nối
?>