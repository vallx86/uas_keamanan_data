<h3>File Viewer (LFI Vulnerability)</h3>
<div class="alert alert-warning">
    Coba ganti URL di atas jadi: <code>?mode=vulnerable&page=lfi&file=../../windows/win.ini</code> (Kalo di windows)
</div>

<?php
    $file = isset($_GET['file']) ? $_GET['file'] : 'intro.txt';
    
    // Buat file dummy biar ga error pas pertama load
    if(!file_exists('intro.txt')) file_put_contents('intro.txt', 'Selamat datang di menu File Viewer.');

    echo "<div class='card p-3 border border-danger'>";
    echo "<b>Isi File ($file):</b><hr>";
    
    // RENTAN: Include file apa aja yang diminta user
    // Matikan warning biar ga jelek tampilannya
    @include($file); 
    
    echo "</div>";
?>