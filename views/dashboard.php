<?php
require_once '../database.php';
require '../tiket.php';
require_once '../tiketRegular.php';
require_once '../tiketIMAX.php';
require_once '../tiketVelvet.php';

class Dashboard extends Database{
    protected $tabel = "tabel_tiket";

    public function seluruhdataTiket(){
        $query = "SELECT * FROM $this->tabel";
        return mysqli_query($this->koneksi,$query);
    }

    public function dataTiketReguler(){
        $query = "SELECT * FROM $this->tabel ".TiketRegular::getData();
        $result = mysqli_query($this->koneksi,$query);
        $daftarTiket = [];
        while ($row = mysqli_fetch_assoc($result)){
            $daftarTiket[] = new TiketRegular(
                $row['id_tiket'],
                $row['nama_film'],
                $row['jadwal_tayang'],
                $row['jumlah_kursi'],
                $row['harga_dasar_tiket'],
                $row['tipe_audio'],
                $row['lokasi_baris']
            );
        }
        return $daftarTiket;
    }

    public function dataTiketIMAX(){
        $query = "SELECT * FROM $this->tabel ".TiketIMAX::getData();
        $result = mysqli_query($this->koneksi,$query);
        $daftarTiket = [];
        while ($row = mysqli_fetch_assoc($result)){
            $daftarTiket[] = new TiketIMAX(
                $row['id_tiket'],
                $row['nama_film'],
                $row['jadwal_tayang'],
                $row['jumlah_kursi'],
                $row['harga_dasar_tiket'],
                $row['kacamata_3d_id'],
                $row['efek_gerak_fitur']
            );
        }
        return $daftarTiket;
    }

    public function dataTiketVelvet(){
        $query = "SELECT * FROM $this->tabel ".TiketVelvet::getData();
        $result = mysqli_query($this->koneksi,$query);
        $daftarTiket = [];
        while ($row = mysqli_fetch_assoc($result)){
            $daftarTiket[] = new TiketVelvet(
                $row['id_tiket'],
                $row['nama_film'],
                $row['jadwal_tayang'],
                $row['jumlah_kursi'],
                $row['harga_dasar_tiket'],
                $row['bantal_selimut_pack'],
                $row['layanan_butler']
            );
        }
        return $daftarTiket;
    }
}

