<?php 
// ========== DATA (ganti sesuai kebutuhan) ==========
$site = [
  'name' => 'Nagari Ophir',
  'tagline' => 'Maju, Mandiri, Berbudaya',
  'desc' => "Selamat datang di laman resmi Nagari Ophir. Informasi singkat tentang nagari, potensi, pelayanan, dan kegiatan terkini.",
  'province' => 'Sumatera Barat',
  'address' => '— (Jln Mayor Said Zamzam RT.03 Ophir Barat)',
  'phone' => '085264280383',
  'email' => 'ophirnagari79@gmail.com',
  'lat' => -0.20379,
  'lng' => 99.821373,
  'hero_img' => 'assets/ophir.PNG',   // ⬅️ ganti ke foto kantor
  'logo'     => 'assets/logo.PNG'     // ⬅️ ganti ke logo pasbar
];

$stats = [
  ['label' => 'kepala keluarga', 'value' => 1349],
  ['label' => 'Jorong',   'value' => 3],
];

$potensi = [
  ['title'=>'Perkebunan','desc'=>'Kelapa sawit'],
  ['title'=>'Kesenian','desc'=>'Tari Tortor, Kuda Kepang, Wayang.'],
  ['title'=>'UMKM','desc'=>'Kuliner, kerajinan, jasa.'],
];

// ====== PERANGKAT NAGARI ======
// TAMPIL di beranda:
$officials_home = [
  ['name'=>'Edi Hartono, S.Sos.I','pos'=>'Wali Nagari','photo'=>'assets/wali.jpeg'],
  ['name'=>'Fadhlil Mustafa, SH.MH','pos'=>'Sekretaris Nagari','photo'=>'assets/sekretaris.png'],
  ['name'=>'Ika Riwanti','pos'=>'Kasi Pemerintahan','photo'=>'assets/kasih_pemerintahan.png'],
  ['name'=>'Mayka Rahman, S.Sos','pos'=>'Kasi Pelayanan & Kesejahteraan','photo'=>'assets/Kasih_kesejahteraan_pelayanan.png'],
];

// HANYA tampil di modal (tambah/kurangi sesukanya):
$officials_more = [
  ['name'=>'Yuliani, S.Pd','pos'=>'Kaur Umum','photo'=>'assets/kaur_umum.png'],
  ['name'=>'Dini Prihastiwi, S.Pd','pos'=>'Kaur Keuangan','photo'=>'assets/kaur_keuangan.png'],
  ['name'=>'Chelsy Yulinda Op Zainita','pos'=>'Operator IT','photo'=>'assets/operator_it.jpeg'],
  ['name'=>'Erivandi Yudha Pratama, S.Tr.T','pos'=>'Operator Siskeudes','photo'=>'assets/operator_siskeudes.png'],
  ['name'=>'Yossy Herlida, SE','pos'=>'Operator Sipades','photo'=>'assets/oprator_sipades.png'],
  ['name'=>'Aprillia Susanti','pos'=>'Satff','photo'=>'assets/staff.png'],
  ['name'=>'Nafisah Nursapni, SE','pos'=>'Satff','photo'=>'assets/s.png'],
];
$officials_modal = array_merge($officials_home, $officials_more);

// ====== Struktur Organisasi (3 jenis) ======
function _find_struct($base){
  foreach(['png','jpg','jpeg','webp'] as $ext){
    $p = "assets/{$base}.{$ext}";
    if(file_exists($p)) return $p;
  }
  return '';
}
$struktur_lpmn   = _find_struct('struktur_lpmn');
$struktur_karang = _find_struct('struktur_karang_taruna');
$struktur_pkk    = _find_struct('struktur_pkk');

// Tangani upload struktur (simpel)
$uploadMsg = '';
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['upload_struktur'])){
  $jenis = $_POST['jenis'] ?? '';
  $map = [
    'lpmn'   => 'struktur_lpmn',
    'karang' => 'struktur_karang_taruna',
    'pkk'    => 'struktur_pkk'
  ];
  if(isset($map[$jenis]) && isset($_FILES[$map[$jenis]]) && $_FILES[$map[$jenis]]['error']===UPLOAD_ERR_OK){
    $ext = strtolower(pathinfo($_FILES[$map[$jenis]]['name'], PATHINFO_EXTENSION));
    if(in_array($ext,['png','jpg','jpeg','webp'])){
      $ext = $ext==='jpeg' ? 'jpg' : $ext;
      $dest = "assets/{$map[$jenis]}.{$ext}";
      if(move_uploaded_file($_FILES[$map[$jenis]]['tmp_name'],$dest)){
        if($jenis==='lpmn')   $struktur_lpmn   = $dest;
        if($jenis==='karang') $struktur_karang = $dest;
        if($jenis==='pkk')    $struktur_pkk    = $dest;
        $uploadMsg = 'Berhasil mengunggah struktur.';
      } else {
        $uploadMsg = 'Gagal menyimpan berkas. Periksa izin folder assets/.';
      }
    } else $uploadMsg = 'Format gambar tidak didukung.';
  } else $uploadMsg = 'Tidak ada berkas yang diunggah.';
}

/* ====== DATA BAGAN (berdasarkan dokumen yang dikirim) ====== */
// LPMN
$lpmn_org = [
  'ketua'      => 'AJAR MAHARGIYONO',
  'sekretaris' => 'EPI ANTONI',
  'bendahara'  => 'ALI SYAHBANI',
  'bidang' => [
    ['label'=>'Bidang Keagamaan & Kesejahteraan Rakyat',            'nama'=>'JAMAL, SE'],
    ['label'=>'Bidang Pendidikan, Informasi & Komunikasi Masyarakat','nama'=>'RICKI RISWANDI'],
    ['label'=>'Bidang Kesehatan',                                    'nama'=>'ERLIZA'],
    ['label'=>'Bidang Lingkungan Hidup',                              'nama'=>'RHYANDIKA ALDI'],
    ['label'=>'Bidang Ekonomi & Pembangunan',                         'nama'=>'MUSTAJAB'],
    ['label'=>'Bidang Pemuda Olahraga',                               'nama'=>'MUHAMMAD ARIF'],
    ['label'=>'Bidang Pertanian & Peternakan',                        'nama'=>'DIDIK SLAMET'],
    ['label'=>'Bidang Kesenian & Budaya',                             'nama'=>'ALBERTUS JUNAIDI'],
  ]
];

