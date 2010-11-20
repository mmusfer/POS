<?php 
class BarcodeHelper extends AppHelper
{
	public $CODE = '';
	public $FULLCODE = 'NO CODE SET';
	public $HEIGHT = 30;
	public $WIDTH = 30;
	public $CODEWIDTH = 0;
	public $CALMZONE = 5;
	public $HR = 'AUTO';
	public $BACKGROUND = 16777215;
	public $FOREGROUND = 0;
	public $ENCODED = '';
	public $IH = NULL;
	public $C39 =  array(
		'0' => "101001101101",	'1' => "110100101011",	'2' => "101100101011",
		'3' => "110110010101",	'4' => "101001101011",	'5' => "110100110101",
		'6' => "101100110101",	'7' => "101001011011",	'8' => "110100101101",
		'9' => "101100101101",	'A' => "110101001011",	'B' => "101101001011",
		'C' => "110110100101",	'D' => "101011001011",	'E' => "110101100101",
		'F' => "101101100101",	'G' => "101010011011",	'H' => "110101001101",
		'I' => "101101001101",	'J' => "101011001101",	'K' => "110101010011",
		'L' => "101101010011",	'M' => "110110101001",	'N' => "101011010011",
		'O' => "110101101001",	'P' => "101101101001",	'Q' => "101010110011",
		'R' => "110101011001",	'S' => "101101011001",	'T' => "101011011001",
		'U' => "110010101011",	'V' => "100110101011",	'W' => "110011010101",
		'X' => "100101101011",	'Y' => "110010110101",	'Z' => "100110110101",
		'-' => "100101011011",	'.' => "110010101101",	' ' => "100110101101",
		'$' => "100100100101",	'/' => "100100101001",	'+' => "100101001001",
		'%' => "101001001001",	'*' => "100101101101"
	);
	function setSize($height, $width=0, $calmZone=0)
	{
		$this->HEIGHT = ($height > 30 ? $height : 30);
		$this->WIDTH = ($width > 30 ? $width : 30);
		$this->CALMZONE = ($calmZone > 10 ? $calmZone : 10);
	}
	function checkCode()
	{
		if (preg_match("/^[0-9A-Z\-\.\$\/+% ]{1,48}$/i", $this->CODE))
			$this->FULLCODE = '*'.$this->CODE.'*';
		else
			$this->FULLCODE = "UNAUTHORIZED CHARS IN CODE 39";
	}
	function encode()
	{
		settype($this->FULLCODE, 'string');
		$code_length = strlen($this->FULLCODE);
		$encodedString = '';
		$a_tmp = array();
		for($i = 0; $i < $code_length; $i++)
			$a_tmp[$i] = $this->FULLCODE{$i};
		for ($i = 0; $i < $code_length; $i++)
			$encodedString .= $this->C39[$a_tmp[$i]] . "0";
		$encodedString = substr($encodedString, 0, -1);
		$nb_elem = strlen($encodedString);
		$this->CODEWIDTH = max($this->CODEWIDTH, $nb_elem);
		$this->WIDTH = max($this->WIDTH, $this->CODEWIDTH + ($this->CALMZONE*2));
		$this->ENCODED = $encodedString;
		$txtPosX = $posX = intval(($this->WIDTH - $this->CODEWIDTH)/2);
		$posY = 0;
		if ($this->IH)
			imagedestroy($this->IH);
		$this->IH = imagecreate($this->WIDTH, $this->HEIGHT);
		$color[0] = ImageColorAllocate($this->IH, 0xFF & ($this->BACKGROUND >> 0x10), 0xFF & ($this->BACKGROUND >> 0x8), 0xFF & $this->BACKGROUND);
		$color[1] = ImageColorAllocate($this->IH, 0xFF & ($this->FOREGROUND >> 0x10), 0xFF & ($this->FOREGROUND >> 0x8), 0xFF & $this->FOREGROUND);
		$color[2] = ImageColorAllocate($this->IH, 160,160,160);
		imagefilledrectangle($this->IH, 0, 0, $this->WIDTH, $this->HEIGHT, $color[0]);
		for ($i = 0; $i < $nb_elem; $i++)
		{
			$intH = $this->HEIGHT;
			if ($this->HR != '')
				if ($i > 0 AND $i < ($nb_elem-1))
					$intH -= 12;
			$fill_color = $this->ENCODED{$i};
			if ($fill_color == "1")
				imagefilledrectangle($this->IH, $posX, $posY, $posX, ($posY+$intH), $color[1]);
			$posX++;
		}
		$ifw = imagefontwidth(3);
		$ifh = imagefontheight(3) - 1;
		imagestring($this->IH, 3, intval(($this->WIDTH - $ifw * strlen($this->CODE)) / 2) + 1, $this->HEIGHT - $ifh, $this->CODE, $color[1]);
		$ifw = imagefontwidth(1) * 9;
		if ((rand(0,50) < 1) AND ($this->HEIGHT >= $ifw))
			imagestringup($this->IH, 1, $nb_elem + 12, $this->HEIGHT - 2, "", $color[2]);
	}
	function write_file($file)
	{
		$this->checkCode();
		$this->encode();
		imagepng($this->IH, $file);
	}
	function output($code)
	{
		$this->CODE = $code;
		$file = 'img/barcode/'.$this->CODE.'.png';
		$this->write_file($file);
		return 'barcode/'.$this->CODE.'.png';
	}
}