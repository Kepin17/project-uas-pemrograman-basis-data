<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Perpustakaan'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color:rgb(16, 8, 31); /* Deep Purple */
            --secondary-color:rgb(19, 10, 40); /* Darker Purple */
            --accent-color: #ff4081; /* Light Pink */
            --text-color: #2c3e50;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: var(--text-color);
            font-family: roboto, sans-serif;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            background: var(--secondary-color);
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .menu-item:hover, .menu-item.active {
            background: var(--accent-color);
            color: white;
            text-decoration: none;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .right-btn {
            position: relative;
            right: -10rem;
            transition: .5s;
        }

        .closeactive {
            position: relative;
            right: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .toggle-sidebar {
                display: block !important;
            }
        }

        /* Header Styles */
        .main-header {
            background: white;
            padding: 15px 30px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        /* Utility Classes */
        .text-primary {
            color: var(--primary-color) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-primary:hover {
            background-color: #d81b60;
            border-color: #d81b60;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->

    <div class="sidebar">
       
        <div class="sidebar-header">
           <img src="images/logo.png" alt="logo " width="200px">
        </div>
        <div class="sidebar-menu">
            <a href="<?php echo BASE_URL; ?>/dashboard" class="menu-item <?php echo $currentPage == 'dashboard' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>

            <?php 
            $roleId = $_SESSION['id_jabatan'] ?? '';
            
            // Menu for Staff Pelayanan (JB007)
            if ($roleId === 'JB007'): ?>
                <a href="<?php echo BASE_URL; ?>/peminjaman" class="menu-item <?php echo $currentPage == 'borrowing' ? 'active' : ''; ?>">
                    <i class="fas fa-hand-holding"></i> Peminjaman
                </a>
                <a href="<?php echo BASE_URL; ?>/returning" class="menu-item <?php echo $currentPage == 'returning' ? 'active' : ''; ?>">
                    <i class="fas fa-undo"></i> Pengembalian
                </a>
            <?php endif; ?>

            <?php 
            // Menu for Staff Administrasi (JB003)
            if ($roleId === 'JB003'): ?>
                <a href="<?php echo BASE_URL; ?>/books" class="menu-item <?php echo $currentPage == 'books' ? 'active' : ''; ?>">
                    <i class="fas fa-book"></i> Manajemen Buku
                </a>
                <a href="<?php echo BASE_URL; ?>/shelves" class="menu-item <?php echo $currentPage == 'shelves' ? 'active' : ''; ?>">
                    <i class="fas fa-bookmark"></i> Rak Buku
                </a>
                <a href="<?php echo BASE_URL; ?>/categories" class="menu-item <?php echo $currentPage == 'categories' ? 'active' : ''; ?>">
                    <i class="fas fa-tags"></i> Kategori
                </a>
                <a href="<?php echo BASE_URL; ?>/members" class="menu-item <?php echo $currentPage == 'members' ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> Anggota
                </a>
            <?php endif; ?>

            <?php 
            // Menu for Wakil Kepala and Kepala Perpustakaan (JB002 and JB001)
            if ($roleId === 'JB002' || $roleId === 'JB001'): ?>
                <a href="<?php echo BASE_URL; ?>/position" class="menu-item <?php echo $currentPage == 'position' ? 'active' : ''; ?>">
                    <i class="fas fa-user"></i> Jabatan
                </a>
                <a href="<?php echo BASE_URL; ?>/staff" class="menu-item <?php echo $currentPage == 'staff' ? 'active' : ''; ?>">
                    <i class="fas fa-user-tie"></i> Staff
                </a>
            <?php endif; ?>

            <a href="<?php echo BASE_URL; ?>/logout" class="menu-item">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Toggle Sidebar Button (visible on mobile) -->
         <div class="btn-wrapper d-flex justify-content-between align-items-center">
        <button class="btn btn-primary toggle-sidebar leftBtn d-md-none mb-3 mx-4">
                 <i class="fas fa-bars"></i>
        </button>
      
        <button class="btn btn-primary toggle-sidebar right-btn d-md-none mb-3 mx-4">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
        <nav class="d-flex justify-content-between align-items-center main-header">  
            <div style=" display: flex; justify-content: space-between; width: 100%;">
                <h5><?php echo $pageTitle ?? 'Perpustakaan'; ?></h5>
                <div >
                    <h6><?php echo date('l, d F Y');?></h6>
                    <h6>Hi <?php echo isset($_SESSION['nama_petugas']) ? $_SESSION['nama_petugas'] : 'Bro'; ?>!</h6>
               
                </div>
            </div>
        </nav>
        <?php echo $content ?? ''; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        const leftbtn = document.querySelector('.leftBtn');
        const rightBtn = document.querySelector('.right-btn');
        const sidebar = document.querySelector('.sidebar');
        // Toggle Sidebar on Mobile
        leftbtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            rightBtn.classList.toggle('closeactive');
        });

        rightBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            rightBtn.classList.toggle('closeactive');
            
        });
    </script>
</body>
</html>
