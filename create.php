<?php
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $gaji = mysqli_real_escape_string($conn, $_POST['gaji']);
    
    // Validasi sederhana
    if (empty($nama) || empty($jabatan) || empty($gaji)) {
        $error = "Semua field harus diisi!";
    } else {
        // PERHATIAN: Gunakan Prepared Statements untuk keamanan yang lebih baik!
        // Contoh: $stmt = $conn->prepare("INSERT INTO karyawan (nama, jabatan, gaji) VALUES (?, ?, ?)");
        // $stmt->bind_param("ssi", $nama, $jabatan, $gaji);
        // $stmt->execute();
        
        $query = "INSERT INTO karyawan (nama, jabatan, gaji) VALUES ('$nama', '$jabatan', '$gaji')";
        
        if (mysqli_query($conn, $query)) {
            header("Location: index.php?status=success&action=create");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota Tim</title>
    <style>
        /* Modern Color Palette (Sama dengan index.php) */
        :root {
            --primary-color: #0077b6; /* Blue */
            --secondary-color: #00b4d8; /* Light Blue/Teal */
            --background-body: #eef4f8; /* Background Body: Soft light blue/grey */
            --background-surface: #ffffff; /* Card/Container BG: White */
            --text-color: #343a40; /* Dark Text */
            --success-bg: #90e0ef;
            --success-text: #005f73;
            --error-bg: #ef476f; /* Bright Pink Error */
            --error-text: #ffffff;
            --btn-primary: #0077b6; /* Primary Button Color (Simpan) */
            --btn-secondary: #adb5bd; /* Secondary Button Color (Batal) */
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

        /* Container (Meniru Card di Index) */
        .container {
            max-width: 600px;
            margin: 80px auto; /* Lebih tinggi di tengah */
            background-color: var(--background-surface); 
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        /* Header */
        h1 {
            text-align: center;
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 700;
        }

        /* Alerts (Sama dengan Index) */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 600;
            text-align: center;
            font-size: 1rem;
        }

        .alert-error {
            background-color: var(--error-bg);
            color: var(--error-text);
            border: 1px solid #c82333;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-color);
        }

        .form-group input[type="text"],
        .form-group input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(0, 180, 216, 0.2);
            outline: none;
        }

        /* Form Actions & Buttons */
        .form-actions {
            margin-top: 30px;
            text-align: right;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-primary {
            background-color: var(--btn-primary);
            color: white;
            box-shadow: 0 4px 10px rgba(0, 119, 182, 0.3);
        }

        .btn-primary:hover {
            background-color: #023e8a;
            box-shadow: 0 6px 15px rgba(0, 119, 182, 0.4);
        }

        .btn-secondary {
            background-color: var(--btn-secondary);
            color: var(--text-color);
        }

        .btn-secondary:hover {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Anggota Tim</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-error">❌ <?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" required value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="jabatan">Jabatan:</label>
                <input type="text" id="jabatan" name="jabatan" required value="<?php echo isset($_POST['jabatan']) ? htmlspecialchars($_POST['jabatan']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="gaji">Gaji (Rp):</label>
                <input type="number" id="gaji" name="gaji" required min="0" value="<?php echo isset($_POST['gaji']) ? htmlspecialchars($_POST['gaji']) : ''; ?>">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