// Karang Taruna
$karang_org = [
  'pembina'    => 'Penjabat Wali Nagari Ophir',
  'ketua'      => 'WISNU ADRIANTA UTAMA',
  'wakil'      => ['MARIO SANJAYA SE','FAJRI PAMUNGKAS'],
  'sekretaris' => 'YULIANA OPRIYANTI SILALAHI, S.S',
  'bendahara'  => 'DESI SUSANTI S.Kep',
  'bidang' => [
    ['title'=>'Humas & Kemitraan','koor'=>'RICKI RISWANDI',
      'anggota'=>['HEROZA FERDAUS S,Ak','TRI GALUH PRABOWO','RAHMAD DARMAWAN','SUSANTI','HENDRO','IBNU SAPUTRA']],
    ['title'=>'Olahraga','koor'=>'RHYANDIKA ALDI',
      'anggota'=>['AGUNG ADITYA PRATAMA, SM','MEI DAMANTO','ANDRE SAPUTRA','BENO REINALDI','PURNAMA IRAWAN','TUGAS MURDIANTOP','AHMAD KUKUH ABIANTO']],
    ['title'=>'Lingkungan Hidup','koor'=>'YOSEF MARIOL',
      'anggota'=>['GUSTIAR RAHMAD','ALOYSIUS A PERKASA','PIPO ANUARY','OVA DANIEL SINURAT','ROY SINAGA','DORY OKTOALDI','FAJAR SETIAWAN','YOGA BIMANTARA']],
    ['title'=>'Kerohanian & Pembinaan Mental','koor'=>'M. JAMAL',
      'anggota'=>['PARWONO','YANA SINTRA A.Md','CESTY DEBORA SILALAHI S.Pd','EDISON FIDELIS SIDABARIBA']],
    ['title'=>'Kesenian & Kebudayaan','koor'=>'SURYADI',
      'anggota'=>['BIMA PRASETIYA','KURNIANTIKA','ONY OKTARIA','TIUR SINABUTAR','WULANDARI']],
  ]
];

// PKK
$pkk_org = [
  'pembina'     => 'Pj. Wali Nagari Ophir',
  'ketua'       => 'Ny. NOFRIDESWITA HARTONO',
  'wakil_ketua' => 'ZUHELMI',
  'sekretaris'  => ['YOSI HERLIDA','YULIA FAHRIANTI'], // I & II
  'bendahara'   => ['YULIANI','LINA HASANAH'],         // I & II
  'pokja' => [
    ['title'=>'Pokja I','ketua'=>'LUSI HARYANTI','wakil'=>'SAMSIATIN','sekretaris'=>'ISLAMIYAH',
      'anggota'=>['ELI SUARSIH','NURWAHDA','ARIFAH','HANI NURHAYATI','AZWARLINI']],
    ['title'=>'Pokja II','ketua'=>'DERLIANA','wakil'=>'VIVIEN','sekretaris'=>'MISDARWATI',
      'anggota'=>['PARTINI','IKA RIWANTI','EVA NURHAYATI','ZUHELMI','VIVIEN','ENDANG ESTAWRINA']],
    ['title'=>'Pokja III','ketua'=>'HANDAYANI','wakil'=>'SUMINI','sekretaris'=>'ELIAWATI',
      'anggota'=>['INDAH SARI','DINI PRIHASTIWI','IRA ELFI SUSANTI','SITI HANDAYANI','MARLINA','ERLIZA']],
    ['title'=>'Pokja IV','ketua'=>'YULIANA','wakil'=>'MAIZA','sekretaris'=>['RATNA DWI CAHYANI','ONY OKTARIA'],
      'anggota'=>['IKA SRIWAHYUNI','KUSWATI NINGSIH','AFRILIA HARTIKA','ANA MUTAFANI','DEWI GUSNIANTI','MUSTIKA SARI','RATNA DWI CAHYANI']],
  ]
];

// ====== Administrasi Penduduk ======
$adm = [
  'penduduk' => 4405,
  'kk'       => 1349,
  'laki'     => 2167,
  'perempuan'=> 2238
];

// ====== O P H I R ======
$ophir = [
  ['letter'=>'O','title'=>'Optimis','desc'=>'(penjelasan singkat huruf O)'],
  ['letter'=>'P','title'=>'Penuh Tanggung Jawab','desc'=>'(penjelasan singkat huruf P)'],
  ['letter'=>'H','title'=>'Handal','desc'=>'(penjelasan singkat huruf H)'],
  ['letter'=>'I','title'=>'Integritas','desc'=>'(penjelasan singkat huruf I)'],
  ['letter'=>'R','title'=>'Ramah Dalam Melayani','desc'=>'(penjelasan singkat huruf R)'],
];

// ====== Sejarah & Fasilitas ======
$sejarah = [
  'Nagari Ophir merupakan salah satu nagari di Kecamatan Luhak Nan Duo, Kabupaten Pasaman Barat, Sumatera Barat. Wilayah ini tumbuh dari pemukiman- pemukiman lama yang kemudian berkembang menjadi jorong-jorong dengan aktivitas ekonomi pertanian dan perdagangan lokal.',
  'Dalam perjalanan administrasi, Nagari Ophir mengikuti dinamika pemerintahan nagari di Sumatera Barat serta program pembangunan daerah Kabupaten Pasaman Barat. Semangat gotong royong, musyawarah mufakat, dan nilai-nilai adat menjadi landasan dalam mengelola potensi sumber daya manusia maupun alam.',
  'Kini Nagari Ophir terus berbenah melalui pelayanan publik, penguatan kelembagaan masyarakat, dan pemberdayaan ekonomi agar menjadi nagari yang maju, mandiri, dan berbudaya.'
];

