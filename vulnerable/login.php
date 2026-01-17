<h3>Admin Authentication Portal</h3>
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card card-login bg-white">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Username</label>
                    <input type="text" name="user" class="form-control" placeholder="Enter username">
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Password</label>
                    <input type="password" name="pass" class="form-control" placeholder="Enter password">
                </div>
                <button type="submit" name="login" class="btn btn-dark-custom w-100 py-2">LOGIN</button>
            </form>
            
            <?php
            // KODE RENTAN (VULNERABLE)
            if(isset($_POST['login'])) {
                $user = $_POST['user'];
                $pass = $_POST['pass'];
                
                // Hardcode & Plaintext, gampang di brute force
                if($user == 'admin' && $pass == 'admin123') {
                    echo "<div class='alert alert-success mt-3'>Login Berhasil! Flag: {VULN_LOGIN_SUCCESS}</div>";
                } else {
                    // Pesan error spesifik (Enumeration risk)
                    echo "<div class='alert alert-danger mt-3'>Password salah bro.</div>";
                }
            }
            ?>
            <div class="text-center mt-4 small text-muted">Security Protocol: DISABLED</div>
        </div>
    </div>
</div>