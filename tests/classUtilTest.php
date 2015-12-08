<!-- classUtilTest.php
//
// MAINTENANCE HISTORY
// DATE         PROGRAMMER AND DETAILS
// 08-12-15     Rahul Sharma    	Original
//
//-------------------------------------------------------------------------------------
-->

<?php
require_once './includes/classUtil.php';
require_once './includes/conf.php';

class utilTest extends PHPUnit_Framework_TestCase
{
    public function testBijective()
    {
        $util = new classUtil();
		
		// Check if the encode and decode functions are bijective
		$this->assertEquals(1001, $util->decode($util->encode(1001)));
    }
	
	public function testOperations()
    {
		$test_url = 'http://mindvalley.com';
		$util = new classUtil();
		$conn = $util->getConnection();
		
		// Check if user can connect to the database
		$this->assertFalse($conn == false);		
		
		// Check if user can read database
        $query = $conn->prepare('SELECT * FROM tbl_urls');
        $results = $query->execute();
        $this->assertEquals(3, $query->columnCount());
		
		// begin the transaction
		$conn->beginTransaction();
		
		// Check if user has write access to the database
		$q = "INSERT INTO tbl_urls VALUES(1,'".$test_url."',now())";
		$query = $conn->prepare($q);
		$result = $query->execute();
        $this->assertEquals(true, $result);
		
		$conn->commit();		// force  commit to get the inserted id	(1)
		
		// Check if user get correct url from ID
		$id = $util->get_id($test_url);	// Get id for temp record
        $this->assertEquals(1, $id);
		
		// Delete the temp record
		$query = $conn->prepare("delete from tbl_urls where id = 1");
        $results = $query->execute();
		$newId = $conn->lastInsertId();		
    }
}
?>