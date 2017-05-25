<?php
require('nc_range_class.php');
session_start();
require('nc_config.php');
pg_connect($pg_connect);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>controls4_php</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link rel="stylesheet" href="../styles/aqtree3clickable.css" />
<link rel="stylesheet" href="../styles/custom-theme/jquery-ui-1.8.6.custom.css" />
<link rel="stylesheet" href="../styles/controls.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" ></script>
<script type="text/javascript" src="../javascript/jquery-ui-1.8.6.custom.min.js" ></script>
<script type="text/javascript" src="../javascript/aqtree3clickable.js"></script>
<script type="text/javascript" src="../javascript/controls_tab1.js"></script>
<script type="text/javascript" src="../javascript/controls234.js"></script>

<style type="text/css">
/* <![CDATA[ */
body {padding: 0px; margin: 2px;}
#tabs {font-size: 11px; width: 315px;}
#tabs-1 { width: 270px; font-size: 16px;}
#tabs-2{ width: 270px; font-size: 11px;}
#tabs-3 {overflow: scroll; width: 270px; font-size: 16px;}
button { width: 100px; margin: 15px;}
span.desc {font-size: 16px; line-height: 2;}
h2 {text-align: center;}
#tabs-2 li,td {list-style: none; font-size: 16px;}
/* ]]> */
</style>

<script language="javascript" type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){
functions_action();
document.forms[1].submit();
load_selections();
$("#tabs").tabs();
$("#opentab").click();
$("button").button();
var win_h = $(window).height();
$("#tabs-1,#tabs-2,#tabs-3").height(win_h - 78);

$("#sub").click(function(evt) {
document.forms[1].submit();	  
});
$("#back").click(function(evt) {
		  evt.preventDefault();
		  change_categories();
});

});


/* ]]> */
</script>
</head>
<body>
<div id="tabs">
<ul>
<li><a href="#tabs-1">View Layers</a></li>
<li><a id="opentab" href="#tabs-2">Select Species</a></li>
<li><a id="legendtab" href="#tabs-3">Legends</a></li>
</ul>
<div id="tabs-1">
<form>
<ul class="aqtree3clickable">
<li class="aq3open"><a href="#" class="no_link">Foreground</a>
<ul>
<li><input type="checkbox" name="basins_river"  onclick="loadlayers();" /><a>River Basins</a></li>
<li><input type="checkbox" name="sub_basins"  onclick="loadlayers();" /><a>Sub Basins</a></li>
<li><input type="checkbox" name="bird_consv"  onclick="loadlayers();" /><a>Bird Conservation</a></li>
<li><input type="checkbox" name="cities"  onclick="loadlayers();" /><a>Cities</a></li>
<li><input type="checkbox" name="counties" checked="checked" onclick="loadlayers();" /><a>Counties</a></li>
<li><input type="checkbox" name="hydro"  onclick="loadlayers();" /><a>Rivers</a></li>
<li><input type="checkbox" name="interstate"  onclick="loadlayers();" /><a>Interstates</a></li>
<li><input type="checkbox" name="roads"  onclick="loadlayers();" /><a>Roads</a></li>
<li><input type="checkbox" name="topo_24000"  onclick="loadlayers();" /><a>Topo Maps(1:24000)</a></li>
</ul>
</li>
<li><a href="#" class="no_link">Stewardship</a>
<ul>
<li><input type="radio" name="steward" value="gapown"  onclick="loadlayers();" /><a href="#own" onclick="show_lgnd();">Ownership</a></li>
<li><input type="radio" name="steward" value="gapman"  onclick="loadlayers();" /><a href="#manage" onclick="show_lgnd();">Management</a></li>
<li><input type="radio" name="steward" value="gapsta"  onclick="loadlayers();" /><a href="#status" onclick="show_lgnd();" >Status</a></li>
<li><input type="radio" name="steward" value="none" checked="checked" onclick="loadlayers();" /><a>none</a></li>
</ul>
</li>
<li><a href="#" class="no_link">Background</a>
<ul>
<li><input type="radio" name="background" value="landcover"  onclick="loadlayers();" /><a href="#lcov" onclick="show_lgnd();">Land Cover</a></li>
<li><input type="radio" name="background" value="elevation" checked="checked" onclick="loadlayers();" /><a href="#elev" onclick="show_lgnd();">Elevation</a></li>
<li><input type="radio" name="background" value="none"  onclick="loadlayers();" /><a>none</a></li>
</ul>
</li>
</ul>
</form>
</div>
<div id="tabs-2">

