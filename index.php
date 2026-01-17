<?php
session_start();
$mode = isset($_GET['mode']) ? $_GET['mode'] : 'vulnerable';
$page = isset($_GET['page']) ? $_GET['page'] : 'login';
$allowed_pages = ['login', 'xss', 'lfi'];
if (!in_array($page, $allowed_pages)) { $page = 'login'; }
$target_file = "$mode/$page.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UjiCoba Kerentanan - Keamanan Data Dan Informasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="app-container">

    <div class="top-header d-flex justify-content-between align-items-center">
        <div>
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary rounded p-1 text-white d-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                    <i class="fas fa-terminal"></i>
                </div>
                <div>
                    <h6 class="m-0 fw-bold" style="line-height: 1;">UjiCoba Kerentanan <span class="badge bg-primary rounded-pill ms-1" style="font-size: 0.6rem; vertical-align: middle;">v1.0</span></h6>
                    <div class="dev-info mt-1" style="font-size: 0.7rem;">Rizky Rivaldy (C2C023067)</div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="small text-muted fw-bold" style="font-size: 0.7rem;">ENV_MODE :</span>
            <div class="btn-mode-group">
                <a href="?mode=vulnerable&page=<?= $page ?>" class="btn-mode <?= $mode == 'vulnerable' ? 'active-vuln' : '' ?>">VULN</a>
                <a href="?mode=secure&page=<?= $page ?>" class="btn-mode <?= $mode == 'secure' ? 'active-secure' : '' ?>">SECURE</a>
            </div>
        </div>
    </div>

    <div class="layout-wrapper">
        
        <div class="sidebar d-none d-md-block">
            <div class="menu-label">MENU PENGUJIAN</div>
            <nav class="nav flex-column">
                <a class="nav-link <?= $page == 'login' ? 'active' : '' ?>" href="?mode=<?= $mode ?>&page=login">
                    <i class="fas fa-lock"></i> Auth Bypass
                </a>
                <a class="nav-link <?= $page == 'xss' ? 'active' : '' ?>" href="?mode=<?= $mode ?>&page=xss">
                    <i class="fas fa-comment-dots"></i> XSS Injection
                </a>
                <a class="nav-link <?= $page == 'lfi' ? 'active' : '' ?>" href="?mode=<?= $mode ?>&page=lfi">
                    <i class="fas fa-file-code"></i> LFI / Traversal
                </a>
            </nav>
        </div>

        <div class="main-content">
            <div class="alert alert-status <?= $mode == 'vulnerable' ? 'alert-vuln' : 'alert-secure' ?> p-2 px-3 mb-4 rounded shadow-sm" style="font-size: 0.9rem;">
                <div>
                    <i class="fas <?= $mode == 'vulnerable' ? 'fa-exclamation-triangle' : 'fa-check-circle' ?> me-2"></i> 
                    Status Sistem: <strong><?= strtoupper($mode) ?></strong>
                </div>
                <span class="badge bg-light text-dark border fw-normal">Port: 8080 (Simulated)</span>
            </div>

            <div style="position: relative; z-index: 2;">
                <?php 
                    if (file_exists($target_file)) {
                        include($target_file);
                    } else {
                        echo "File not found.";
                    }
                ?>
            </div>

            <i class="fas fa-shield-alt bg-watermark"></i>

            <div class="footer-text">
                &copy; 2026-Valdyyy. All Rights Reserved. | Build 1.0.4
            </div>
        </div>
    </div>

</div> </body>
</html>