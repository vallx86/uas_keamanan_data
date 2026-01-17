<h3>File Viewer (Whitelisted)</h3>

<?php
    $file = isset($_GET['file']) ? $_GET['file'] : 'intro.txt';
    
    // AMAN: Whitelisting (Cuma bolehin file tertentu)
    $allowed = ['intro.txt', 'readme.txt'];

    echo "<div class='card p-3 border border-success'>";
    
    if(in_array($file, $allowed)) {
        echo "<b>Isi File ($file):</b><hr>";
        include($file);
    } else {
        echo "<div class='text-danger fw-bold'>AKSES DITOLAK: File tidak diizinkan!</div>";
    }
    
    echo "</div>";
?>