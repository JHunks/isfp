<?php
$connection_link = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connection_link) or die(mysql_error());
$q = "SELECT * FROM useful_links";
$result = mysql_query($q, $connection_link);

?>

<table class="useful_links">
	<tr>
		<th class="useful_links">Link:</td>
		<th class="useful_links">Description:</td>
	</tr>
	<?php
		while($useful_links = mysql_fetch_array($result)){
			?>
			<tr class="useful_links">
				<td class="useful_links_url"><a href="<?php echo $useful_links['link_url'];?>" target="_blank"><?php echo $useful_links['link_title']; ?></a></td>
				<td class="useful_links"><?php echo $useful_links['link_description']; ?></td>
			</tr>
	<?php
		}
	?>
</table>