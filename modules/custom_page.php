<?php
if($dbarray['custom_pages'] == 0){
	 echo "<div id='error'>custom pages are disabled</div>";
} else {
	if(isset($_GET['page']) && $_GET['page'] != null){
		$display_page = true;
		$connection_pg = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
		mysql_select_db(DB_NAME, $connection_pg) or die(mysql_error());
		$q = "SELECT * FROM pages WHERE page_id='".$_GET['page']."'";
		$result = mysql_query($q, $connection_pg);
		$bdarray = mysql_fetch_array($result);
		mysql_close($connection_pg);
	} else {
		echo "<div id='error'>no page selected</div>";
	}
	if(isset($display_page)){
?>
		<div id="custom_page">
			<table id="t_c_page">
				<!--
				<tr>
					<td colspan="2" align="center">
						<h2><?php echo $bdarray['page_title'];?></h2>
					</td>
				</tr>
			-->
				<tr>
					<td colspan="2">
						<?php echo $bdarray['page_content'];?>
					</td>
				<tr id="small_text">
					<td align="left">
						Original by: <?php echo $bdarray['author'];?>
					</td>
					<td align="right">
						On: <?php echo $bdarray['date_created'];?>
					</td>
				</tr>
				<?php if($bdarray['date_modified'] != null && $bdarray['modified_by'] != null) { ?>
				<tr id="small_text">
					<td align="left">
						Edited by: <?php echo $bdarray['modified_by'];?>
					</td>
					<td align="right">
						On: <?php echo $bdarray['date_modified'];?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>
<?php 
	}
} 
?>
