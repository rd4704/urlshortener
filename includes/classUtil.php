<!-- classUtil.php
//
// MAINTENANCE HISTORY
// DATE         PROGRAMMER AND DETAILS
// 07-12-15     Rahul Sharma    	Original
//									Added feature to store shorten uri mapping to database
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
	
	// constructor
	function classUtil()
	{
		// open mysql connection
		mysql_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS) or die('Could not connect to database');
		mysql_select_db(MYSQL_DB) or die('Could not select database');	
	}

	// Return the id for a given url; -1 if doesn't exists
	function get_id($url)
	{
		$q = "SELECT id FROM ".URL_TABLE." WHERE url='".$url."'";
		$result = mysql_query($q);

		if ( mysql_num_rows($result) )
		{
			$row = mysql_fetch_array($result);
			
			// generate alpahnumeric id from table table id
			$en_id = $this->encode($row['id']);
			
			return $en_id;
		}
		else
		{
			return -1;
		}
	}

	// Return the url for a given id; -1 if doesn't exists
	function get_url($id)
	{
		$de_id = $this->decode($id);	// get decoded id
		$q = 'SELECT url FROM '.URL_TABLE.' WHERE (id="'.$de_id.'")';
		$result = mysql_query($q);

		if ( mysql_num_rows($result) )
		{
			$row = mysql_fetch_array($result);
			return $row['url'];
		}
		else
		{
			return -1;
		}
	}
	
	// Add an url to the database
	function insert_url($url)
	{
		// check to see if the url's already in the table
		$id = $this->get_id($url);
		
		// if already in the table return
		if ( $id != -1 )
		{
			return true;
		}
		else // otherwise insert 
		{
			$q = 'INSERT INTO '.URL_TABLE.' (url, createdon) VALUES ("'.$url.'", NOW())';
			return mysql_query($q);
		}
	}

}

?>
