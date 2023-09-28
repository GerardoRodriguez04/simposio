<div class="col-md-12 row">
	<div class="col-md-6">
		 <div class="iq-card">
			<div class="list-group">
				<div class="list-group-item list-group-item-action active">
					<span class="font-weight-bold"><?=$data[0]['nombre'].' '.$data[0]['apellido'];?></span>
				</div>
				<div class="list-group-item list-group-item-action">
					<span class="font-weight-bold">Perfil:</span> <?=$data[0]['perfil'];?>
				</div>
				<div class="list-group-item list-group-item-action">
					<span class="font-weight-bold">Departamento:</span> <?=$data[0]['departamento'];?>
				</div>
				<div class="list-group-item list-group-item-action">
					<span class="font-weight-bold">Correo:</span> <?=$data[0]['email'];?>
				</div>
				<div class="list-group-item list-group-item-action">
					<span class="font-weight-bold">Telefono:</span> <?=$data[0]['telefono'];?>
				</div>
			</div>
		 </div>
	</div>

	<div class="col-md-6">
		 <div class="iq-card">
			<div class="list-group">
				<form class="form-password" autocomplete="off">
					<div class="list-group-item list-group-item-action active">
						<span class="font-weight-bold">Cambiar Password</span>
	              		<input type="hidden" class="form-control" name="usuario_id" value="<?=$data[0]['usuario_id'];?>">
	           			<button class="btn btn-success btn-sm float-right btn-actualizar-password" type="button" onclick="validar_password();">
	           				<i class="ri-edit-circle-fill"></i> Actualizar
	           			</button>
					</div>
					<div class="list-group-item list-group-item-action">
						<span class="font-weight-bold">Password:</span>
	              		<input type="text" class="form-control password" name="password" placeholder="********">
					</div>
					<div class="list-group-item list-group-item-action">
						<span class="font-weight-bold">Confirmar Password:</span>
	              		<input type="text" class="form-control confirmar_password" name="confirmar_password" placeholder="********">
				</div>
				</form>
			</div>
		 </div>
	</div>

	<!-- alert success -->
	<div class="col-md-12">
		<div class="alert bg-white alert-success" role="alert" style="display: none;">
		  <div class="iq-alert-icon">
		     <i class="ri-information-line"></i>
		  </div>
		  <div class="iq-alert-text alert-text-exito"></div>
		  <button type="button" class="close text-muted" data-dismiss="alert" aria-label="Close">
		    <i class="ri-close-line"></i>
		  </button>
		</div>
		<!-- alert danger -->
		<div class="alert bg-white alert-danger" role="alert" style="display: none;">
		  <div class="iq-alert-icon">
		     <i class="ri-information-line"></i>
		  </div>
		  <div class="iq-alert-text alert-text-error"></div>
		  <button type="button" class="close text-muted" data-dismiss="alert" aria-label="Close">
		    <i class="ri-close-line"></i>
		  </button>
		</div>
	</div>
</div>