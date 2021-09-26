<?php 
include('db_connect.php');
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user">	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Nombre</label>
			<input type="text" name="name" id="name" class="form-control" value="<?php echo isset($meta['name']) ? $meta['name']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="username">Usuario</label>
			<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
		</div>
		<div class="form-group">
			<label for="password">Contraseña</label>
			<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
			<?php if(isset($meta['id'])): ?>
			<small><i>Deja este campo en blanco si no deseas cambiar la contraseña.</i></small>
		<?php endif; ?>
		</div>
		<div class="form-group">
			<label for="type">Tipo de Usuario</label>
			<select name="type" id="type" class="custom-select">
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Staff</option>
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>
			</select>
		</div>
		<div class="form-group" id="window-field">
			<label for="type">Ventana</label>
			<select name="window_id" id="window_id" class="custom-select select2">
				<option value="" <?php echo isset($meta['window_id']) && $meta['window_id'] == 0 ? 'selected': '' ?>></option>
				<?php 
				$query = $conn->query("SELECT w.*,t.name as tname FROM transaction_windows w inner join transactions t on t.id = w.transaction_id where w.status = 1 order by name asc");
				while($row= $query->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($meta['window_id']) && $meta['window_id'] == $row['id'] ? 'selected': ''; ?>><?php echo $row['tname']. ' '. $row['name'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>

	</form>
</div>
<script>
	$('.select2').select2({
		placeholder:"Selecciona aquí",
		width:"100%"
	})
	$('#type').change(function(){
		if($(this).val() == 1){
			$('#window-field').hide()
		}else{
			$('#window-field').show()
		}
	})
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=save_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_load()
				}
			}
		})
	})
	if($('#type').val() == 1){
			$('#window-field').hide()
		}else{
			$('#window-field').show()
		}
</script>