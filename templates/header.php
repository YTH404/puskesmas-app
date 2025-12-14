<!-- Page Header -->
<!-- Top Navbar -->
        <nav class="topbar">
            <div class="topbar-content">
                <div class="topbar-left">
                    <button class="menu-toggle" id="menuToggle">☰</button>
                    <h1 class="page-title-bar"><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Puskesmas Management System'; ?></h1>
                </div>
                <div class="topbar-right">
                    <span class="user-info">👤 <?php echo isset($_SESSION['nama_admin']) ? htmlspecialchars($_SESSION['nama_admin']) : ''; ?> </span>
                </div>
            </div>
        </nav>
        
        <!-- Page Content -->
        <div class="container">
