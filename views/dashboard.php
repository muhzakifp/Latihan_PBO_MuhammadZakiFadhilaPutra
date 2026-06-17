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
            --bg-body: #f4f6f9;
            --bg-sidebar: #2c3e50;
            --bg-card: #ffffff;
            --text-main: #333333;
            --text-muted: #7f8c8d;
            --border-color: #edf2f7;
            --shadow: rgba(0,0,0,0.05);
            --sidebar-active: #34495e;
            --hover-row: #f8fafc;
            --bg-profile: #1f2d3d;
            --modal-overlay: rgba(0, 0, 0, 0.5);
        }

        [data-theme="dark"] {
            --bg-body: #1a1a24;
            --bg-sidebar: #111116;
            --bg-card: #22222e;
            --text-main: #e2e8f0;
            --text-muted: #a0aec0;
            --border-color: #2d3748;
            --shadow: rgba(0,0,0,0.3);
            --sidebar-active: #1e1e2f;
            --hover-row: #2a2a3d;
            --bg-profile: #1a1a24;
            --modal-overlay: rgba(0, 0, 0, 0.75);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; transition: background 0.2s, color 0.2s; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--bg-body); color: var(--text-main); display: flex; min-height: 100vh; }

        /* Sidebar Styling */
        .sidebar { width: 260px; background-color: var(--bg-sidebar); color: #fff; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 10; justify-content: space-between; }
        .sidebar-top { display: flex; flex-direction: column; width: 100%; }
        .sidebar-brand { padding: 25px 20px; font-size: 20px; font-weight: bold; border-bottom: 1px solid rgba(255,255,255,0.1); letter-spacing: 1px; display: flex; align-items: center; gap: 10px; }
        .sidebar-menu { list-style: none; padding: 20px 0; }
        .sidebar-menu li a { display: block; padding: 15px 20px; color: #cbd5e1; text-decoration: none; font-size: 15px; border-left: 4px solid transparent; cursor: pointer; }
        .sidebar-menu li a:hover, .sidebar-menu li.active a { background-color: var(--sidebar-active); color: #fff; border-left-color: #3498db; }

        /* MENU PROFILE DI SIDEBAR (Bisa Diklik) */
        .sidebar-profile { display: flex; align-items: center; gap: 12px; padding: 15px 20px; background-color: var(--bg-profile); border-top: 1px solid rgba(255,255,255,0.08); width: 100%; cursor: pointer; transition: background 0.2s; }
        .sidebar-profile:hover { background-color: var(--sidebar-active); }
        .profile-avatar { width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #3498db; background-color: #7f8c8d; }
        .profile-info { display: flex; flex-direction: column; overflow: hidden; }
        .profile-name { font-size: 14px; font-weight: 600; color: #ffffff; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; }
        .profile-role { font-size: 11px; color: #94a3b8; }

        /* Main Content Styling */
        .main-content { margin-left: 260px; flex: 1; padding: 40px; }
        
        /* Top Navbar Layout */
        .top-navbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .search-container input { padding: 12px 20px; width: 350px; border: 1px solid var(--border-color); border-radius: 25px; background: var(--bg-card); color: var(--text-main); outline: none; box-shadow: 0 2px 4px var(--shadow); font-size: 14px; }
        
        /* Dark Mode Toggle Switch */
        .theme-switch-wrapper { display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--text-muted); }
        .theme-switch { display: inline-block; height: 24px; position: relative; width: 50px; }
        .theme-switch input { display:none; }
        .slider { background-color: #ccc; bottom: 0; cursor: pointer; left: 0; position: absolute; right: 0; top: 0; transition: .4s; border-radius: 34px; }
        .slider:before { background-color: white; bottom: 4px; content: ""; height: 16px; left: 4px; position: absolute; transition: .4s; width: 16px; border-radius: 50%; }
        input:checked + .slider { background-color: #3498db; }
        input:checked + .slider:before { transform: translateX(26px); }

        /* Dashboard Sections / Cards */
        .content-section { background: var(--bg-card); padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px var(--shadow); margin-bottom: 40px; border: 1px solid var(--border-color); transform-origin: top; transition: all 0.3s ease-in-out; }
        
        .section-header { border-left: 5px solid #3498db; padding-left: 12px; font-size: 22px; color: var(--text-main); margin-bottom: 20px; }
        .imax-border { border-left-color: #f1c40f; }
        .velvet-border { border-left-color: #e74c3c; }

        /* Table Design */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 14px 18px; text-align: left; border-bottom: 1px solid var(--border-color); font-size: 14px; }
        th { background-color: var(--border-color); color: var(--text-main); font-weight: 600; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; }
        tr:hover { background-color: var(--hover-row); }
        .harga-total { font-weight: bold; color: #27ae60; font-size: 15px; }
        .no-data { text-align: center; color: var(--text-muted); padding: 30px; }
        
        /* Global Alert Search Result */
        #search-alert { text-align: center; color: #e74c3c; padding: 20px; font-weight: 500; background: var(--bg-card); border-radius: 8px; border: 1px solid var(--border-color); display: none; margin-bottom: 20px; }

        /* STYLING UNTUK POP-UP MODAL PROFILE */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: var(--modal-overlay); display: flex; justify-content: center; align-items: center; z-index: 1000; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
        .modal-overlay.open { opacity: 1; pointer-events: auto; }
        
        .modal-card { background-color: var(--bg-card); padding: 30px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); width: 340px; text-align: center; position: relative; border: 1px solid var(--border-color); transform: scale(0.8); transition: transform 0.3s ease; }
        .modal-overlay.open .modal-card { transform: scale(1); }
        
        .modal-close { position: absolute; top: 15px; right: 20px; font-size: 24px; color: var(--text-muted); cursor: pointer; border: none; background: none; font-weight: bold; }
        .modal-close:hover { color: #e74c3c; }
        
        .modal-avatar { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #3498db; margin-bottom: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .modal-name { font-size: 20px; font-weight: bold; color: var(--text-main); margin-bottom: 5px; }
        .modal-role { font-size: 13px; color: #3498db; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 15px; }
        .modal-bio { font-size: 13px; color: var(--text-muted); line-height: 1.5; border-top: 1px solid var(--border-color); padding-top: 15px; }
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

        <section id="section-regular" class="content-section">
            <h2 class="section-header">🍿 Kategori: Studio Regular</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Tiket</th>
                        <th>Nama Film</th>
                        <th>Jadwal Tayang</th>
                        <th>Jumlah Kursi</th>
                        <th>Harga Dasar</th>
                        <th>Fasilitas Unik </th>
                        <th>Total Bayar </th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php if (empty($dataRegular)): ?>
                        <tr><td colspan="7" class="no-data">Tidak ada data tiket Regular</td></tr>
                    <?php else: ?>
                        <?php foreach ($dataRegular as $tiket): ?>
                            <tr class="searchable-row">
                                <td><?= $tiket->getIdTiket(); ?></td>
                                <td><strong><?= $tiket->getNamaTiket(); ?></strong></td>
                                <td><?= date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</td>
                                <td><?= $tiket->getJumlahKursi(); ?> Kursi</td>
                                <td>Rp <?= number_format($tiket->getHargaDasarTiket(), 0, ',', '.'); ?></td>
                                <td><em><?= $tiket->tampilkanInfoFasilitas(); ?></em></td>
                                <td class="harga-total">Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <section id="section-imax" class="content-section">
            <h2 class="section-header imax-border">🕶️ Kategori: Studio IMAX</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Tiket</th>
                        <th>Nama Film</th>
                        <th>Jadwal Tayang</th>
                        <th>Jumlah Kursi</th>
                        <th>Harga Dasar</th>
                        <th>Fasilitas Unik </th>
                        <th>Total Bayar </th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php if (empty($dataIMAX)): ?>
                        <tr><td colspan="7" class="no-data">Tidak ada data tiket IMAX</td></tr>
                    <?php else: ?>
                        <?php foreach ($dataIMAX as $tiket): ?>
                            <tr class="searchable-row">
                                <td><?= $tiket->getIdTiket(); ?></td>
                                <td><strong><?= $tiket->getNamaTiket(); ?></strong></td>
                                <td><?= date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</td>
                                <td><?= $tiket->getJumlahKursi(); ?> Kursi</td>
                                <td>Rp <?= number_format($tiket->getHargaDasarTiket(), 0, ',', '.'); ?></td>
                                <td><em><?= $tiket->tampilkanInfoFasilitas(); ?></em></td>
                                <td class="harga-total">Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <section id="section-velvet" class="content-section">
            <h2 class="section-header velvet-border">🛏️ Kategori: Studio Velvet</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Tiket</th>
                        <th>Nama Film</th>
                        <th>Jadwal Tayang</th>
                        <th>Jumlah Kursi</th>
                        <th>Harga Dasar</th>
                        <th>Fasilitas Unik </th>
                        <th>Total Bayar </th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php if (empty($dataVelvet)): ?>
                        <tr><td colspan="7" class="no-data">Tidak ada data tiket Velvet</td></tr>
                    <?php else: ?>
                        <?php foreach ($dataVelvet as $tiket): ?>
                            <tr class="searchable-row">
                                <td><?= $tiket->getIdTiket(); ?></td>
                                <td><strong><?= $tiket->getNamaTiket(); ?></strong></td>
                                <td><?= date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</td>
                                <td><?= $tiket->getJumlahKursi(); ?> Kursi</td>
                                <td>Rp <?= number_format($tiket->getHargaDasarTiket(), 0, ',', '.'); ?></td>
                                <td><em><?= $tiket->tampilkanInfoFasilitas(); ?></em></td>
                                <td class="harga-total">Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
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
                let rows = section.querySelectorAll('.searchable-row');
                let matchCount = 0;

                rows.forEach(row => {
                    let text = row.textContent.toLowerCase();
                    if (text.includes(input)) {
                        row.style.display = ""; 
                        matchCount++;
                    } else {
                        row.style.display = "none"; 
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

        // Menutup modal jika pengguna mengeklik area blur di luar kotak pop-up
        function closeProfileModalOutside(event) {
            if (event.target === modal) {
                closeProfileModal();
            }
        }
    </script>
</body>
</html>