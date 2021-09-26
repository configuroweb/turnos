<?php
include 'admin/db_connect.php';
$qry = $conn->query("SELECT q.*,t.name as tname FROM queue_list q inner join transactions t on t.id = q.transaction_id  where q.id=".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
?>
<h4 style="text-align:center"><?php echo ucwords($tname) ?></h4>
<h5 style="text-align:center"><b><?php echo ucwords($name) ?></b></h5>
<hr>
<h2 style="text-align:center"><b><?php echo ucwords($queue_no) ?></b></h2>
<style>
	body *{
		margin:unset;
	}
</style>