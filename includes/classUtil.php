<!-- classUtil.php
//
// MAINTENANCE HISTORY
// DATE         PROGRAMMER AND DETAILS
// 06-12-15     Rahul Sharma    	Original
//
//-------------------------------------------------------------------------------------
-->

<?php
class classUtil
{
	private $CHARS='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	private $BASE = 62;

	function encode($val) {
		$str = '';
		do {
			$i = $val % $this->BASE;
			$str = $this->CHARS[$i] . $str;
			$val = ($val - $i) / $this->BASE;
		} while($val > 0);
		return $str;
	}
	 
	function decode($str) {
		$len = strlen($str);
		$val = 0;
		$arr = array_flip(str_split($this->CHARS));
		for($i = 0; $i < $len; ++$i) {
			$val += $arr[$str[$i]] * pow($this->BASE, $len-$i-1);
		}
		return $val;
	}
}

?>
