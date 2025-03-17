<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "testt");

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


// Kiểm tra nếu có id sinh viên từ URL
if (isset($_GET['id'])) {
    $maSV = $_GET['id'];

    // Xóa các bản ghi trong bảng ChiTietDangKv có MaDK liên kết với MaSV
    $sql_delete_chitietdangkv = "DELETE FROM ChiTietDangKv WHERE MaDK IN (SELECT MaDK FROM DangKv WHERE MaSV = '$maSV')";
    if ($mysqli->query($sql_delete_chitietdangkv) === FALSE) {
        echo "Lỗi khi xóa dữ liệu trong bảng ChiTietDangKv: " . $mysqli->error;
        exit;
    }

    // Xóa các bản ghi trong bảng DangKv có MaSV tham chiếu đến sinh viên này
    $sql_delete_dangkv = "DELETE FROM DangKv WHERE MaSV = '$maSV'";
    if ($mysqli->query($sql_delete_dangkv) === FALSE) {
        echo "Lỗi khi xóa dữ liệu trong bảng DangKv: " . $mysqli->error;
        exit;
    }

    // Thực hiện câu lệnh xóa sinh viên
    $sql_delete = "DELETE FROM SinhVien WHERE MaSV = '$maSV'";

    if ($mysqli->query($sql_delete) === TRUE) {
        echo "Sinh viên đã được xóa thành công!";
        header("Location: index.php"); // Chuyển hướng về trang danh sách sau khi xóa
    } else {
        echo "Lỗi: " . $mysqli->error;
    }
} else {
    echo "Không có mã sinh viên để xóa!";
}

$mysqli->close();  // Đóng kết nối
?>
