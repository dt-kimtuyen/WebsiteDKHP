<?php
// Kết nối cơ sở dữ liệu
$mysqli = new mysqli("localhost", "root", "", "testt");

// Kiểm tra kết nối
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Lấy danh sách học phần từ CSDL
$sql = "SELECT * FROM HocPhan";
$result = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh Sách Học Phần</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Danh Sách Học Phần</h2>

    <!-- Bảng danh sách học phần -->
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Mã HP</th>
                <th>Tên Học Phần</th>
                <th>Số Chỉ</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody id="hocPhanTable">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['MaHP'] . "</td>";
                    echo "<td>" . $row['TenHP'] . "</td>";
                    echo "<td>" . $row['SoTinChi'] . "</td>";
                    echo "<td>
                            <button class='btn btn-warning btn-edit'>Sửa</button>
                            <button class='btn btn-danger btn-delete'>Xóa</button>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>Không có học phần nào!</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Tổng số học phần và tín chỉ -->
    <div class="mt-3">
        <p><strong>Số học phần:</strong> <span id="soHocPhan"><?php echo $result->num_rows; ?></span></p>
        <p><strong>Tổng số tín chỉ:</strong> <span id="tongTinChi">0</span></p>
    </div>

    <!-- Modal Sửa học phần -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Chỉnh Sửa Học Phần</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="mb-3">
                            <label for="editMaHP" class="form-label">Mã HP:</label>
                            <input type="text" class="form-control" id="editMaHP" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="editTenHP" class="form-label">Tên Học Phần:</label>
                            <input type="text" class="form-control" id="editTenHP">
                        </div>
                        <div class="mb-3">
                            <label for="editSoTin" class="form-label">Số Chỉ:</label>
                            <input type="number" class="form-control" id="editSoTin">
                        </div>
                        <button type="submit" class="btn btn-success">Lưu Thay Đổi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.getElementById("hocPhanTable");

        // Xóa học phần
        table.addEventListener("click", function(event) {
            if (event.target.classList.contains("btn-delete")) {
                if (confirm("Bạn có chắc muốn xóa học phần này?")) {
                    const row = event.target.closest("tr");
                    row.remove();
                    updateCount();
                }
            }
        });

        // Sửa học phần
        table.addEventListener("click", function(event) {
            if (event.target.classList.contains("btn-edit")) {
                const row = event.target.closest("tr");
                const maHP = row.cells[0].innerText;
                const tenHP = row.cells[1].innerText;
                const soTin = row.cells[2].innerText;

                document.getElementById("editMaHP").value = maHP;
                document.getElementById("editTenHP").value = tenHP;
                document.getElementById("editSoTin").value = soTin;

                const modal = new bootstrap.Modal(document.getElementById("modalEdit"));
                modal.show();
            }
        });

        // Cập nhật học phần sau khi chỉnh sửa
        document.getElementById("editForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const maHP = document.getElementById("editMaHP").value;
            const tenHP = document.getElementById("editTenHP").value;
            const soTin = document.getElementById("editSoTin").value;

            const rows = table.getElementsByTagName("tr");
            for (let row of rows) {
                if (row.cells[0].innerText === maHP) {
                    row.cells[1].innerText = tenHP;
                    row.cells[2].innerText = soTin;
                    break;
                }
            }

            const modal = bootstrap.Modal.getInstance(document.getElementById("modalEdit"));
            modal.hide();
            updateCount();
        });

        // Cập nhật tổng số tín chỉ
        function updateCount() {
            let tongTinChi = 0;
            const rows = table.getElementsByTagName("tr");
            for (let row of rows) {
                if (row.cells.length > 1) {
                    tongTinChi += parseInt(row.cells[2].innerText);
                }
            }
            document.getElementById("tongTinChi").innerText = tongTinChi;
        }

        updateCount(); // Cập nhật khi trang tải
    });
</script>

</body>
</html>

<?php $mysqli->close(); ?>
