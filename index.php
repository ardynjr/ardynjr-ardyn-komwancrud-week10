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
    <title>Data Anggota Tim</title>
    <style>
        /* Modern Color Palette */
        :root {
            --primary-color: #0077b6; /* Blue */
            --secondary-color: #00b4d8; /* Light Blue/Teal */
            --background-body: #eef4f8; /* Background Body: Soft light blue/grey */
            --background-surface: #ffffff; /* Card/Container BG: White */
            --text-color: #343a40; /* Dark Text */
            --success-bg: #90e0ef; /* Light Teal Success */
            --success-text: #005f73;
            --error-bg: #ef476f; /* Bright Pink Error */
            --error-text: #ffffff;
            --delete-btn: #dc3545; /* Red Delete */
            --edit-btn: #0077b6; /* Blue Edit */
            /* Warna tambahan untuk credit section */
            --credit-bg: #0077b6; /* Sangat lembut, biru keabu-abuan */
            --credit-text-dark: #ffffff; /* Biru tua untuk nama */
            --credit-text-light: #ffffff; /* Biru keabu-abuan untuk NIM */
        }

        /* Reset & General */
        body {
            background-color: var(--background-body); 
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--text-color);
            margin: 0;
            padding: 40px 20px;
            line-height: 1.6;
        }

        /* Container */
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: var(--background-surface); 
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        /* Header */
        .page-header h1 {
            text-align: center;
            font-size: 2.8rem;
            color: var(--primary-color);
            margin-bottom: 5px;
            font-weight: 700;
        }

        .credit {
            text-align: center;
            /* Perubahan di sini */
            background-color: var(--credit-bg); /* Warna background baru */
            padding: 15px 20px; /* Padding agar tidak terlalu mepet */
            border-radius: 10px; /* Sudut membulat */
            margin: 0 auto 30px auto; /* Margin atas bawah dan tengah */
            max-width: fit-content; /* Lebar sesuai konten */
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); /* Sedikit bayangan */
            font-style: normal; /* Menghilangkan italic dari .credit */
        }
        .credit-name {
            font-weight: 600;
            color: var(--credit-text-dark); /* Warna teks lebih gelap */
            font-size: 1.1rem; /* Ukuran font sedikit lebih besar */
            margin-bottom: 5px;
            display: block; /* Memastikan setiap p berada di baris baru */
        }
        .credit-nim {
            font-weight: 400;
            color: var(--credit-text-light); /* Warna teks sedikit lebih terang */
            font-size: 0.95rem;
            display: block; /* Memastikan setiap p berada di baris baru */
        }


        /* Alerts */
        .alert {
            padding: 18px 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            font-weight: 600;
            text-align: center;
            font-size: 1.05rem;
            opacity: 1;
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .alert-success {
            background-color: var(--success-bg);
            color: var(--success-text);
            border: 1px solid var(--success-text);
        }

        .alert-error {
            background-color: var(--error-bg);
            color: var(--error-text);
            border: 1px solid #c82333;
        }

        /* Action Bar */
        .action-bar {
            text-align: right;
            margin-bottom: 25px;
        }

        .btn-add {
            background-color: var(--secondary-color);
            color: var(--text-color);
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 180, 216, 0.3);
        }

        .btn-add:hover {
            background-color: #00a4c2;
            box-shadow: 0 6px 15px rgba(0, 180, 216, 0.5);
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px; 
        }

        thead th {
            background-color: var(--primary-color);
            color: white;
            text-align: left;
            padding: 15px 20px;
            font-weight: 600;
        }

        thead tr:first-child th:first-child { border-top-left-radius: 10px; }
        thead tr:first-child th:last-child { border-top-right-radius: 10px; }

        tbody tr {
            background-color: var(--background-surface); 
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        tbody td {
            padding: 18px 20px;
            vertical-align: middle;
        }
        
        tbody tr:last-child td:first-child { border-bottom-left-radius: 10px; }
        tbody tr:last-child td:last-child { border-bottom-right-radius: 10px; }


        /* Buttons */
        .action-buttons .btn-edit,
        .action-buttons .btn-delete {
            border: none;
            padding: 8px 16px;
            margin-right: 10px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            color: white;
        }

        .btn-edit {
            background-color: var(--edit-btn);
        }

        .btn-edit:hover {
            background-color: #023e8a;
        }

        .btn-delete {
            background-color: var(--delete-btn);
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        /* No Data */
        .no-data {
            text-align: center;
            font-size: 1.4rem;
            padding: 60px 0;
            color: #6c757d;
            border: 2px dashed #ced4da;
            border-radius: 10px;
            background-color: #e9ecef;
            margin-top: 30px;
        }

        /* Modal (Dibiarkan sama) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0; top: 0; width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.6);
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
            padding: 30px 40px;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            text-align: center;
            transform: scale(0.9);
            animation: scaleIn 0.3s forwards;
        }

        .modal.show .modal-content {
            transform: scale(1);
        }

        .modal-header h2 {
            margin: 0 0 15px;
            color: var(--delete-btn);
            font-size: 1.8rem;
        }

        .modal-icon {
            font-size: 3rem;
            margin-bottom: 10px;
            color: var(--delete-btn);
        }

        .modal-body p {
            font-size: 1.1rem;
            color: #444;
        }

        .modal-warning {
            color: var(--delete-btn);
            font-weight: 600;
            margin-top: 15px;
            display: block;
        }

        .modal-footer {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn-cancel,
        .btn-confirm-delete {
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.25s ease;
            border: none;
            text-decoration: none;
        }

        .btn-cancel {
            background-color: #adb5bd;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #6c757d;
        }

        .btn-confirm-delete {
            background-color: var(--delete-btn);
            color: white;
        }

        .btn-confirm-delete:hover {
            background-color: #c82333;
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        @keyframes scaleIn {
            from {transform: scale(0.9);}
            to {transform: scale(1);}
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Data Anggota Tim</h1>
            <div class="credit">
                <p class="credit-name">Ardyn Nugraha Regyan Septimus</p>
                <p class="credit-nim">(1204230031)</p>
            </div>
        </div>

        <?php if ($status == 'success' && $action == 'create'): ?>
            <div class="alert alert-success" id="alertBox">✅ Data Anggota Tim udah berhasil ditambahkan!</div>
        <?php elseif ($status == 'success' && $action == 'update'): ?>
            <div class="alert alert-success" id="alertBox">✅ Data Anggota Tim udah berhasil diupdate!</div>
        <?php elseif ($status == 'success' && $action == 'delete'): ?>
            <div class="alert alert-success" id="alertBox">✅ Data Anggota Tim udah berhasil dihapus!</div>
        <?php elseif ($status == 'error'): ?>
            <div class="alert alert-error" id="alertBox">❌ Terjadi kesalahan! Silakan coba lagi.</div>
        <?php endif; ?>

        <div class="action-bar">
            <a href="create.php" class="btn btn-add">➕ Tambah Anggota Tim</a>
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
                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">📝 Edit</a>
                        <button onclick="showDeleteModal(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['nama']); ?>')" class="btn btn-delete">🗑️ Hapus</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="no-data">Data Anggota Tim masih kosong. Yuk, tambahkan data pertama!</p>
        <?php endif; ?>
    </div>

    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-icon">⚠️</span>
                <h2>Konfirmasi Hapus Data</h2>
            </div>
            <div class="modal-body">
                <p>Yakin mau hapus data **<strong id="employeeName"></strong>**?</p>
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
            // Animasi fade out
            setTimeout(function() {
                alertBox.style.opacity = '0';
                alertBox.style.transform = 'translateY(-20px)';

                setTimeout(function() {
                    alertBox.remove();
                }, 500); // Tunggu sampai transisi opacity selesai
            }, 3000); // Durasi tampil 3 detik

            // Hapus parameter GET dari URL tanpa me-reload (clean URL)
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
            
            // Set display flex sebelum menambahkan class 'show' untuk memicu transisi
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
            }, 300); // Sesuaikan dengan durasi transisi
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
