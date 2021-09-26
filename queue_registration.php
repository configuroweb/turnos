<style>
	.left-side{
		position: absolute;
		width: calc(40%);
		height: calc(100%);
		left: 0;
		top:0;
		background: #ffffffc7;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.right-side{
		position: absolute;
		width: calc(60%);
		height: calc(100%);
		right: 0;
		top:0;
		background:gray;
	}
	.slideShow{
		display: flex;
		justify-content: center;
		align-items: center;
		width: calc(100%);
		height: calc(100%);
		padding: auto;
	}
	.slideShow img,.slideShow video{
		max-width: calc(100%);
		max-height: calc(100%);
		opacity: 0;
		transition: all .5s ease-in-out;
	}
	.slideShow video{
		width: calc(100%);
	}
	a.btn.btn-sm.btn-success {
    z-index: 99999;
    position: fixed;
    left: 1rem;
}
</style>
<?php include "admin/db_connect.php" ?>
<a href="index.php" class="btn btn-sm btn-success"><i class="fa fa-home"></i> Volver al Inicio</a>
<div class="left-side">
	<div class="col-md-10 offset-md-1">
		<div class="card">
			<div class="card-body">
				<div class="container-fluid">
					<form action="" id="new_queue">
						<div class="form-group">
							<label for="name" class="control-label">Nombre</label>
							<input type="text" id="name" name="name" class="form-control">
						</div>
						<div class="form-group">
							<label for="transaction_id" class="control-label">Fila</label>
							<select name="transaction_id" id="transaction_id" class="custom-select browser-default select2" require>
									<option></option>
									<?php 
										$trans = $conn->query("SELECT * FROM transactions where status = 1 order by name asc");
										while($row=$trans->fetch_assoc()):
									?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
								<?php endwhile; ?>
							</select>
						</div>
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-md-3 float-right">Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="right-side">
	<?php
	$uploads = $conn->query("SELECT * FROM file_uploads order by rand() ");
	$slides = array();
	while($row= $uploads->fetch_assoc()){
		$slides[] = $row['file_path'];
	}
	?>
	<div class="slideShow">
		
	</div>
</div>
<script>
	var slides = <?php echo json_encode($slides) ?>;
	var scount = slides.length;
		if(scount > 0){
				$(document).ready(function(){
					render_slides(0)
				})
		}
	function render_slides(k){
		if(k >= scount)
			k = 0;
		var src = slides[k]
		k++;
		var t = src.split('.');
		var file ;
			t = t[1];
			if(t == 'mp4'){
				file = $("<video id='slide' src='admin/assets/uploads/"+src+"' onended='render_slides("+k+")' autoplay='true' muted='muted'></video>");
			}else{
				file = $("<img id='slide' src='admin/assets/uploads/"+src+"' onload='slideInterval("+k+")' />" );
			}
			console.log(file)
			if($('#slide').length > 0){
				$('#slide').css({"opacity":0});
				setTimeout(function(){
						$('.slideShow').html('');
				$('.slideShow').append(file)
				$('#slide').css({"opacity":1});
				if(t == 'mp4')
					$('video').trigger('play');

				
				},500)
			}else{
				$('.slideShow').append(file)
				$('#slide').css({"opacity":1});

							}
				
	}
	function slideInterval(i=0){
		setTimeout(function(){
		render_slides(i)
		},2500)

	}
	$('.select2').select2({
		placeholder:"Selecciona aquí",
		width:"100%"
	})
	$('#new_queue').submit(function(e){
		e.preventDefault()
		start_load()
			$.ajax({
				url:'admin/ajax.php?action=save_queue',
				method:'POST',
				data:$(this).serialize(),
				error:function(err){
					console.log(err)
					alert_toast("Ocurrió un error",'danger');
					alert_toast("Turno registrado exitósamente",'success');
					end_load()
				},
				success:function(resp){
					if(resp > 0){
						$('#name').val('')
						$('#transaction_id').val('').select2({
							placeholder:"Selecciona aquí",
							width:"100%"
						})
						var nw = window.open("queue_print.php?id="+resp,"_blank","height=500,width=800")
						nw.print()
						setTimeout(function(){
							nw.close()
						},500)
						end_load()
					alert_toast("Queue Registed Successfully",'success');
					}
				}
			})
		
	})

</script>