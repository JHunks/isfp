<?php
require('fpdf.php');
include_once("login/include/session.php"); 

if(!$session->isAdmin()){
	die("you should not be here. ip recorded, errors logged.");
}
if(isset($_POST['generate_a_report']) && $_POST['generate_a_report'] != 0){
	//echo "generate report for this event: ".$_POST['generate_a_report'];
} else {
	die("you should not be here. ip recorded, errors logged.");
}
$event_id = $_POST['generate_a_report'];

$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $connection) or die(mysql_error());

$q = "SELECT * FROM events WHERE event_id='".$event_id."'";
$result_event_info = mysql_query($q, $connection);
$event_info = mysql_fetch_array($result_event_info);

$q = "SELECT * FROM registered_to_event WHERE event_id='".$event_id."'";
$result_registered_to_event_info = mysql_query($q, $connection);
$reg_info = array();
while($registered_to_event_info = mysql_fetch_array($result_registered_to_event_info)){
	$reg_info[] = $registered_to_event_info;
}

$q = "SELECT SUM(bring_num_guests) FROM registered_to_event WHERE event_id = $event_id AND bring_num_guests IS NOT NULL";
$bla = mysql_query($q, $connection);
$sum_of_guests = mysql_fetch_array($bla);

$total_number_of_attendees = mysql_num_rows($result_registered_to_event_info);
$total_number_of_guests = $sum_of_guests[0];
$total = $total_number_of_attendees+$total_number_of_guests;

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','U',16);
$pdf->Cell(80);
$pdf->Cell(40,10,'Report for event "'.$event_info['event_title'].'" - ['.$event_info['start_time'].']',0,1,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',14);
$pdf->Cell(80,7,'Number of attendees: '.$total_number_of_attendees);
$pdf->Ln();
$pdf->Cell(80,7,'Number of guests: '.$total_number_of_guests);
$pdf->Ln();
$pdf->Cell(80,7,'Total people coming: '.$total);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(40,7,'Name:');
$pdf->Cell(70,7,'E-Mail:');
$pdf->Cell(30,7,'Phone:');
$pdf->Cell(30,7,'Brings:');
$pdf->Cell(30,7,'Guests:');
$pdf->Ln();
$pdf->SetFont('Arial','',12);
foreach($reg_info as $info){
	$q = "SELECT firstname, lastname, email, pnumber from users where username ='".$info['user_id']."'";
	$result = mysql_query($q, $connection);
	$details = mysql_fetch_array($result);
	$name = $details['firstname']." ".$details['lastname'];
	$email = $details['email'];
	

	if($details['pnumber'] == null){
		$phone = "";
	} else {
		$phone = $details['pnumber'];
	}

	if($info['bring_item_PK'] == null){
		$brings = "";
	} else {
		$p = "SELECT item_name FROM bring_to_event WHERE randomPK =".$info['bring_item_PK'];
		$raz = mysql_query($p, $connection);
		$answaaa = mysql_fetch_array($raz);
		$brings = $info['bring_item_amount']." x ".$answaaa['item_name'];
	}
	if($info['bring_num_guests'] == null){
		$guest_num = "";
	} else {
		$guest_num = $info['bring_num_guests'];
	}

	$pdf->Cell(40,7,$name);
	$pdf->Cell(70,7,$email);
	$pdf->Cell(30,7,$phone);
	$pdf->Cell(30,7,$brings);
	$pdf->Cell(30,7,$guest_num);
	$pdf->Ln();
}
$pdf->Output('ISFP_report_for_event_'.$event_id.'.pdf', 'D');
?>