<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "testt");  // Đảm bảo đúng tên cơ sở dữ liệu

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $maSV = $_POST['MaSV'];
    $hoTen = $_POST['HoTen'];
    $gioiTinh = $_POST['GioiTinh'];
    $ngaySinh = $_POST['NgaySinh'];
    $maNganh = $_POST['MaNganh'];
    $hinh = addslashes(file_get_contents($_FILES['Hinh']['tmp_name']));  // Đọc tệp hình ảnh

    // Chèn sinh viên vào cơ sở dữ liệu
    $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
            VALUES ('$maSV', '$hoTen', '$gioiTinh', '$ngaySinh', '$hinh', '$maNganh')";
    if ($mysqli->query($sql) === TRUE) {
        echo "<script>alert('Thêm sinh viên thành công!'); window.location.href='index.php';</script>";
    } else {
        echo "Lỗi: " . $mysqli->error;
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh Viên</title>
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"], input[type="date"], input[type="file"] {
            padding: 10px;
            margin-bottom: 15px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #218838;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Thêm Sinh Viên</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="MaSV">Mã Sinh Viên:</label>
            <input type="text" id="MaSV" name="MaSV" required>

            <label for="HoTen">Họ Tên:</label>
            <input type="text" id="HoTen" name="HoTen" required>

            <label for="GioiTinh">Giới Tính:</label>
            <input type="text" id="GioiTinh" name="GioiTinh" required>

            <label for="NgaySinh">Ngày Sinh:</label>
            <input type="date" id="NgaySinh" name="NgaySinh" required>

            <label for="Hinh">Hình Ảnh:</label>
            <input type="file" id="Hinh" name="Hinh" required>

            <label for="MaNganh">Mã Ngành:</label>
            <input type="text" id="MaNganh" name="MaNganh" required>

            <button type="submit">Thêm</button>
        </form>
        <a href="index.php" class="back-link">Quay lại trang danh sách sinh viên</a>
    </div>

</body>
</html>
