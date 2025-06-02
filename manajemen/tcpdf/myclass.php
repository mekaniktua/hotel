<?php
class MYPDF extends TCPDF
{
	protected $last_page_flag = false;

	public function Close()
	{
		$this->last_page_flag = true;
		parent::Close();
	}
	// Page footer
	public function Footer()
	{
		if ($this->page == 1) { //Hanya dihalaman pertama
			$this->SetY(-10);
			$footerText = TCPDF_FONTS::addTTFfont('freestyler_script.ttf', 'TrueTypeUnicode', '', 96);
			$this->SetFont($footerText, 'N', 17);
			$this->SetRightMargin(10);
			$hr = '<span style="color:#0DBBFA"> Melayani, Profesional, Terpercaya</span>';
			$this->writeHTMLCell(0, 0, '', '', $hr, 0, 0, false, "L", "C", true);
		}

		if ($this->last_page_flag) {
			$this->SetY(-20);
			$this->SetRightMargin(15);
			$hr = '<hr />';
			$this->writeHTMLCell(0, 0, '', '', $hr, 0, 0, false, "L", "L", true);
			// Position at 15 mm from bottom
			$this->SetY(-19);
			// Set font
			$this->SetFont('helvetica', 'N', 8);
			$this->SetRightMargin(10);
			$this->SetLeftMargin(30);
			$footertext = "
				<p>
				Dokumen ini sah dan telah ditandatangani secara elektronik melalui e-Office ATR/ BPN. Untuk memastikan keasliannya, silakan pindai Kode QR menggunakan fitur 'Validasi Surat' pada aplikasi Sentuh Tanahku
				</p>";

			$this->writeHTMLCell(0, 0, '', '', $footertext, 0, 0, false, "L", "L", true);
		}
	}

	public function Header()
	{
		if ($this->page != 1) { //Hanya dihalaman pertama
			$this->SetY(5);
			$headerText = TCPDF_FONTS::addTTFfont('times.ttf', 'TrueTypeUnicode', '', 96);
			$this->SetFont($headerText, 'N', 8);
			$this->SetRightMargin(10);
			$halaman = '- ' . $this->getAliasNumPage() . ' -';
			$this->writeHTMLCell(0, 0, '', '', $halaman, 0, 0, false, "L", "C", true);
		}
	}
}
?>