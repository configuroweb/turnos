<?php include 'db_connect.php' ?>
<style>
   
</style>

<div class="containe-fluid">

	<div class="row">
		<div class="col-lg-12">
			
		</div>
	</div>

	<div class="row mt-3 ml-3 mr-3">
			<div class="col-lg-12">
    			<div class="card">
    				<div class="card-body">
    				<?php echo "Bienvenid@ de nuevo ". $_SESSION['login_name']."!"  ?>
    									
    				</div>
    				<hr>
    				
    		      </div>
                </div>
	</div>
<hr>
<?php if($_SESSION['login_type'] == 2): ?>
<?php 

?>
<script>
    function queueNow(){
            $.ajax({
                url:'ajax.php?action=update_queue',
                success:function(resp){
                    resp = JSON.parse(resp)
                    $('#sname').html(resp.data.name)
                    $('#squeue').html(resp.data.queue_no)
                    $('#window').html(resp.data.wname)
                }
            })
    }
</script>
<div class="row">
    <div class="col-md-4 text-center">
        <a href="javascript:void(0)" class="btn btn-primary" onclick="queueNow()">Next Serve</a>
    </div>
<div class="col-md-4">
    <div class="card">
        <div class="card-header bg-primary text-white"><h3 class="text-center"><b>Now Serving</b></h3></div>
            <div class="card-body">
                <h4 class="text-center" id="sname"></h4>
                <hr class="divider">
                <h3 class="text-center" id="squeue"></h3>
                <hr class="divider">
                <h5 class="text-center" id="window"></h5>
            </div>
        </div>
    </div>
</div>


<?php endif; ?>


</div>
<script>
	
</script>