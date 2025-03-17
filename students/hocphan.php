<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "testt");  // Đảm bảo đúng tên cơ sở dữ liệu

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


// Lấy danh sách học phần
$sql = "SELECT * FROM HocPhan";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh Sách Học Phần</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .btn-register {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-register:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <h1 style="text-align:center;">Danh Sách Học Phần</h1>

    <table>
        <tr>
            <th>Mã Học Phần</th>
            <th>Tên Học Phần</th>
            <th>Số Tín Chỉ</th>
            <th>Đăng Ký</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['MaHP']; ?></td>
                <td><?php echo $row['TenHP']; ?></td>
                <td><?php echo $row['SoTinChi']; ?></td>
                <td>
                    <a href="register_course.php?MaHP=<?php echo $row['MaHP']; ?>" class="btn-register">Đăng Ký</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="index.php" class="btn-back">Trở về danh sách sinh viên</a>
</body>
</html>

<?php $mysqli->close(); ?>