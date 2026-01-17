<?php
// KONFIGURASI KEAMANAN
$max_attempts = 3;          // Maksimal coba login
$lockout_time = 30;         // Kunci 30 detik kalo gagal terus

// Cek status lockout
if (isset($_SESSION['blocked_time']) && time() < $_SESSION['blocked_time']) {
    $remaining = $_SESSION['blocked_time'] - time();
    $is_locked = true;
} else {
    // Kalo waktu block udah abis, reset
    if (isset($_SESSION['blocked_time'])) {
        unset($_SESSION['attempts']);
        unset($_SESSION['blocked_time']);
    }
    $is_locked = false;
}

// Generate CSRF Token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
?>

<h3>Admin Authentication Portal <span class="badge bg-success">SECURE MODE</span></h3>
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card card-login bg-white border-top border-success border-3">
            
            <?php if ($is_locked): ?>
                <div class="alert alert-danger text-center">
                    <i class="fas fa-ban fa-3x mb-3"></i><br>
                    <strong>TERLALU BANYAK PERCOBAAN!</strong><br>
                    Silakan tunggu <span id="countdown" class="fw-bold"><?= $remaining ?></span> detik.
                </div>
                <script>
                    // Script hitung mundur simpel biar keren
                    let time = <?= $remaining ?>;
                    setInterval(() => {
                        time--;
                        if(time <= 0) location.reload();
                        document.getElementById('countdown').innerText = time;
                    }, 1000);
                </script>
            <?php else: ?>

                <form method="POST">
                    <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">USERNAME</label>
                        <input type="text" name="user" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">PASSWORD</label>
                        <input type="password" name="pass" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-success w-100 py-2">
                        <i class="fas fa-shield-alt me-2"></i>SECURE LOGIN
                    </button>
                </form>

            <?php endif; ?>
            
            <?php
            // PROSES LOGIN (BACKEND)
            if(isset($_POST['login']) && !$is_locked) {
                // 1. Cek CSRF
                if($_POST['token'] !== $_SESSION['token']) die("Invalid CSRF Token");

                // 2. Ambil Input & Filter
                $user = htmlspecialchars($_POST['user']);
                $pass = $_POST['pass'];

                // 3. Simulasi Cek Password (Hash Verification)
                // Anggap password benar: admin / admin123
                if($user === 'admin' && $pass === 'admin123') {
                    
                    // LOGIN SUKSES -> Reset attempt
                    unset($_SESSION['attempts']);
                    echo "<div class='alert alert-success mt-3'><strong>Login Berhasil!</strong><br>Selamat datang, Administrator.</div>";
                    
                } else {
                    
                    // LOGIN GAGAL -> Tambah counter
                    if (!isset($_SESSION['attempts'])) $_SESSION['attempts'] = 0;
                    $_SESSION['attempts']++;
                    
                    $sisa = $max_attempts - $_SESSION['attempts'];

                    // Cek apakah harus diblokir?
                    if ($_SESSION['attempts'] >= $max_attempts) {
                        $_SESSION['blocked_time'] = time() + $lockout_time;
                        // Refresh halaman biar mode terkunci aktif
                        echo "<script>window.location.href='?mode=secure&page=login';</script>";
                    } else {
                        echo "<div class='alert alert-warning mt-3'>
                                <strong>Login Gagal!</strong><br>
                                Sisa percobaan: $sisa kali lagi.
                              </div>";
                    }
                }
            }
            ?>
        </div>
    </div>
</div>