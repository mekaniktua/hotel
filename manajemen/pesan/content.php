<?php
if(empty($_GET['t'])){
    include('pages/beranda.php');
}else if ($_GET['t']=='pelanggan') {
    include('pages/pelanggan.php');
}else if ($_GET['t'] == 'pelangganNew') {
    include('pages/pelangganNew.php');
}else if ($_GET['t'] == 'pelangganEdit') {
    include('pages/pelangganEdit.php');
} else if ($_GET['t'] == 'grup') {
    include('pages/grup.php');
} else if ($_GET['t'] == 'grupNew') {
    include('pages/grupNew.php');
} else if ($_GET['t'] == 'grupEdit') {
    include('pages/grupEdit.php');
} else if ($_GET['t'] == 'grupPelanggan') {
    include('pages/grupPelanggan.php');
} else if ($_GET['t'] == 'waUlangTahun') {
    include('pages/waUlangTahun.php');
} else if ($_GET['t'] == 'waPelanggan') {
    include('pages/waPelanggan.php');
} else if ($_GET['t'] == 'laporanPengiriman') {
    include('pages/laporanPengiriman.php');
} else {
    include('pages/notFound.php');
}
?>