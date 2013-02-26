<?php
if($session->isAdmin()){
?>
<table class="alinks">
	<tr>
		<td id="align_left" colspan="100%">
			Admin panel: 
		</td>
	</tr>
	<tr>
		<td class="alinks"><a href="index.php?op=control_panel&page=general">Site Settings</a></td><td> | </td>
	    <td class="alinks"><a href="index.php?op=control_panel&page=stats">List Users</a></td><td> | </td>
	    <td class="alinks"><a href="index.php?op=control_panel&page=users">Manage Users</a></td><td> | </td>
	    <td class="alinks"><a href="index.php?op=control_panel&page=useful_links">Useful Links</a></td><td> | </td>
	    <td class="alinks"><a href="index.php?op=control_panel&page=manage_pages">Manage Pages</a></td><td> | </td>
	    <td class="alinks"><a href="index.php?op=control_panel&page=manage_events">Manage Events</a></td>
	</tr>
</table>
<br />
<?php } ?>
<table class="alinks">
	<tr>
		<td id="align_left" colspan="100%">
			User panel:
		</td>
	</tr>
	<tr>
	    <td class="alinks"><?php echo "<a class='menu' href=\"index.php?op=userinfo&user=$session->username\">My Account</a>"; ?></td><td> | </td>
	    <td class="alinks"><a href="index.php?op=useredit">Edit Info</a></td><td> | </td>
	    <td class="alinks"><a href="index.php?op=control_panel">Placeholder</a></td><td> | </td>
	    <td class="alinks"><a href="index.php?op=control_panel">Placeholder</a></td><td> | </td>
	    <td class="alinks"><a href="index.php?op=control_panel">Placeholder</a></td>
	</tr>
</table><br/>
<?php

if($session->isAdmin()){
	if(!isset($_GET['page'])){
		include("includes/login/admin/admin.php"); 
	} else {
		$req_page = trim($_GET['page']);
		if (is_file("includes/login/admin/".$req_page.".php")) {
	      	include("includes/login/admin/".$req_page.".php");
	    } else {	
			echo ("<div id='error'>Module could not be found!<br/></div>");
	    }
	}
}
?>
