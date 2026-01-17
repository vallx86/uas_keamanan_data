<h3>Simulasi Komentar (Reflected XSS)</h3>
<div class="card p-4 mt-3 shadow-sm border-0">
    <form method="POST">
        <label class="form-label">Tinggalkan Pesan:</label>
        <div class="input-group mb-3">
            <input type="text" name="komen" class="form-control" placeholder="Coba ketik <script>alert(1)</script>">
            <button class="btn btn-danger" type="submit">Kirim (Unsafe)</button>
        </div>
    </form>
    
    <div class="mt-3">
        <?php
        if(isset($_POST['komen'])) {
            echo "<h5>Output:</h5>";
            // RENTAN: Langsung echo tanpa filter
            echo "User berkata: " . $_POST['komen']; 
        }
        ?>
    </div>
</div>