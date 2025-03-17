<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "testt");

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Kiểm tra và lấy mã sinh viên từ URL
if (isset($_GET['id'])) {
    $maSV = $_GET['id'];
} else {
    echo "Mã sinh viên không hợp lệ!";
    exit;
}

// Lấy thông tin sinh viên từ cơ sở dữ liệu
$sql = "SELECT * FROM SinhVien WHERE MaSV = '$maSV'";
$result = $mysqli->query($sql);

// Nếu sinh viên tồn tại trong cơ sở dữ liệu
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Sinh viên không tồn tại!";
    exit;
}

// Nếu form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $hoTen = $_POST['HoTen'];
    $gioiTinh = $_POST['GioiTinh'];
    $ngaySinh = $_POST['NgaySinh'];
    $maNganh = $_POST['MaNganh'];
    
    // Kiểm tra nếu có tệp hình ảnh mới được upload
    if ($_FILES['Hinh']['error'] == 0) {
        $hinh = addslashes(file_get_contents($_FILES['Hinh']['tmp_name']));
        $sql_update = "UPDATE SinhVien SET HoTen='$hoTen', GioiTinh='$gioiTinh', NgaySinh='$ngaySinh', Hinh='$hinh', MaNganh='$maNganh' WHERE MaSV='$maSV'";
    } else {
        // Nếu không có tệp hình ảnh mới, chỉ cập nhật thông tin khác
        $sql_update = "UPDATE SinhVien SET HoTen='$hoTen', GioiTinh='$gioiTinh', NgaySinh='$ngaySinh', MaNganh='$maNganh' WHERE MaSV='$maSV'";
    }

    // Cập nhật thông tin sinh viên
    if ($mysqli->query($sql_update) === TRUE) {
        echo "<script>alert('Cập nhật thông tin sinh viên thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "Lỗi: " . $mysqli->error;
    }
}

$mysqli->close();  // Đóng kết nối sau khi xử lý xong
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Sinh Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            font-size: 14px;
            margin: 10px 0 5px;
            display: block;
            color: #555;
        }

        input[type="text"], input[type="date"], input[type="file"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .image-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 10px 0;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Chỉnh Sửa Sinh Viên</h1>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="MaSV">Mã Sinh Viên:</label>
                <input type="text" id="MaSV" name="MaSV" value="<?php echo $row['MaSV']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="HoTen">Họ Tên:</label>
                <input type="text" id="HoTen" name="HoTen" value="<?php echo $row['HoTen']; ?>" required>
            </div>

            <div class="form-group">
                <label for="GioiTinh">Giới Tính:</label>
                <input type="text" id="GioiTinh" name="GioiTinh" value="<?php echo $row['GioiTinh']; ?>" required>
            </div>

            <div class="form-group">
                <label for="NgaySinh">Ngày Sinh:</label>
                <input type="date" id="NgaySinh" name="NgaySinh" value="<?php echo $row['NgaySinh']; ?>" required>
            </div>

            <div class="form-group">
                <label for="Hinh">Hình Ảnh:</label>
                <input type="file" id="Hinh" name="Hinh">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Hinh']); ?>" alt="Avatar" class="image-preview">
            </div>

            <div class="form-group">
                <label for="MaNganh">Mã Ngành:</label>
                <input type="text" id="MaNganh" name="MaNganh" value="<?php echo $row['MaNganh']; ?>" required>
            </div>

            <button type="submit">Cập Nhật</button>
        </form>

        <a href="index.php" class="btn-back">Quay lại danh sách sinh viên</a>
    </div>

</body>
</html>
