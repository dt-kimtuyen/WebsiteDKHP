<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "testt");

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy mã sinh viên từ URL
if (isset($_GET['id'])) {
    $maSV = $_GET['id'];
} else {
    echo "Mã sinh viên không hợp lệ!";
    exit;
}

// Lấy thông tin chi tiết sinh viên từ cơ sở dữ liệu
$sql = "SELECT * FROM SinhVien WHERE MaSV = '$maSV'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Sinh viên không tồn tại!";
    exit;
}

$mysqli->close();  // Đóng kết nối
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Sinh Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 60%;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        td img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
        }

        .btn-back {
            display: block;
            margin-top: 20px;
            text-align: center;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Chi Tiết Sinh Viên</h1>
        <table>
            <tr>
                <th>Mã Sinh Viên</th>
                <td><?php echo $row['MaSV']; ?></td>
            </tr>
            <tr>
                <th>Họ Tên</th>
                <td><?php echo $row['HoTen']; ?></td>
            </tr>
            <tr>
                <th>Giới Tính</th>
                <td><?php echo $row['GioiTinh']; ?></td>
            </tr>
            <tr>
                <th>Ngày Sinh</th>
                <td><?php echo $row['NgaySinh']; ?></td>
            </tr>
            <tr>
                <th>Hình Ảnh</th>
                <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['Hinh']); ?>" alt="Avatar"></td>
            </tr>
            <tr>
                <th>Mã Ngành</th>
                <td><?php echo $row['MaNganh']; ?></td>
            </tr>
        </table>
        <a href="index.php" class="btn-back">Quay lại danh sách sinh viên</a>
    </div>

</body>
</html>
