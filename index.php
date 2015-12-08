<!-- index.php
//
// MAINTENANCE HISTORY
// DATE         PROGRAMMER AND DETAILS
// 07-12-15     Rahul Sharma    	Original
// 									Added feature to store shorten url mappings to mysql
//									Enabled URL rewrite rules for cleaner URL
//	08-12-15	Rahul Sharma		Fixed Fieldset width
//
//-------------------------------------------------------------------------------------
-->

<?php

require_once 'includes/classUtil.php'; //  Util class for db and shortcode generation
require_once 'includes/conf.php'; // website configuration

$classUtil = new classUtil();

$response = '';

// if the form has been submitted
if ( isset($_POST['url']) )
{
	// escape bad characters from the user's url
	$url = trim(mysql_escape_string($_POST['url']));
		
	// add the url to the database
	if ($classUtil->insert_url($url))
	{
        if ( REWRITE ) // mod_rewrite style link
		{
			$url = 'http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']).'/'.$classUtil->get_id($url);
		}
		else // regular GET style link
		{
			$url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'].'?id='.$classUtil->get_id($url);
		}

		$response = '<p>Short URL is: <a href="'.$url.'">'.$url.'</a></p>';
	}
	else
	{
		$response = '<p>Short URL could not be created!</p>';
	}
}
else // Handle url redirect requests from short urls
{
	// GET id
	if ( isset($_GET['id']) ) // check GET first
	{
		$id = mysql_escape_string($_GET['id']);
	}
	elseif ( REWRITE ) // check the URI if we're using mod_rewrite
	{
		$exploded = explode('/', $_SERVER['REQUEST_URI']);
		$id = mysql_escape_string($exploded[count($exploded)-1]);
	}
	else // otherwise, just make it empty
	{
		$id = '';
	}
	
	// if the id isn't empty and it's not refereing to the same server path
	if ( $id != '' && $id != basename($_SERVER['PHP_SELF']) )
	{
		$location = $classUtil->get_url($id);
		
		if ( $location != -1 )
		{
			header('Location: '.$location);
		}
		else
		{
			$response = '<p>Sorry, specified short URL is not available in our system.</p>';
		}
	}
}

?>

<!DOCTYPE html>
<html>

	<head>
		<title><?php echo PAGE_TITLE; ?></title>
	</head>
	
	<body style="width:800px; margin:0 auto;" onload="document.getElementById('url').focus()">
		
		<h1><?php echo PAGE_TITLE; ?></h1>
		
		<?php echo $response; ?>
		
		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
		
			<fieldset style="width:500px">
				<label for="url">Enter a long URL:</label>
				<input type="text" name="url" id="url" />
				<input type="submit" name="submit" id="submit" value="Shortify!" />
			</fieldset>
		
		</form>
	
	</body>

</html>