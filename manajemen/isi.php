<?php
 
if(!empty($_GET['menu'])){
	if($_GET['menu']=='home' ){
		include("pages/home.php");
	}
	if($_GET['menu']=='user' ){
		include("pages/user.php");
	}
	if($_GET['menu']== 'userNew' ){
		include("pages/userNew.php");
	} 
	if($_GET['menu']== 'userEdit' ){
		include("pages/userEdit.php");
	} 
	if($_GET['menu']=='merchant' ){
		include("pages/merchant.php");
	}
	if ($_GET['menu'] == 'merchantNew') {
		include("pages/merchantNew.php");
	}
	if ($_GET['menu'] == 'merchantEdit') {
		include("pages/merchantEdit.php");
	}
	if($_GET['menu']=='keluar' ){
		include("pages/keluar.php");
	}  
	if ($_GET['menu'] == 'room') {
		include("pages/room.php");
	} 
	if ($_GET['menu'] == 'roomEdit') {
		include("pages/roomEdit.php");
	}
	if ($_GET['menu'] == 'gallery') {
		include("pages/gallery.php");
	}
	if ($_GET['menu'] == 'member') {
		include("pages/member.php");
	}
	if ($_GET['menu'] == 'bookingKeyword') {
		include("pages/bookingKeyword.php");
	}
	if ($_GET['menu'] == 'bookingDetail') {
		include("pages/bookingDetail.php");
	}
	if ($_GET['menu'] == 'bookingDate') {
		include("pages/bookingDate.php");
	}
	if ($_GET['menu'] == 'roomType') {
		include("pages/roomType.php");
	} 
	if ($_GET['menu'] == 'roomTypeEdit') {
		include("pages/roomTypeEdit.php");
	}
	if ($_GET['menu'] == 'facility') {
		include("pages/facility.php");
	}
	if ($_GET['menu'] == 'roomFacility') {
		include("pages/roomFacility.php");
	}
	if ($_GET['menu'] == 'property') {
		include("pages/property.php");
	}
	if ($_GET['menu'] == 'propertyNew') {
		include("pages/propertyNew.php");
	}
	if ($_GET['menu'] == 'propertyEdit') {
		include("pages/propertyEdit.php");
	}
	if ($_GET['menu'] == 'ratePlans') {
		include("pages/ratePlans.php");
	}
	if ($_GET['menu'] == 'voucher') {
		include("pages/voucher.php");
	}
	if ($_GET['menu'] == 'voucherNew') {
		include("pages/voucherNew.php");
	}
	if ($_GET['menu'] == 'voucherEdit') {
		include("pages/voucherEdit.php");
	}
	if ($_GET['menu'] == 'lapBooking') {
		include("pages/laporanBooking.php");
	}
	if ($_GET['menu'] == 'lapMember') {
		include("pages/laporanMember.php");
	}
	if ($_GET['menu'] == 'lapTransaksi') {
		include("pages/laporanTransaksi.php");
	}
	if ($_GET['menu'] == 'lapMerchant') {
		include("pages/laporanMerchant.php");
	}
	if ($_GET['menu'] == 'lapVoucher') {
		include("pages/laporanVoucher.php");
	}
	if ($_GET['menu'] == 'lapRoom') {
		include("pages/laporanRoom.php");
	}
	if ($_GET['menu'] == 'lapPegawai') {
		include("pages/laporanPegawai.php");
	}
	
}else{
	include("pages/home.php");
}
	

?>