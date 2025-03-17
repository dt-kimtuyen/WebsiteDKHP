<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "testt");

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy danh sách sinh viên
$sql = "SELECT * FROM SinhVien";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Sinh Viên</title>
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

        .btn-register, .btn-login, .btn-hocphan {
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            margin: 0 10px;
            display: inline-block;
        }

        .btn-register {
            background-color: #28a745;
        }

        .btn-register:hover {
            background-color: #218838;
        }

        .btn-login {
            background-color: #007bff;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .btn-hocphan {
            background-color: #17a2b8;
        }

        .btn-hocphan:hover {
            background-color: #138496;
        }
    </style>
</head>
<body>

    <h1 style="text-align:center;">Danh Sách Sinh Viên</h1>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="add_student.php" class="btn-register">Add Student</a> 
        <a href="hocphan.php" class="btn-hocphan">Học Phần</a> <!-- Thêm nút Học Phần -->
        <a href="register.php" class="btn-register">Đăng Ký</a> <!-- Thêm nút Đăng Ký -->
        <a href="login.php" class="btn-login">Đăng Nhập</a> <!-- Thêm nút Đăng Nhập -->
    </div>

    <table>
        <tr>
            <th>MaSV</th>
            <th>HoTen</th>
            <th>GioiTinh</th>
            <th>NgaySinh</th>
            <th>Hinh</th>
            <th>MaNganh</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['MaSV']; ?></td>
                <td><?php echo $row['HoTen']; ?></td>
                <td><?php echo $row['GioiTinh']; ?></td>
                <td><?php echo $row['NgaySinh']; ?></td>
                <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['Hinh']); ?>" width="50" height="50"></td>
                <td><?php echo $row['MaNganh']; ?></td>
                <td>
                    <a href="edit_student.php?id=<?php echo $row['MaSV']; ?>">Edit</a> |
                    <a href="details_student.php?id=<?php echo $row['MaSV']; ?>">Details</a> |
                    <a href="delete_student.php?id=<?php echo $row['MaSV']; ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>

<?php $mysqli->close(); ?>
