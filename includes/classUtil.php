<!-- classUtil.php
//
// MAINTENANCE HISTORY
// DATE         PROGRAMMER AND DETAILS
// 07-12-15     Rahul Sharma    	Original
//									Added feature to store shorten uri mapping to database
//	08-12-15	Rahul Sharma		Converted mysql query functions to PDO equivalent
//
//-------------------------------------------------------------------------------------
-->

<?php
class classUtil
{
	private $CHARS='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	private $BASE = 62;
	private $db;

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
		
	public function getConnection() {
		$dbHandle = null;
		try {
			$dbHandle = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DB, MYSQL_USER, MYSQL_PASS);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		return $dbHandle;
	}
	
	// Return the id for a given url; -1 if doesn't exists
	function get_id($url)
	{
        $conn = $this->getConnection();
		$q = "SELECT id FROM ".URL_TABLE." WHERE url='".$url."'";
        $stmt = $conn->prepare($q);
		$stmt->execute(); 
		$row = $stmt->fetch();
		
		if ($row)
		{
			// generate alpahnumeric id from table id
			$en_id = $this->encode($row[0]);
			
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
		$conn = $this->getConnection();
		$de_id = $this->decode($id);	// get decoded id
		$q = 'SELECT url FROM '.URL_TABLE.' WHERE (id="'.$de_id.'")';
		$stmt = $conn->prepare($q);
		$stmt->execute(); 
		$row = $stmt->fetch();
		
		if ($row)
		{			
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
		$conn = $this->getConnection();
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
			$query = $conn->prepare($q);
			$results = $query->execute();
			return $results;
		}
	}

}

?>