$fasilitas = [
  'ibadah' => ['Masjid'=>4,'Mushola'=>6,'Gereja'=>2],
  'pendidikan' => ['TK/PAUD'=>3,'SD'=>3,'SMP'=>1, 'SMA'=>1,'Perguruan Tinggi'=>1],
  'kesehatan' => ['Puskesmas'=>1,'Polindes'=>2,'Pos KB'=>2],
];

// ====== Galeri ======
$gallery = [
  'assets/11.jpeg','assets/Lomba.jpeg','assets/4.jpg',
  'assets/5.jpg','assets/3.jpeg','assets/1.jpeg'
];

// ====== Berita (diisi sesuai permintaan) ======
$news = [
  [
    'title'=>'Dirgahayu Republik Indonesia ke-80',
    'date'=>'2025-08-17',
    'excerpt'=>'Peringatan HUT RI ke-80 di Nagari Ophir berlangsung khidmat dengan upacara bendera dan aneka lomba rakyat.',
    'cover'=>'assets/upacara.jpeg'
  ],
  [
    'title'=>'Musyawarah Penggalian Gagasan Nagari Ophir 2025 untuk Anggaran 2026',
    'date'=>'2025-08-13',
    'excerpt'=>'Masyarakat menyampaikan usulan prioritas pembangunan untuk dimasukkan ke perencanaan tahun 2026.',
    'cover'=>'assets/rapat.jpeg'
  ],
 [
    'title'=>'Kegiatan Pelatihan Pengelolaan Lidi Sawit Nagari Ophir',
    'date'=>'2025-08-08',
    'excerpt'=>'Pelatihan peningkatan keterampilan pengelolaan lidi sawit untuk mendorong UMKM lokal.',
    'cover'=>'assets/lidi.jpeg'
  ],

  [
    'title'=>'Penyambutan Mahasiswa KKN ITS Khatulistiwa dan Universitas Bung Hatta',
    'date'=>'2025-08-01',
    'excerpt'=>'Pemerintah nagari menyambut mahasiswa KKN yang akan mengabdi di Nagari Ophir.',
    'cover'=>'assets/kknn.jpeg'
  ],
];

