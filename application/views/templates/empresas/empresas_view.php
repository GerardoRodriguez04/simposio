<div class="col-sm-12">
	 <div class="iq-card">
	    <div class="iq-card-header d-flex justify-content-between">
	       <div class="iq-header-title">
				<div class="row">
	                <div class="col-sm-12 col-md-12">
	          			<button type="button" class="btn mb-6 btn-primary" onclick="ver_buscador();"><i class="ri-search-2-fill"></i> Buscador</button>
            			<?php if(have_permission('Empresas-Add')){ ?>      
	          			<a href="<?= base_url(); ?>Empresas/form_view/0" class="btn mb-6 btn-warning" style="background: #d05400 !important; color: white !important; border: 1px #d05400 !important;"><i class="ri-add-circle-fill"></i> Agregar</a>
	          			<?php } ?>
              			<?php if(have_permission('Reportes-Ver')){ ?>      
						<a class="btn btn-info" href="<?= base_url(); ?>Empresas/reporte_excel" style="margin-left: 4px;">
						  <i class="fa fa-list-ol" aria-hidden="true"></i> Reporte empresas
						</a>
						<?php } ?>
	          		</div>
	          	</div>
	       </div>
	    </div>
	    <div class="iq-card-body">
	       <div>
				<form method="GET" class="form-buscador container-fluid" style="display: none;" autocomplete="off">
				  	<div class="row">
						<div class="form-group col-md-4">
							<input type="text" class="form-control" name="nombre" placeholder="Nombre" onkeyup="crear_paginacion(0);">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control" name="apellido" placeholder="Apellido" onkeyup="crear_paginacion(0);">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control" name="email" placeholder="Correo" onkeyup="crear_paginacion(0);">
						</div>
						<div class="form-group col-md-4">
							<select class="form-control" name="departamento_id" id="exampleFormControlSelect1" onchange="crear_paginacion(0);">
	      				<option value="">Seleccione un Departamento</option>
	              <?php foreach ($departamentos as $p) { ?>
	                <option value="<?=$p['departamento_id'];?>"><?=$p['departamento'];?></option>
	              <?php } ?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<select class="form-control" name="perfil_id" id="exampleFormControlSelect1" onchange="crear_paginacion(0);">
	      				<option value="">Seleccione un Perfil</option>
	              <?php foreach ($perfiles as $p) { ?>
	                <option value="<?=$p['perfil_id'];?>"><?=$p['perfil'];?></option>
	              <?php } ?>
							</select>
						</div>
						<div class="form-group col-md-4">
							<select class="form-control" name="activo" id="exampleFormControlSelect1" onchange="crear_paginacion(0);">
								<option value="todos">Seleccione un Estatus</option>
								<option value="1">Activos</option>
								<option value="0">Inactivos</option>
							</select>
						</div>
				  	</div>
				</form>
	          <table class="table">
	             <thead class="thead-dark">
	                <tr>
	                   <th scope="col">#</th>
	                   <th scope="col">Razón social</th>
	                   <th scope="col">Dirección</th>
	                   <th scope="col">Teléfono</th>
	                   <th scope="col">Estatus</th>
	                   <th scope="col">Acciones</th>
	                </tr>
	             </thead>
	             <tbody class="tbody-empresas"></tbody>
	          </table>
			  <div class="col-md-12 div-pagination justify-content-center align-items-center row" id='pagination'></div>
	       </div>
	    </div>
	 </div>
</div>