$dashboard_tabel = new Dashboard();
$dataRegular = $dashboard_tabel->dataTiketReguler();
$dataIMAX = $dashboard_tabel->dataTiketIMAX();
$dataVelvet = $dashboard_tabel->dataTiketVelvet();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Tiket Bioskop - Premium</title>
    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-sidebar: #0f172a;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow: rgba(15, 23, 42, 0.04);
            --sidebar-active: #1e293b;
            --bg-profile: #1e293b;
            --modal-overlay: rgba(15, 23, 42, 0.6);
            
            --primary: #3b82f6;
            --primary-light: #eff6ff;
            --success: #10b981;
            --success-light: #ecfdf5;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --danger: #ef4444;
            --danger-light: #fef2f2;
        }

        [data-theme="dark"] {
            --bg-body: #0b0f19;
            --bg-sidebar: #05070c;
            --bg-card: #111827;
            --text-main: #f3f4f6;
            --text-muted: #9ca3af;
            --border-color: #1f2937;
            --shadow: rgba(0, 0, 0, 0.4);
            --sidebar-active: #1f2937;
            --bg-profile: #111827;
            --modal-overlay: rgba(0, 0, 0, 0.8);
            
            --primary-light: rgba(59, 130, 246, 0.1);
            --success-light: rgba(16, 185, 129, 0.1);
            --warning-light: rgba(245, 158, 11, 0.1);
            --danger-light: rgba(239, 68, 68, 0.1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; transition: background 0.2s, color 0.2s, border-color 0.2s; }
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; background-color: var(--bg-body); color: var(--text-main); display: flex; min-height: 100vh; }

        /* Sidebar Styling */
        .sidebar { width: 260px; background-color: var(--bg-sidebar); color: #fff; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 10; justify-content: space-between; }
        .sidebar-top { display: flex; flex-direction: column; width: 100%; }
        .sidebar-brand { padding: 25px 20px; font-size: 18px; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.05); letter-spacing: 0.5px; display: flex; align-items: center; gap: 10px; }
        .sidebar-menu { list-style: none; padding: 20px 0; }
        .sidebar-menu li a { display: block; padding: 14px 20px; color: #94a3b8; text-decoration: none; font-size: 14px; font-weight: 500; border-left: 4px solid transparent; cursor: pointer; }
        .sidebar-menu li a:hover, .sidebar-menu li.active a { background-color: var(--sidebar-active); color: #fff; border-left-color: var(--primary); }

        /* Profile Sidebar */
        .sidebar-profile { display: flex; align-items: center; gap: 12px; padding: 15px 20px; background-color: var(--bg-profile); border-top: 1px solid rgba(255,255,255,0.05); width: 100%; cursor: pointer; }
        .sidebar-profile:hover { background-color: var(--sidebar-active); }
        .profile-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary); }
        .profile-info { display: flex; flex-direction: column; overflow: hidden; }
        .profile-name { font-size: 13px; font-weight: 600; color: #ffffff; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; }
        .profile-role { font-size: 11px; color: #64748b; }

        /* Main Content */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; max-width: calc(100% - 260px); }
        
        /* Top Navbar Layout */
        .top-navbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
        .search-container input { padding: 12px 24px; width: 380px; border: 1px solid var(--border-color); border-radius: 30px; background: var(--bg-card); color: var(--text-main); outline: none; box-shadow: 0 4px 6px -1px var(--shadow); font-size: 14px; }
        .search-container input:focus { border-color: var(--primary); }
        
        /* Theme Switch */
        .theme-switch-wrapper { display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--text-muted); font-weight: 500; }
        .theme-switch { display: inline-block; height: 24px; position: relative; width: 48px; }
        .theme-switch input { display:none; }
        .slider { background-color: #cbd5e1; bottom: 0; cursor: pointer; left: 0; position: absolute; right: 0; top: 0; transition: .4s; border-radius: 34px; }
        .slider:before { background-color: white; bottom: 4px; content: ""; height: 16px; left: 4px; position: absolute; transition: .4s; width: 16px; border-radius: 50%; }
        input:checked + .slider { background-color: var(--primary); }
        input:checked + .slider:before { transform: translateX(24px); }

        /* Sections Content Wrapper */
        .content-section { margin-bottom: 45px; }
        .section-header { border-left: 4px solid var(--primary); padding-left: 14px; font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 25px; letter-spacing: -0.3px; display: flex; align-items: center; justify-content: space-between; }
        .imax-border { border-left-color: var(--warning); }
        .velvet-border { border-left-color: var(--danger); }

        /* --- MODERN CARD GRID DESIGN --- */
        .card-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; }
        
        .ticket-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 4px 6px -1px var(--shadow); position: relative; overflow: hidden; transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .ticket-card:hover { transform: translateY(-4px); box-shadow: 0 12px 20px -3px var(--shadow); border-color: rgba(59, 130, 246, 0.3); }

        /* Card Header & Badges */
        .card-header-info { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
        .ticket-id { font-size: 12px; font-weight: 700; color: var(--text-muted); font-family: monospace; background: var(--bg-body); padding: 4px 8px; border-radius: 6px; }
        
        .studio-tag { font-size: 11px; font-weight: 700; text-transform: uppercase; padding: 4px 10px; border-radius: 30px; letter-spacing: 0.5px; }
        .studio-tag.regular { background: var(--primary-light); color: var(--primary); }
        .studio-tag.imax { background: var(--warning-light); color: var(--warning); }
        .studio-tag.velvet { background: var(--danger-light); color: var(--danger); }

        /* Film Meta */
        .film-title { font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; line-height: 1.3; }
        .jadwal-time { font-size: 13px; color: var(--text-muted); display: flex; align-items: center; gap: 6px; margin-bottom: 18px; }

        /* Details Divider line */
        .card-divider { height: 1px; background: var(--border-color); margin: 0 0 16px 0; border: none; }

        /* Info Item Rows */
        .info-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 13.5px; }
        .info-label { color: var(--text-muted); }
        .info-value { font-weight: 600; color: var(--text-main); }
        
        /* Fasilitas Spesifik Box */
        .fasilitas-box { background: var(--bg-body); padding: 10px 14px; border-radius: 12px; font-size: 12.5px; color: var(--text-muted); line-height: 1.4; font-weight: 500; display: flex; align-items: center; gap: 8px; margin-top: 4px; margin-bottom: 16px; border: 1px dashed var(--border-color); }
        
        /* Card Footer Price */
        .card-footer-price { display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 12px; border-top: 1px solid var(--border-color); }
        .total-label { font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px; }
        .total-price { font-size: 18px; font-weight: 800; color: var(--success); font-family: monospace; }

        /* Empty & Alert State */
        .no-data-card { grid-column: 1 / -1; text-align: center; color: var(--text-muted); padding: 40px; border: 2px dashed var(--border-color); border-radius: 16px; font-size: 14px; }
        #search-alert { text-align: center; color: var(--danger); padding: 16px; font-weight: 500; background: var(--bg-card); border-radius: 12px; border: 1px solid var(--border-color); display: none; margin-bottom: 25px; font-size: 14px; }

        /* Modal Profile Layout */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: var(--modal-overlay); display: flex; justify-content: center; align-items: center; z-index: 1000; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; backdrop-filter: blur(4px); }
        .modal-overlay.open { opacity: 1; pointer-events: auto; }
        .modal-card { background-color: var(--bg-card); padding: 35px; border-radius: 24px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); width: 360px; text-align: center; position: relative; border: 1px solid var(--border-color); transform: scale(0.9); transition: transform 0.3s ease; }
        .modal-overlay.open .modal-card { transform: scale(1); }
        .modal-close { position: absolute; top: 20px; right: 20px; font-size: 20px; color: var(--text-muted); cursor: pointer; border: none; background: none; }
        .modal-avatar { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary); margin-bottom: 20px; }
        .modal-name { font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 4px; }
        .modal-role { font-size: 12px; color: var(--primary); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; }
        .modal-bio { font-size: 13px; color: var(--text-muted); line-height: 1.6; border-top: 1px solid var(--border-color); padding-top: 20px; }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="sidebar-top">
            <div class="sidebar-brand">🎬 Cinema Dashboard</div>
            <ul class="sidebar-menu">
                <li class="menu-item active" onclick="switchTab('all', this)"><a>📊 Semua Studio</a></li>
                <li class="menu-item" onclick="switchTab('regular', this)"><a>🍿 Studio Regular</a></li>
                <li class="menu-item" onclick="switchTab('imax', this)"><a>🕶️ Studio IMAX</a></li>
                <li class="menu-item" onclick="switchTab('velvet', this)"><a>🛏️ Studio Velvet</a></li>
            </ul>
        </div>

        <div class="sidebar-profile" onclick="openProfileModal()">
            <img class="profile-avatar" src="https://www.dunia-energi.com/wp-content/uploads/2024/10/Bahlil.jpeg" alt="Foto Profil">
            <div class="profile-info">
                <span class="profile-name">Buahlil</span>
                <span class="profile-role">Administrator</span>
            </div>
        </div>
    </nav>

    <main class="main-content">
        
        <header class="top-navbar">
            <div class="search-container">
                <input type="text" id="searchInput" onkeyup="filterData()" placeholder="Cari judul film, ID, atau fasilitas...">
            </div>
            <div class="theme-switch-wrapper">
                <span>🌞 Light</span>
                <label class="theme-switch" for="checkbox">
                    <input type="checkbox" id="checkbox" />
                    <div class="slider round"></div>
                </label>
                <span>🌙 Dark</span>
            </div>
        </header>

        <div id="search-alert">🔍 Film tidak ditemukan di seluruh kategori studio manapun.</div>

        <!-- STUDIO REGULAR -->
        <section id="section-regular" class="content-section">
            <h2 class="section-header">🍿 Kategori: Studio Regular</h2>
            <div class="card-grid">
                <?php if (empty($dataRegular)): ?>
                    <div class="no-data-card">Tidak ada data tiket Regular</div>
                <?php else: ?>
                    <?php foreach ($dataRegular as $tiket): ?>
                        <div class="ticket-card searchable-row">
                            <div>
                                <div class="card-header-info">
                                    <span class="ticket-id">#<?= $tiket->getIdTiket(); ?></span>
                                    <span class="studio-tag regular">Regular</span>
                                </div>
                                <h3 class="film-title"><?= $tiket->getNamaTiket(); ?></h3>
                                <div class="jadwal-time">📅 <?= date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</div>
                                <hr class="card-divider">
                                
                                <div class="info-row">
                                    <span class="info-label">Kapasitas</span>
                                    <span class="info-value"><?= $tiket->getJumlahKursi(); ?> Kursi</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Harga Dasar</span>
                                    <span class="info-value">Rp <?= number_format($tiket->getHargaDasarTiket(), 0, ',', '.'); ?></span>
                                </div>
                                
                                <div class="fasilitas-box">
                                    <span>✨</span> <span><?= $tiket->tampilkanInfoFasilitas(); ?></span>
                                </div>
                            </div>
                            
                            <div class="card-footer-price">
                                <span class="total-label">Total Bayar</span>
                                <span class="total-price">Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- STUDIO IMAX -->
        <section id="section-imax" class="content-section">
            <h2 class="section-header imax-border">🕶️ Kategori: Studio IMAX</h2>
            <div class="card-grid">
                <?php if (empty($dataIMAX)): ?>
                    <div class="no-data-card">Tidak ada data tiket IMAX</div>
                <?php else: ?>
                    <?php foreach ($dataIMAX as $tiket): ?>
                        <div class="ticket-card searchable-row">
                            <div>
                                <div class="card-header-info">
                                    <span class="ticket-id">#<?= $tiket->getIdTiket(); ?></span>
                                    <span class="studio-tag imax">IMAX 3D</span>
                                </div>
                                <h3 class="film-title"><?= $tiket->getNamaTiket(); ?></h3>
                                <div class="jadwal-time">📅 <?= date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</div>
                                <hr class="card-divider">
                                
                                <div class="info-row">
                                    <span class="info-label">Kapasitas</span>
                                    <span class="info-value"><?= $tiket->getJumlahKursi(); ?> Kursi</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Harga Dasar</span>
                                    <span class="info-value">Rp <?= number_format($tiket->getHargaDasarTiket(), 0, ',', '.'); ?></span>
                                </div>
                                
                                <div class="fasilitas-box" style="border-color: rgba(245, 158, 11, 0.3);">
                                    <span>🎬</span> <span><?= $tiket->tampilkanInfoFasilitas(); ?></span>
                                </div>
                            </div>
                            
                            <div class="card-footer-price">
                                <span class="total-label">Total Bayar</span>
                                <span class="total-price">Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <!-- STUDIO VELVET -->
        <section id="section-velvet" class="content-section">
            <h2 class="section-header velvet-border">🛏️ Kategori: Studio Velvet</h2>
            <div class="card-grid">
                <?php if (empty($dataVelvet)): ?>
                    <div class="no-data-card">Tidak ada data tiket Velvet</div>
                <?php else: ?>
                    <?php foreach ($dataVelvet as $tiket): ?>
                        <div class="ticket-card searchable-row">
                            <div>
                                <div class="card-header-info">
                                    <span class="ticket-id">#<?= $tiket->getIdTiket(); ?></span>
                                    <span class="studio-tag velvet">Velvet Class</span>
                                </div>
                                <h3 class="film-title"><?= $tiket->getNamaTiket(); ?></h3>
                                <div class="jadwal-time">📅 <?= date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</div>
                                <hr class="card-divider">
                                
                                <div class="info-row">
                                    <span class="info-label">Kapasitas</span>
                                    <span class="info-value"><?= $tiket->getJumlahKursi(); ?> Bed Pack</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Harga Dasar</span>
                                    <span class="info-value">Rp <?= number_format($tiket->getHargaDasarTiket(), 0, ',', '.'); ?></span>
                                </div>
                                
                                <div class="fasilitas-box" style="border-color: rgba(239, 68, 68, 0.3);">
                                    <span>🛋️</span> <span><?= $tiket->tampilkanInfoFasilitas(); ?></span>
                                </div>
                            </div>
                            
                            <div class="card-footer-price">
                                <span class="total-label">Total Bayar</span>
                                <span class="total-price">Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <div id="profileModal" class="modal-overlay" onclick="closeProfileModalOutside(event)">
        <div class="modal-card">
            <button class="modal-close" onclick="closeProfileModal()">&times;</button>
            <img class="modal-avatar" src="https://www.dunia-energi.com/wp-content/uploads/2024/10/Bahlil.jpeg" alt="Foto Profil Besar">
            <h3 class="modal-name">Buahlil</h3>
            <div class="modal-role">Developer / Administrator</div>
            <p class="modal-bio">Sistem Manajemen Tiket & Fasilitas Studio Bioskop Berbasis OOP PHP. Project Latihan Simulasi UAS Praktikum PBO.</p>
        </div>
    </div>

    <script>
        // --- 1. FITUR LIVE SEARCHING AUTO-COLLAPSE ---
        function filterData() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let sections = document.querySelectorAll('.content-section');
            let totalVisibleSections = 0;

            sections.forEach(section => {
                let cards = section.querySelectorAll('.searchable-row');
                let matchCount = 0;

                cards.forEach(card => {
                    let text = card.textContent.toLowerCase();
                    if (text.includes(input)) {
                        card.style.display = "flex"; 
                        matchCount++;
                    } else {
                        card.style.display = "none"; 
                    }
                });

                if (matchCount === 0 && input !== "") {
                    section.style.display = "none"; 
                } else {
                    section.style.display = "block"; 
                    totalVisibleSections++;
                }
            });

            let alertBox = document.getElementById('search-alert');
            if (totalVisibleSections === 0 && input !== "") {
                alertBox.style.display = "block";
            } else {
                alertBox.style.display = "none";
            }
        }

        // --- 2. FITUR NAVIGASI TAB SIDEBAR ---
        function switchTab(section, element) {
            document.querySelectorAll('.sidebar-menu li').forEach(li => li.classList.remove('active'));
            element.classList.add('active');

            document.getElementById('searchInput').value = "";
            document.getElementById('search-alert').style.display = "none";

            const regSection = document.getElementById('section-regular');
            const imaxSection = document.getElementById('section-imax');
            const vlvSection = document.getElementById('section-velvet');

            if(section === 'all') {
                regSection.style.display = "block";
                imaxSection.style.display = "block";
                vlvSection.style.display = "block";
            } else {
                regSection.style.display = "none";
                imaxSection.style.display = "none";
                vlvSection.style.display = "none";
                document.getElementById('section-' + section).style.display = "block";
            }
            
            // Reset search display state on switching tab
            document.querySelectorAll('.searchable-row').forEach(card => card.style.display = "flex");
        }

        // --- 3. FITUR SWITCH DARK MODE ---
        const toggleSwitch = document.querySelector('.theme-switch input');
        const currentTheme = localStorage.getItem('theme');

        if (currentTheme) {
            document.documentElement.setAttribute('data-theme', currentTheme);
            if (currentTheme === 'dark') {
                toggleSwitch.checked = true;
            }
        }

        toggleSwitch.addEventListener('change', function(e) {
            if (e.target.checked) {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
            }    
        });

        // --- 4. FITUR KONTROL POP-UP PROFILE MODAL ---
        const modal = document.getElementById('profileModal');

        function openProfileModal() {
            modal.classList.add('open');
        }

        function closeProfileModal() {
            modal.classList.remove('open');
        }

        function closeProfileModalOutside(event) {
            if (event.target === modal) {
                closeProfileModal();
            }
        }
    </script>
</body>
</html>