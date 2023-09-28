<div class="iq-card">
  <div class="iq-card-body">
		<table class="table table-bordered col-md-12 mb-3">
			<thead>
				<tr>
					<th style="width: 10%;">Nombre</th>
					<th style="width: 60%;">Direccion</th>
					<th style="width: 10%;">Imagen</th>
					<th style="width: 20%;">Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($clientes as $ls) { ?>
					<tr> 
						<td><?= $ls['nombre']; ?></td>
						<td><?= $ls['direccion']; ?></td>
						<td><img src="./web/assets/img/clients/<?= $ls['imagen']; ?>" alt="./web/assets/img/clients/<?= $ls['imagen']; ?>" style="width: 70px; height: 50px;"></td>
						<td>
							<button type="button" class="btn btn-info" onclick="actualizar_registro(<?= $ls['cliente_id']; ?>, `<?= $ls['nombre']; ?>`, `<?= $ls['direccion']; ?>`, `<?= $ls['imagen']; ?>`);">Actualizar</button>
							<button type="button" class="btn btn-danger" onclick="eliminar_registro(<?= $ls['cliente_id']; ?>);">Eliminar</button>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
  	<div class="col-md-12 mt-5 mb-3"><hr></div>
     <form class="form-cliente mt-5" autocomplete="off">
        <div class="form-row">
            <div class="col-md-12 mb-3">
              <label for="nombre">Titulo de clientes*</label>
              <input type="text" class="form-control nombre" name="nombre" value="<?=$data['nombre'];?>" placeholder="">
            </div>
            <div class="col-md-6 mb-3">
              <label for="nombre">Nombre*</label>
              <input type="hidden" class="form-control cliente_id" name="cliente_id" value="0">
              <input type="hidden" class="form-control principal_id" name="principal_id" value="1">
              <input type="hidden" class="form-control nombre_imagen" name="nombre_imagen" value="sin_imagen.jpg">
              <input type="text" class="form-control nombre" name="nombre" value="<?=$data['nombre'];?>" placeholder="">
            </div>
            <div class="col-md-6 mb-3">
              <label for="imagen">Imagen</label>
              <input type="file" class="form-control-file imagen" name="imagen" placeholder="">
            </div>
            <div class="col-md-12 mb-3">
              <label for="direccion">Dirección*</label>
              <input type="text" class="form-control direccion" name="direccion" value="<?=$data['direccion'];?>" placeholder="">
            </div>
        </div>
				<div class="form-group mt-5">
					<button class="btn btn-success" type="button" onclick="validar_form();"><i class="ri-add-circle-fill"></i> <?=$button;?></button>
					<a href="<?= base_url(); ?>Principales" class="btn btn-secondary"><i class="ri-close-circle-fill"></i> Cancelar</a>
				</div>
        <!-- alert success -->
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
     </form>
  </div>
</div>