<?php
$species = $_POST['species'];
$fed = $_POST['fed'];
$state = $_POST['state'];
$gap = $_POST['gap'];
$nsglobal = $_POST['nsglobal'];
$nsstate = $_POST['nsstate'];
$pif = $_POST['pif'];
$sel = $_POST['sel'];

$aoi_name = $_POST['aoi_name'];
$rclass = $_SESSION["range".$aoi_name];

$tot_class = $rclass->num_class($species, $sel, $fed, $state, $gap, $nsglobal, $nsstate, $pif);
?>

<form action="select_species.php" method="post" target="data">

<input type="hidden" name="type" value='reload' />
<input  type="hidden" name="aoi_name" value="<?php echo $aoi_name; ?>" />
<table>
<tr><th>Species Group</th><th>Total Count</th><th>Display</th></tr>

<tr>
<td>Avian Species</td>
<td class="cnt"><?php echo $tot_class['avian']; ?></td>
<td class="cnt"><input type="checkbox" name="avian" checked="checked" /></td>
</tr>

<tr>
<td>Mammalian Species</td>
<td class="cnt"><?php  echo  $tot_class['mammal']; ?></td>
<td class="cnt"><input type="checkbox" name="mammal" checked="checked" /></td>
</tr>

<tr>
<td>Reptilian Species</td>
<td class="cnt"><?php echo $tot_class['rept']; ?></td>
<td class="cnt"><input type="checkbox" name="reptile" checked="checked" /></td>
</tr>

<tr>
<td>Amphibian Species</td>
<td class="cnt"><?php echo $tot_class['amph']; ?></td>
<td class="cnt"><input type="checkbox" name="amphibian" checked="checked" /></td>
</tr>
</table>

<button id="back">Back</button>
<button id="sub">Submit</button>

<ul>
 <br />

<li>
	<input id="modesingle" type="radio" name="mode" checked="checked" value="single" onclick="functions_action();" /><label for="modesingle" > Single&nbsp;species&nbsp;Mode</label>	  
</li>
<li>
	<input id="modemult" type="radio" name="mode"  value="multiple" onclick="functions_action();" /> <label for="modemult" > Multiple&nbsp;Species&nbsp;Mode </label>	  
</li>
</ul>



</form>
</div>
<div id="tabs-3">
				
<h4><a href="#lcov">GAP Land Cover</a></h4>
<h4><a href="#owner">Ownership (Stewardship)</a></h4>
<h4><a href="#manage">Management (Stewardship)</a></h4>
<h4><a href="#status">GAP Status (Stewardship)</a></h4>


<a name="elev"></a><br /><br />
<h4>Elevation (meters)</h4>
<img src="/graphics/ncgap/nc_elev_legend.png" alt="elevation legend" /><br /><br />


<a name="lcov"></a><br /><br />
<h4>GAP Land Cover</h4>
<img src="/graphics/ncgap/nc_lc_legend_1.png" alt="cover legend" /><br />
<img src="/graphics/ncgap/nc_lc_legend_2.png" alt="cover legend" /><br />
<img src="/graphics/ncgap/nc_lc_legend_3.png" alt="cover legend" /><br />

<a name="own"></a><br /><br />
<h4>Ownership (Stewardship)</h4>
<img src="/graphics/ncgap/nc_leg_owner.png" alt="ownership legend" /><br />

<a name="manage"></a><br /><br />
<h4>Management (Stewardship)</h4>
<img src="/graphics/ncgap/nc_leg_manage.png" alt="manage legend" /><br />

<a name="status"></a><br /><br />
<h4>GAP Status (Stewardship)</h4>
<img src="/graphics/ncgap/nc_leg_status.png" alt="status legend" /><br />

<a name="range"></a><br /><br />
<h4>Known Range</h4>

<img src="/graphics/ncgap/nc_range_leg.png " alt="range code" />

</div>

</body>
</html>