function e(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($site['name']) ?> — Profil Nagari</title>

  <!-- Bootstrap + Icons + AOS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Tailwind (tanpa preflight agar tidak bentrok Bootstrap) -->
  <script>
    window.tailwind = window.tailwind || {};
    window.tailwind.config = {
      corePlugins:{ preflight:false },
      theme:{ extend:{
        fontFamily:{ sans:["Inter","ui-sans-serif","system-ui"] },
        colors:{ primary:{600:"#dc2626"}} // merah brand
      }}
    }
  </script>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Leaflet + Chart.js -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

  <!-- THEME: MERAH – KRIM/ warna baiground --> 
  <style>
    :root{
      --brand:#dc2626; --brand-2:#f87171;
      --bg-1:#faebd7;  --bg-2:#b91c1c;
      --card:#7f1d1d;  --glass:rgba(255,255,255,.08);
      --text:#ffffff;  --muted:#ffe4e6;
      --border:rgba(255,255,255,.25);
    }
    *{scroll-behavior:smooth}
    html,body{color-scheme: dark;}
    body{
      font-family:Inter,system-ui,Segoe UI,Roboto,Arial,sans-serif;
      background:linear-gradient(180deg,var(--bg-1),var(--bg-2)) fixed;
      color:var(--text)
    }
    .navbar{backdrop-filter:saturate(180%) blur(14px); background:rgba(128,0,0,.8)!important}
    .navbar .nav-link{color:#ffffff!important}
    .navbar .nav-link:hover{color:#ffe4e6!important}
    .navbar .navbar-toggler{border-color:#ffffffb3}
    .navbar .navbar-toggler-icon{filter:invert(1) brightness(2)}
    .btn-brand{background:var(--brand);border:0;color:#fff}
    .btn-brand:hover{filter:brightness(1.05)}
    .btn-outline-light{border-color:#ffffffcc;color:#fff}
    .btn-outline-light:hover{background:#ffffff1a}
    .hero{
      position:relative; isolation:isolate; min-height:82vh; display:grid; place-items:center;
      background:
        radial-gradient(1200px 600px at 80% -10%, rgba(248,113,113,.28), transparent),
        radial-gradient(900px 600px at -10% 10%, rgba(239,68,68,.20), transparent)
    }
    .hero-bg{position:absolute; inset:0; z-index:-1; overflow:hidden}
    .hero-bg img{position:absolute; right:-6rem; bottom:-3rem; width:min(48vw,720px); opacity:.18; filter:grayscale(100%) contrast(1.1); animation:float 12s ease-in-out infinite}
    @keyframes float{0%,100%{transform:translate(0,0)}50%{transform:translate(0,-18px)}}
    .glass{background:var(--glass); border:1px solid var(--border); box-shadow:0 10px 30px rgba(0,0,0,.35); border-radius:16px}
    .badge-soft{background:rgba(239,68,68,.35); color:#fff; border:1px solid rgba(255,255,255,.35)}
    .card{background:var(--card); border:1px solid var(--border); color:var(--text)}
    .card:hover{transform:translateY(-4px); transition:.25s ease}
    .icon-wrap{width:48px;height:48px;display:grid;place-items:center;border-radius:12px;background:rgba(255,255,255,.12);color:#fff}
    .section{padding:80px 0}
    .gallery img{object-fit:cover; height:220px; border-radius:12px}
    footer{background:#3b0d0d}
    #loader{position:fixed;inset:0;display:grid;place-items:center;background:#3b0d0d;z-index:9999;transition:opacity .4s}
    #loader.hidden{opacity:0;pointer-events:none}
    .dot{width:12px;height:12px;border-radius:50%;background:var(--brand);margin:0 4px;display:inline-block;animation:bounce 1s infinite}
    .dot:nth-child(2){animation-delay:.15s}.dot:nth-child(3){animation-delay:.3s}
    @keyframes bounce{0%,80%,100%{transform:scale(0)}40%{transform:scale(1)}}
    .stat{font-weight:800;font-size:clamp(28px,5vw,44px)}
    dialog::backdrop{background:rgba(0,0,0,.65)}
    .map-container{height:360px}
    .text-muted{color:var(--muted)!important;opacity:1!important}
    small, .small, label{color:var(--muted)!important}
    .form-control, .form-select, textarea{background:#3b0d0d; color:#ffffff; border-color:var(--border);}
    .form-control:focus, .form-select:focus, textarea:focus{
      color:#ffffff; background:#4a1414; border-color:#f87171; 
      box-shadow:0 0 0 .2rem rgba(239,68,68,.25);
    }
    ::placeholder{color:#fff0f0!important;opacity:.9}
    .table-dark{
      --bs-table-color:#fff;
      --bs-table-striped-bg: rgba(255,255,255,.08);
      --bs-table-striped-color:#fff;
      --bs-table-hover-bg: rgba(255,255,255,.12);
      --bs-table-hover-color:#fff;
      border-color:var(--border);
    }
    a, .link-light{color:#ffffff!important}
    a:hover{color:#ffe4e6!important}
    .leaflet-popup-content-wrapper, .leaflet-popup-tip{background:#3b0d0d;color:#fff;border:1px solid var(--border)}
    .leaflet-control-attribution{color:#ffe4e6}
  </style>
</head>
<body>

<!-- Preloader -->
<div id="loader"><div><span class="dot"></span><span class="dot"></span><span class="dot"></span></div></div>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
      <?php if (!empty($site['logo'])): ?>
        <img src="<?= e($site['logo']) ?>" alt="Logo" style="height:28px">
      <?php endif; ?>
      <span><?= e($site['name']) ?></span>
    </a>
    <button class="navbar-toggler text-light" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#profil">Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="#sejarah">Sejarah</a></li>
        <li class="nav-item"><a class="nav-link" href="#peta">Peta</a></li>
        <li class="nav-item"><a class="nav-link" href="#perangkat">Perangkat</a></li>
        <li class="nav-item"><a class="nav-link" href="#fasilitas">Fasilitas</a></li>
        <li class="nav-item"><a class="nav-link" href="#adm-penduduk">Administrasi Penduduk</a></li>
        <li class="nav-item"><a class="nav-link" href="#potensi">Potensi</a></li>
        <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="#galeri">Galeri</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
        <li class="nav-item"><a class="nav-link" href="layanan.php">Layanan</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- MARQUEE -->
<marquee behavior="scroll" direction="left" scrollamount="6" style="background:#DC143C; color:white; padding:10px; font-weight:bold;">
  Selamat Datang di Website Profil Nagari Ophir - Kecamatan Luhak Nan Duo, Kabupaten Pasaman Barat - Pelayanan dimulai pukul 08.00 s/d 12.00 wib dan dimulai kembali pukul 14.00 wib s/d 16.00 wib.
</marquee>

<!-- HERO -->
<header class="hero container">
  <div class="row align-items-center w-100">
    <div class="col-lg-7" data-aos="fade-right">
      <span class="badge badge-soft mb-3"><i class="bi bi-stars me-1"></i> Profil Resmi</span>
      <h1 class="display-5 fw-800 mb-3"><?= e($site['name']) ?></h1>
      <p class="lead" style="color:#ffe4e6!important"><?= e($site['tagline']) ?></p>
      <p class="text-muted mb-4"><?= e($site['desc']) ?></p>
      <div class="d-flex gap-2">
        <a href="#profil" class="btn btn-brand btn-lg"><i class="bi bi-compass me-1"></i> Jelajahi</a>
        <a href="#kontak" class="btn btn-outline-light btn-lg"><i class="bi bi-telephone me-1"></i> Kontak</a>
      </div>
      <div class="d-flex gap-4 mt-4">
        <?php foreach ($stats as $s): ?>
          <div class="text-center">
            <div class="stat counter" data-target="<?= (int)$s['value'] ?>">0</div>
            <div class="text-muted small"><?= e($s['label']) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="col-lg-5 d-none d-lg-block" data-aos="zoom-in">
      <div class="glass p-2">
        <img src="<?= e($site['hero_img']) ?>" class="w-100 rounded-3" alt="Nagari Ophir">
      </div>
    </div>
  </div>
  <div class="hero-bg">
    <img src="<?= e($site['hero_img']) ?>" alt="">
  </div>
</header>

<main>
  <!-- PROFIL -->
  <section id="profil" class="section">
    <div class="container">
      <div class="row g-4 align-items-center">
        <div class="col-lg-6" data-aos="fade-up">
          <div class="card p-4">
            <h2 class="h3 mb-3">Profil Nagari</h2>
            <p><?= e($site['name']) ?> berada di Provinsi <?= e($site['province']) ?>. Halaman ini memuat informasi nagari, pelayanan publik, kegiatan masyarakat, dan potensi daerah.</p>
          </div>
        </div>

        <!-- O-P-H-I-R -->
        <div class="col-lg-6" data-aos="fade-left">
          <div class="vstack gap-3">
            <?php foreach ($ophir as $i => $item): ?>
              <div class="card p-4 d-flex flex-row align-items-start gap-3" data-aos="fade-up" data-aos-delay="<?= $i*90 ?>">
                <div class="icon-wrap flex-shrink-0">
                  <span class="fw-bold fs-4"><?= e($item['letter']) ?></span>
                </div>
                <div>
                  <div class="fw-semibold mb-1"><?= e($item['title']) ?></div>
                  <?php if (!empty($item['desc'])): ?>
                    <div class="small text-muted"><?= e($item['desc']) ?></div>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <!-- /O-P-H-I-R -->

      </div>
    </div>
  </section>

  <!-- SEJARAH -->
  <section id="sejarah" class="section pt-0">
    <div class="container">
      <h2 class="h3 mb-3">Sejarah Nagari Ophir</h2>
      <div class="card p-4">
        <?php foreach($sejarah as $p): ?>
          <p class="mb-2"><?= e($p) ?></p>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- PETA NAGARI OPHIR -->
  <section id="peta" class="section pt-0">
    <div class="container">
      <h2 class="h3 mb-3">Peta Nagari Ophir</h2>
      <div class="card p-0 overflow-hidden">
        <div id="map_ophir" class="map-container" style="height:420px"></div>
        <div class="p-2 small text-muted">* Batas wilayah dapat dimuat dari berkas <code>assets/ophir.geojson</code>.</div>
      </div>
    </div>
  </section>

  <!-- PERANGKAT -->
  <section id="perangkat" class="section">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h3 mb-0">Perangkat Nagari</h2>
        <button class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalPerangkat">
          <i class="bi bi-diagram-3 me-1"></i> Lihat Perangkat Lengkap & Struktur
        </button>
      </div>
      <div class="row g-3">
        <?php foreach ($officials_home as $i => $o): ?>
          <div class="col-6 col-md-3" data-aos="zoom-in" data-aos-delay="<?= $i*100 ?>">
            <div class="card h-100">
              <?php if (!empty($o['photo'])): ?>
                <img src="<?= e($o['photo']) ?>" 
                     onerror="this.onerror=null;this.src='assets/placeholder-person.jpg';"
                     class="card-img-top" style="height:220px;object-fit:cover" alt="<?= e($o['name']) ?>">
              <?php endif; ?>
              <div class="card-body">
                <div class="fw-semibold"><?= e($o['name']) ?></div>
                <div class="small text-muted"><?= e($o['pos']) ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- FASILITAS -->
  <section id="fasilitas" class="section pt-0">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h3 mb-0">Fasilitas Umum Nagari</h2>
        <span class="text-muted small">Ibadah • Pendidikan • Kesehatan</span>
      </div>

      <div class="row g-3">
        <!-- Ibadah -->
        <div class="col-md-4" data-aos="fade-up">
          <div class="card p-4 h-100">
            <div class="icon-wrap mb-2"><i class="bi bi-buildings fs-4"></i></div>
            <div class="fw-semibold mb-1">Fasilitas Tempat Ibadah</div>
            <ul class="mb-0 small">
              <?php foreach($fasilitas['ibadah'] as $k=>$v): ?>
                <li><?= e($k) ?>: <b><?= (int)$v ?></b></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <!-- Pendidikan -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="80">
          <div class="card p-4 h-100">
            <div class="icon-wrap mb-2"><i class="bi bi-mortarboard fs-4"></i></div>
            <div class="fw-semibold mb-1">Fasilitas Pendidikan</div>
            <ul class="mb-0 small">
              <?php foreach($fasilitas['pendidikan'] as $k=>$v): ?>
                <li><?= e($k) ?>: <b><?= (int)$v ?></b></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <!-- Kesehatan -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="160">
          <div class="card p-4 h-100">
            <div class="icon-wrap mb-2"><i class="bi bi-heart-pulse fs-4"></i></div>
            <div class="fw-semibold mb-1">Fasilitas Kesehatan</div>
            <ul class="mb-0 small">
              <?php foreach($fasilitas['kesehatan'] as $k=>$v): ?>
                <li><?= e($k) ?>: <b><?= (int)$v ?></b></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ADMINISTRASI PENDUDUK -->
  <section id="adm-penduduk" class="section pt-0">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="h3 mb-0">Administrasi Penduduk</h2>
        <span class="text-muted small">Ringkasan data kependudukan</span>
      </div>
      <div class="row g-3">
        <div class="col-6 col-md-3"><div class="glass p-3 rounded h-100"><div class="stat"><?= number_format($adm['penduduk']) ?></div><div class="small text-muted">Jumlah Penduduk</div></div></div>
        <div class="col-6 col-md-3"><div class="glass p-3 rounded h-100"><div class="stat"><?= number_format($adm['kk']) ?></div><div class="small text-muted">Jumlah KK</div></div></div>
        <div class="col-6 col-md-3"><div class="glass p-3 rounded h-100"><div class="stat"><?= number_format($adm['laki']) ?></div><div class="small text-muted">Laki-laki</div></div></div>
        <div class="col-6 col-md-3"><div class="glass p-3 rounded h-100"><div class="stat"><?= number_format($adm['perempuan']) ?></div><div class="small text-muted">Perempuan</div></div></div>
      </div>
      <div class="card p-4 mt-3">
        <p class="mb-0">Data di atas menggambarkan kondisi kependudukan terbaru di <?= e($site['name']) ?>, meliputi total penduduk, jumlah kepala keluarga (KK), serta komposisi penduduk laki-laki dan perempuan. Angka dapat diperbarui sewaktu-waktu sesuai hasil pemutakhiran administrasi.</p>
      </div>
    </div>
  </section>

  <!-- POTENSI -->
  <section id="potensi" class="section">
    <div class="container">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h3 mb-0">Potensi Nagari</h2>
        <span class="text-muted small">Ekonomi • Sosial • Budaya</span>
      </div>
      <div class="row g-3">
        <?php foreach ($potensi as $i => $p): ?>
          <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $i*100 ?>">
            <div class="card p-4 h-100">
              <div class="icon-wrap mb-2"><i class="bi bi-pin-map fs-4"></i></div>
              <div class="fw-semibold mb-1"><?= e($p['title']) ?></div>
              <div class="small text-muted"><?= e($p['desc']) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- BERITA -->
  <section id="berita" class="section">
    <div class="container">
      <div class="d-flex align-items-end justify-content-between mb-3">
        <h2 class="h3 mb-0">Berita</h2>
        <a href="#" class="small text-decoration-none">Lihat Arsip →</a>
      </div>
      <?php if (!$news): ?>
        <div class="text-muted">Belum ada berita.</div>
      <?php else: ?>
        <div class="row g-3">
          <?php foreach ($news as $n): ?>
            <div class="col-md-6 col-lg-4" data-aos="fade-up">
              <article class="card h-100">
                <?php if (!empty($n['cover'])): ?>
                  <img src="<?= e($n['cover']) ?>" class="card-img-top" style="height:180px;object-fit:cover" alt="<?= e($n['title']) ?>">
                <?php endif; ?>
                <div class="card-body">
                  <div class="small text-muted mb-1"><i class="bi bi-calendar-event me-1"></i><?= isset($n['date']) ? date('d M Y', strtotime($n['date'])) : '' ?></div>
                  <h3 class="h6 mb-1"><?= e($n['title'] ?? 'Tanpa Judul') ?></h3>
                  <div class="small text-muted"><?= e($n['excerpt'] ?? '') ?></div>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- GALERI -->
  <section id="galeri" class="section">
    <div class="container">
      <h2 class="h3 mb-4">Galeri</h2>
      <div class="row g-3">
        <?php foreach ($gallery as $i => $g): ?>
          <div class="col-6 col-md-4" data-aos="flip-left" data-aos-delay="<?= $i*60 ?>">
            <button type="button" class="w-100 p-0 border-0 bg-transparent" onclick="openLightbox('<?= e($g) ?>')">
              <img class="w-100" src="<?= e($g) ?>" alt="Galeri <?= $i+1 ?>">
            </button>
          </div>
        <?php endforeach; ?>
      </div>
      <dialog id="lightbox" class="rounded" style="border:0;background:transparent">
        <img id="lightboxImg" src="" alt="Foto kegiatan" style="max-width:90vw;max-height:80vh;object-fit:contain"/>
      </dialog>
    </div>
  </section>

  <!-- KONTAK -->
  <section id="kontak" class="section">
    <div class="container">
      <div class="row g-4 justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
          <div class="card p-4">
            <h2 class="h3 mb-3">Kontak & Jam Layanan</h2>
            <ul class="list-unstyled mb-3">
              <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>Alamat: <?= e($site['address']) ?></li>
              <li class="mb-2"><i class="bi bi-envelope me-2"></i>Email: <a class="link-light" href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a></li>
              <li class="mb-2"><i class="bi bi-telephone me-2"></i>Telp/WA: <?= e($site['phone']) ?></li>
              <li class="mb-2"><i class="bi bi-clock me-2"></i>Jam Layanan: Senin–Jumat 08.00–16.00 WIB</li>
            </ul>
            <div class="d-flex gap-2">
              <a href="mailto:<?= e($site['email']) ?>" class="btn btn-outline-light"><i class="bi bi-envelope"></i> Email</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- MODAL: Perangkat Lengkap + Struktur -->
<div class="modal fade" id="modalPerangkat" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content" style="background:#7f1d1d;color:#fff;border:1px solid rgba(255,255,255,.2)">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-people me-1"></i> Perangkat Nagari (Lengkap)</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <?php if(!empty($uploadMsg)): ?>
          <div class="alert alert-success py-2"><?= e($uploadMsg) ?></div>
        <?php endif; ?>
        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" role="tablist">
          <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-daftar" type="button" role="tab">Daftar Perangkat</button></li>
          <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-struktur" type="button" role="tab">Struktur Organisasi</button></li>
        </ul>
        <div class="tab-content">
          <!-- Daftar -->
          <div class="tab-pane fade show active" id="tab-daftar" role="tabpanel">
            <div class="row g-3">
              <?php foreach ($officials_modal as $o): ?>
                <div class="col-6 col-md-3">
                  <div class="card h-100">
                    <?php if (!empty($o['photo'])): ?>
                      <img src="<?= e($o['photo']) ?>" 
                           onerror="this.onerror=null;this.src='assets/placeholder-person.jpg';"
                           class="card-img-top" style="height:220px;object-fit:cover" alt="<?= e($o['name']) ?>">
                    <?php endif; ?>
                    <div class="card-body">
                      <div class="fw-semibold"><?= e($o['name']) ?></div>
                      <div class="small text-muted"><?= e($o['pos']) ?></div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Struktur 3 jenis (bagan + opsi upload gambar) -->
          <div class="tab-pane fade" id="tab-struktur" role="tabpanel">

            <!-- Gaya mini untuk bagan -->
            <style>
              .org-wrap{--line:#ffffff40}
              .org-row{display:flex;flex-wrap:wrap;gap:12px;justify-content:center;margin-bottom:18px}
              .org-node{position:relative;background:#5e1313;border:1px solid #ffffff40;border-radius:12px;padding:10px 14px;min-width:220px;text-align:center}
              .org-node .ttl{font-size:.78rem;opacity:.9}
              .org-node .nm{font-weight:700}
              .org-node.big{min-width:280px}
              .org-grid{display:grid;gap:12px;grid-template-columns:repeat(auto-fit,minmax(220px,1fr))}
              .org-card{background:#4a1010;border:1px solid #ffffff33;border-radius:12px;padding:12px}
              .org-card h6{margin:0 0 6px 0}
              .org-card ul{margin:0;padding-left:18px}
            </style>

            <ul class="nav nav-pills mb-3" role="tablist">
              <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#s-lpmn" type="button" role="tab">Struktur LPMN</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#s-karang" type="button" role="tab">Struktur Karang Taruna</button></li>
              <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#s-pkk" type="button" role="tab">Struktur PKK</button></li>
            </ul>

            <div class="tab-content">
              <!-- LPMN -->
              <div class="tab-pane fade show active" id="s-lpmn" role="tabpanel">
                <div class="org-wrap">
                  <div class="org-row">
                    <div class="org-node big"><div class="ttl">Ketua</div><div class="nm"><?= e($lpmn_org['ketua']) ?></div></div>
                  </div>
                  <div class="org-row">
                    <div class="org-node"><div class="ttl">Sekretaris</div><div class="nm"><?= e($lpmn_org['sekretaris']) ?></div></div>
                    <div class="org-node"><div class="ttl">Bendahara</div><div class="nm"><?= e($lpmn_org['bendahara']) ?></div></div>
                  </div>
                  <div class="org-grid mt-3">
                    <?php foreach($lpmn_org['bidang'] as $b): ?>
                      <div class="org-card">
                        <h6 class="mb-1"><?= e($b['label']) ?></h6>
                        <div class="small text-muted">Koordinator</div>
                        <div class="fw-bold"><?= e($b['nama']) ?></div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>

                <!-- (opsional) unggah gambar struktur LPMN -->
                <div class="text-center mt-4">
                  <?php if($struktur_lpmn): ?>
                    <img src="<?= e($struktur_lpmn) ?>" alt="Struktur LPMN" class="img-fluid rounded border" style="max-height:70vh;object-fit:contain">
                  <?php endif; ?>
                  <form method="post" enctype="multipart/form-data" class="d-inline-flex gap-2 mt-2">
                    <input type="hidden" name="upload_struktur" value="1">
                    <input type="hidden" name="jenis" value="lpmn">
                    <input required class="form-control" type="file" name="struktur_lpmn" accept="image/*">
                    <button class="btn btn-brand"><i class="bi bi-upload me-1"></i> Unggah</button>
                  </form>
                </div>
              </div>

              <!-- Karang Taruna -->
              <div class="tab-pane fade" id="s-karang" role="tabpanel">
                <div class="org-wrap">
                  <div class="org-row">
                    <div class="org-node"><div class="ttl">Pembina</div><div class="nm"><?= e($karang_org['pembina']) ?></div></div>
                  </div>
                  <div class="org-row">
                    <div class="org-node big"><div class="ttl">Ketua</div><div class="nm"><?= e($karang_org['ketua']) ?></div></div>
                  </div>
                  <div class="org-row">
                    <div class="org-node"><div class="ttl">Wakil Ketua I</div><div class="nm"><?= e($karang_org['wakil'][0]) ?></div></div>
                    <div class="org-node"><div class="ttl">Wakil Ketua II</div><div class="nm"><?= e($karang_org['wakil'][1]) ?></div></div>
                    <div class="org-node"><div class="ttl">Sekretaris</div><div class="nm"><?= e($karang_org['sekretaris']) ?></div></div>
                    <div class="org-node"><div class="ttl">Bendahara</div><div class="nm"><?= e($karang_org['bendahara']) ?></div></div>
                  </div>
                  <div class="org-grid mt-3">
                    <?php foreach($karang_org['bidang'] as $b): ?>
                      <div class="org-card">
                        <h6 class="mb-1">Bidang <?= e($b['title']) ?></h6>
                        <div class="small text-muted mb-1">Koordinator: <b><?= e($b['koor']) ?></b></div>
                        <?php if(!empty($b['anggota'])): ?>
                          <div class="small text-muted mb-1">Anggota:</div>
                          <ul class="small mb-0">
                            <?php foreach($b['anggota'] as $a): ?><li><?= e($a) ?></li><?php endforeach; ?>
                          </ul>
                        <?php endif; ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>

                <!-- unggah gambar -->
                <div class="text-center mt-4">
                  <?php if($struktur_karang): ?>
                    <img src="<?= e($struktur_karang) ?>" alt="Struktur Karang Taruna" class="img-fluid rounded border" style="max-height:70vh;object-fit:contain">
                  <?php endif; ?>
                  <form method="post" enctype="multipart/form-data" class="d-inline-flex gap-2 mt-2">
                    <input type="hidden" name="upload_struktur" value="1">
                    <input type="hidden" name="jenis" value="karang">
                    <input required class="form-control" type="file" name="struktur_karang_taruna" accept="image/*">
                    <button class="btn btn-brand"><i class="bi bi-upload me-1"></i> Unggah</button>
                  </form>
                </div>
              </div>

              <!-- PKK -->
              <div class="tab-pane fade" id="s-pkk" role="tabpanel">
                <div class="org-wrap">
                  <div class="org-row">
                    <div class="org-node"><div class="ttl">Pembina</div><div class="nm"><?= e($pkk_org['pembina']) ?></div></div>
                  </div>
                  <div class="org-row">
                    <div class="org-node big"><div class="ttl">Ketua</div><div class="nm"><?= e($pkk_org['ketua']) ?></div></div>
                  </div>
                  <div class="org-row">
                    <div class="org-node"><div class="ttl">Wakil Ketua I</div><div class="nm"><?= e($pkk_org['wakil_ketua']) ?></div></div>
                    <div class="org-node"><div class="ttl">Sekretaris I</div><div class="nm"><?= e($pkk_org['sekretaris'][0]) ?></div></div>
                    <div class="org-node"><div class="ttl">Sekretaris II</div><div class="nm"><?= e($pkk_org['sekretaris'][1]) ?></div></div>
                    <div class="org-node"><div class="ttl">Bendahara I</div><div class="nm"><?= e($pkk_org['bendahara'][0]) ?></div></div>
                    <div class="org-node"><div class="ttl">Bendahara II</div><div class="nm"><?= e($pkk_org['bendahara'][1]) ?></div></div>
                  </div>

                  <div class="org-grid mt-3">
                    <?php foreach($pkk_org['pokja'] as $pj): ?>
                      <div class="org-card">
                        <h6 class="mb-1"><?= e($pj['title']) ?></h6>
                        <div class="small mb-1"><span class="text-muted">Ketua:</span> <b><?= e($pj['ketua']) ?></b></div>
                        <div class="small mb-1"><span class="text-muted">Wakil:</span> <?= e($pj['wakil']) ?></div>
                        <div class="small mb-1"><span class="text-muted">Sekretaris:</span>
                          <?php
                            $sek = is_array($pj['sekretaris']) ? implode(', ', $pj['sekretaris']) : $pj['sekretaris'];
                            echo e($sek);
                          ?>
                        </div>
                        <?php if(!empty($pj['anggota'])): ?>
                          <div class="small text-muted mb-1">Anggota:</div>
                          <ul class="small mb-0">
                            <?php foreach($pj['anggota'] as $a): ?><li><?= e($a) ?></li><?php endforeach; ?>
                          </ul>
                        <?php endif; ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>

                <!-- unggah gambar -->
                <div class="text-center mt-4">
                  <?php if($struktur_pkk): ?>
                    <img src="<?= e($struktur_pkk) ?>" alt="Struktur PKK" class="img-fluid rounded border" style="max-height:70vh;object-fit:contain">
                  <?php endif; ?>
                  <form method="post" enctype="multipart/form-data" class="d-inline-flex gap-2 mt-2">
                    <input type="hidden" name="upload_struktur" value="1">
                    <input type="hidden" name="jenis" value="pkk">
                    <input required class="form-control" type="file" name="struktur_pkk" accept="image/*">
                    <button class="btn btn-brand"><i class="bi bi-upload me-1"></i> Unggah</button>
                  </form>
                </div>
              </div>
            </div> <!-- /tab-content (pills) -->
          </div> <!-- /tab-struktur -->
        </div> <!-- /tab-content utama -->
      </div>
      <div class="modal-footer">
        <button class="btn btn-brand" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<footer class="py-4 border-top border-secondary-subtle">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
    <div class="small text-muted">&copy; <span id="year"></span> KKN Nagari Ophir. Semua hak dilindungi.</div>
    <div class="small text-muted">Dikelola oleh Pemerintah <?= e($site['name']) ?>.</div>
  </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  // Preloader
  window.addEventListener('load',()=>{document.getElementById('loader').classList.add('hidden')});
  // AOS
  AOS.init({ once:true, duration:700, easing:'ease-out-quart' });
  // Navbar shadow
  const nav=document.querySelector('.navbar');
  window.addEventListener('scroll',()=>{ nav.classList.toggle('shadow-sm', window.scrollY>10) });

  // Counter
  const counters=document.querySelectorAll('.counter');
  const io=new IntersectionObserver((entries,obs)=>{
    entries.forEach(e=>{
      if(e.isIntersecting){
        const el=e.target, target=parseInt(el.dataset.target,10)||0;
        let cur=0, step=Math.ceil(target/60);
        const tick=()=>{ cur+=step; if(cur>target) cur=target; el.textContent=cur.toLocaleString('id-ID'); if(cur<target) requestAnimationFrame(tick); };
        tick(); obs.unobserve(el);
      }
    });
  },{threshold:.6});
  counters.forEach(c=>io.observe(c));

  // Leaflet map (Peta Nagari Ophir) + dukung GeoJSON
  <?php if ($site['lat'] && $site['lng']): ?>
  const mapO = L.map('map_ophir').setView([<?= $site['lat'] ?>, <?= $site['lng'] ?>], 12);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19, attribution:'&copy; OpenStreetMap'}).addTo(mapO);
  fetch('assets/ophir.geojson')
    .then(r => r.ok ? r.json() : null)
    .then(data => {
      if(data){
        const layer = L.geoJSON(data, {
          style: { color: '#ef4444', weight: 3, opacity: 0.9, fillColor: '#f87171', fillOpacity: 0.20 }
        }).addTo(mapO);
        try{ mapO.fitBounds(layer.getBounds(), {padding:[20,20]}); }catch(_e){}
      } else {
        L.circleMarker([<?= $site['lat'] ?>, <?= $site['lng'] ?>], { radius: 8, color:'#ef4444', fillColor:'#ef4444', fillOpacity:0.9 })
          .addTo(mapO).bindPopup('Nagari Ophir');
      }
    })
    .catch(()=>{
      L.circleMarker([<?= $site['lat'] ?>, <?= $site['lng'] ?>], { radius: 8, color:'#ef4444', fillColor:'#ef4444', fillOpacity:0.9 })
        .addTo(mapO).bindPopup('Nagari Ophir');
    });
  <?php endif; ?>

  // Chart.js
  const pendudukChart=new Chart(document.getElementById('pendudukChart'),{
    type:'bar',
    data:{ labels:['0-5','6-12','13-17','18-30','31-45','46-60','>60'],
      datasets:[
        { label:'Laki-laki', data:[480,700,560,1200,800,520,200] },
        { label:'Perempuan', data:[450,680,540,1100,780,510,250] }
      ]
    },
    options:{
      responsive:true,
      plugins:{ legend:{ position:'bottom', labels:{ color:'#ffffff' } } },
      scales:{
        x:{ ticks:{ color:'#ffffff' }, grid:{ color:'rgba(255,255,255,.2)' } },
        y:{ beginAtZero:true, ticks:{ color:'#ffffff' }, grid:{ color:'rgba(255,255,255,.2)' } }
      }
    }
  });
  const pendidikanChart=new Chart(document.getElementById('pendidikanChart'),{
    type:'line',
    data:{ labels:['SD','SMP','SMA','Diploma','S1','S2+'],
      datasets:[{ label:'Jumlah', data:[1800,1600,1400,300,220,40], tension:.35, fill:false }]
    },
    options:{
      responsive:true,
      plugins:{ legend:{ display:false } },
      scales:{
        x:{ ticks:{ color:'#ffffff' }, grid:{ color:'rgba(255,255,255,.2)' } },
        y:{ ticks:{ color:'#ffffff' }, grid:{ color:'rgba(255,255,255,.2)' } }
      }
    }
  });

  // Unduh CSV (jika ada tombolnya)
  document.getElementById('downloadCSV')?.addEventListener('click',()=>{
    let csv='Kelompok,Pria,Perempuan\n';
    pendudukChart.data.labels.forEach((lab,i)=>{ csv += `${lab},${pendudukChart.data.datasets[0].data[i]},${pendudukChart.data.datasets[1].data[i]}\n`; });
    const blob=new Blob([csv],{type:'text/csv;charset=utf-8;'}); const url=URL.createObjectURL(blob);
    const a=document.createElement('a'); a.href=url; a.download='statistik_penduduk_ophir.csv'; a.click(); URL.revokeObjectURL(url);
  });

  // Galeri lightbox
  function openLightbox(src){
    const d=document.getElementById('lightbox'); const img=document.getElementById('lightboxImg');
    if(!d||!img) return; img.src=src; d.showModal();
    const closeHandler=(e)=>{ if(e.target.tagName!=='IMG'){ d.close(); d.removeEventListener('click',closeHandler);} };
    d.addEventListener('click',closeHandler);
  }
  window.openLightbox=openLightbox;

  // Footer year
  document.getElementById('year').textContent=new Date().getFullYear();
</script>
</body>
</html>
