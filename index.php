<?php
include 'config.php';

$query = "SELECT * FROM karyawan ORDER BY id ASC";
$result = mysqli_query($conn, $query);

$status = isset($_GET['status']) ? $_GET['status'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manajemen Data Karyawan</title>
    <style>
        /* Reset & General */
        body {
            background-color: #f0f4f8;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        /* Container */
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            padding: 30px;
        }
        /* Header */
        .page-header h1 {
            text-align: center;
            font-size: 2.5rem;
            color: #005f73;
            margin-bottom: 5px;
        }
        .credit {
            text-align: center;
            font-style: italic;
            color: #0a9396;
            margin-bottom: 20px;
        }
        .credit-name {
            font-weight: 600;
        }
        .credit-nim {
            font-weight: 400;
        }
        /* Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
            font-size: 1rem;
        }
        .alert-success {
            background-color: #94d2bd;
            color: #004b40;
            border: 1px solid #0a7569;
        }
        .alert-error {
            background-color: #ef476f;
            color: white;
            border: 1px solid #b11226;
        }
        /* Action Bar */
        .action-bar {
            text-align: right;
            margin-bottom: 20px;
        }
        .btn-add {
            background-color: #0a9396;
            color: white;
            padding: 12px 22px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-add:hover {
            background-color: #005f73;
        }
        /* Table */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }
        thead th {
            background-color: #005f73;
            color: white;
            text-align: left;
            padding: 12px 15px;
            border-radius: 15px 15px 0 0;
        }
        tbody tr {
            background-color: #e0fbfc;
            border-radius: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        tbody td {
            padding: 15px;
            vertical-align: middle;
        }
        /* Buttons */
        .action-buttons .btn-edit,
        .action-buttons .btn-delete {
            border: none;
            padding: 7px 14px;
            margin-right: 8px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            color: white;
        }
        .btn-edit {
            background-color: #0077b6;
        }
        .btn-edit:hover {
            background-color: #023e8a;
        }
        .btn-delete {
            background-color: #d72631;
        }
        .btn-delete:hover {
            background-color: #a31420;
        }
        /* No Data */
        .no-data {
            text-align: center;
            font-size: 1.2rem;
            padding: 50px 0;
            color: #6c757d;
        }
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0; top: 0; width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
        }
        .modal.show {
            display: flex;
            animation: fadeIn 0.3s forwards;
        }
        .modal-content {
            background-color: white;
            border-radius: 15px;
            padding: 25px 30px;
            max-width: 420px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }
        .modal-header h2 {
            margin: 0 0 15px;
            color: #d72631;
        }
        .modal-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #d72631;
        }
        .modal-body p {
            font-size: 1.1rem;
            color: #444;
        }
        .modal-warning {
            color: #ff4d6d;
            font-weight: 600;
            margin-top: 10px;
        }
        .modal-footer {
            margin-top: 25px;
        }
        .btn-cancel,
        .btn-confirm-delete {
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.25s ease;
            border: none;
            margin: 5px;
        }
        .btn-cancel {
            background-color: #ccc;
            color: #444;
        }
        .btn-cancel:hover {
            background-color: #999;
            color: white;
        }
        .btn-confirm-delete {
            background-color: #d72631;
            color: white;
        }
        .btn-confirm-delete:hover {
            background-color: #a31420;
        }
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Manajemen Data Karyawan</h1>
            <div class="credit">
                <p class="credit-name">Ardyn Nugraha Regyan Septimus</p>
                <p class="credit-nim">(1204230031)</p>
            </div>
        </div>

        <?php if ($status == 'success' && $action == 'create'): ?>
            <div class="alert alert-success" id="alertBox">✅ Data karyawan udah berhasil ditambahkan!</div>
        <?php elseif ($status == 'success' && $action == 'update'): ?>
            <div class="alert alert-success" id="alertBox">✅ Data karyawan udah berhasil diupdate!</div>
        <?php elseif ($status == 'success' && $action == 'delete'): ?>
            <div class="alert alert-success" id="alertBox">✅ Data karyawan udah berhasil dihapus!</div>
        <?php elseif ($status == 'error'): ?>
            <div class="alert alert-error" id="alertBox">❌ Terjadi kesalahan! Silakan coba lagi.</div>
        <?php endif; ?>

        <div class="action-bar">
            <a href="create.php" class="btn btn-add">Tambah Karyawan</a>
        </div>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Gaji</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($result)): 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['jabatan']); ?></td>
                    <td>Rp <?php echo number_format($row['gaji'], 0, ',', '.'); ?></td>
                    <td class="action-buttons">
                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                        <button onclick="showDeleteModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['nama']); ?>')" class="btn btn-delete">Hapus</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="no-data">Belum ada data karyawan.</p>
        <?php endif; ?>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-icon">⚠️</span>
                <h2>Konfirmasi Hapus Data</h2>
            </div>
            <div class="modal-body">
                <p>Yakin mau hapus data <strong id="employeeName"></strong>?</p>
                <p class="modal-warning">Data yang dihapus tidak bisa dikembalikan!</p>
            </div>
            <div class="modal-footer">
                <button onclick="closeModal()" class="btn btn-cancel">Batal</button>
                <a href="#" id="confirmDelete" class="btn btn-confirm-delete">Ya, Hapus wae</a>
            </div>
        </div>
    </div>

    <script>
        const alertBox = document.getElementById('alertBox');
        if (alertBox) {
            setTimeout(function() {
                alertBox.style.opacity = '0';
                alertBox.style.transform = 'translateY(-20px)';

                setTimeout(function() {
                    alertBox.remove();
                }, 300);
            }, 3000);

            if (window.history.replaceState) {
                window.history.replaceState({}, document.title, "index.php");
            }
        }

        function showDeleteModal(id, name) {
            const modal = document.getElementById('deleteModal');
            const employeeName = document.getElementById('employeeName');
            const confirmBtn = document.getElementById('confirmDelete');

            employeeName.textContent = name;
            confirmBtn.href = 'delete.php?id=' + id;
            modal.style.display = 'flex';

            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('show');

            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                closeModal();
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>
