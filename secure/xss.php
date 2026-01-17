<h3>Komentar Aman (Sanitized)</h3>
<div class="card p-4 mt-3 shadow-sm border-success">
    <form method="POST">
        <label class="form-label">Tinggalkan Pesan:</label>
        <div class="input-group mb-3">
            <input type="text" name="komen" class="form-control" placeholder="Script ga akan jalan disini...">
            <button class="btn btn-success" type="submit">Kirim (Secure)</button>
        </div>
    </form>
    
    <div class="mt-3">
        <?php
        if(isset($_POST['komen'])) {
            echo "<h5>Output:</h5>";
            // AMAN: Pake htmlspecialchars() mengubah <script> jadi teks biasa
            echo "User berkata: " . htmlspecialchars($_POST['komen'], ENT_QUOTES, 'UTF-8'); 
        }
        ?>
    </div>
</div>