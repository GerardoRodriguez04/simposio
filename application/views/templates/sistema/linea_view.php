<div class="iq-card">
  <div class="iq-card-body">
		<table class="table table-bordered col-md-12 mb-3">
			<thead>
				<tr>
					<th style="width: 10%;">Año</th>
					<th style="width: 70%;">Descripcion</th>
					<th style="width: 20%;">Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($lineas as $ls) { ?>
					<tr> 
						<td><?= $ls['año']; ?></td>
						<td><?= $ls['descripcion']; ?></td>
						<td>
							<button type="button" class="btn btn-info" onclick="actualizar_registro(<?= $ls['linea_id']; ?>, `<?= $ls['año']; ?>`, `<?= $ls['descripcion']; ?>`);">Actualizar</button>
							<button type="button" class="btn btn-danger" onclick="eliminar_registro(<?= $ls['linea_id']; ?>);">Eliminar</button>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
  	<div class="col-md-12 mt-5 mb-3"><hr></div>
     <form class="form-linea mt-5" autocomplete="off">
        <div class="form-row">
            <div class="col-md-1 mb-3">
              	<label for="año">Año*</label>
              	<input type="hidden" class="form-control linea_id" name="linea_id" value="0">
              	<input type="hidden" class="form-control principal_id" name="principal_id" value="1">
              	<input type="text" class="form-control año" name="año" value="<?=$data['año'];?>" placeholder="" maxlength="4">
            </div>
            <div class="col-md-11 mb-3">
              	<label for="descripcion">Descripción*</label>
              	<textarea class="form-control descripcion" rows="5" name="descripcion" value="" placeholder="" maxlength="500"><?=$data['descripcion'];?></textarea>
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
