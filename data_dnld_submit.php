<?php
/**
 * Collect selections from data_download.php and update table.
 * 
 * Update table data_dnld to allow cron on remote computer to query requests.
 * 
 * @package ncgap
 */
require('nc_aoi_class.php');
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>data download</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="StyleSheet" href="styles/popups.css" type="text/css" />
<link rel="stylesheet" href="styles/custom-theme/jquery-ui-1.8.6.custom.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" ></script>
<script type="text/javascript" src="javascript/jquery-ui-1.8.6.custom.min.js" ></script>
<style type="text/css">
/* <![CDATA[ */
.ui-widget {font-size: 11px;}
button {
		  width: 100px;
		  margin: 20px;
}
/* ]]> */
</style>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
$(document).ready(function() {
	$("button").button().click(function(evt) {
         evt.preventDefault();
			window.close();
      });
	 
		  
});
/* ]]> */
</script>
</head>
<body>

<?php
require('nc_config.php');
pg_connect($pg_connect);

$username = $_SESSION['username'];
$email = $_SESSION['email'];


$lcov = $_POST['lcov'];
$steward = $_POST['steward'];
$pds = $_POST['strpds'];
$aoi_name = $_POST['aoi_name'];
$extent_save = $_POST['ext_save'];
$lcov = $_POST['lcov'];
$steward = $_POST['steward'];
$r_map = $_POST['r_export'];
$r_species = pg_escape_string($_POST['r_species']);

//var_dump($_POST);

if (strlen($pds) != 0){
	$pds_ar = explode(':', $pds);
	foreach ($pds_ar as &$itiscode){
		$itiscode = "pd_".strtolower($itiscode);
	}
	$pds = implode(':', $pds_ar);
}



$query = sprintf("insert into data_dnld(username, email, aoi_name, bnd_box, lcov, steward, pds, r_map, r_species, chkd) 
	values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', false)", $username, $email, $aoi_name, $extent_save, $lcov, $steward, $pds, $r_map, $r_species);
pg_query($query);


?>
<p>Your request has been submitted as a batch request.</p>
<p>An email will be sent to <?php echo $email; ?> in a few minutes to notify you the request is ready for download.</p>
<button>Close</button>
<!--
<img id="b29" src="/graphics/ncgap/b29_up.png" alt="button" onclick="window.close();" style="padding: 30px;"
     onmousedown="document.getElementById('b29').src = '/graphics/ncgap/b29_dn.png'"
     onmouseup="document.getElementById('b29').src = '/graphics/ncgap/b29_up.png'"/>-->

</body>
</html>
