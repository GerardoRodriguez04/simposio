<div class="col-sm-12">
	 <div class="iq-card">
	    <div class="iq-card-header d-flex justify-content-between">
	      <div class="iq-header-title">
  		    <div class="row">
            <div class="col-sm-12 col-md-12">
        			<button type="button" class="btn mb-6 btn-primary" onclick="ver_buscador();"><i class="ri-search-2-fill"></i> Buscador</button>
              <?php if(have_permission('Departamentos-Add')){ ?>      
              		<a href="javascript:void(0);" onclick="modal_departamento(0, '', '', 'Agregar');" class="btn mb-6 btn-warning" style="background: #d05400 !important; color: white !important; border: 1px #d05400 !important;"><i class="ri-add-circle-fill"></i> Agregar</a>
              <?php } ?>
              <div class="dropdown pull-right">
                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #1d9b72; margin-left: 4px;">
                  <i class="fa fa-file-excel-o" aria-hidden="true"></i> Ingreso Multiple
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="<?= base_url(); ?>Departamentos/descargar_excel_servicios">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> Servicios
                  </a>
                  <a class="dropdown-item" href="<?= base_url(); ?>Departamentos/descargar_excel_usuarios">
                    <i class="fa fa-users" aria-hidden="true"></i> Usuarios
                  </a>
                </div>
              </div>
              <?php if(have_permission('Reportes-Ver')){ ?>      
              <a class="btn btn-info" href="<?= base_url(); ?>Departamentos/reporte_excel" style="margin-left: 4px;">
                <i class="fa fa-list-ol" aria-hidden="true"></i> Reporte departamentos
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
      						<div class="form-group col-md-8">
      							<input type="text" class="form-control" name="departamento" placeholder="Departamento" onkeyup="crear_paginacion(0);">
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
                  <th scope="col">Departamento</th>
                  <th scope="col">Descripción</th>
                  <th scope="col">Estatus</th>
                  <th scope="col">Visible</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody class="tbody-departamentos"></tbody>
            </table>
    			  <div class="col-md-12 div-pagination justify-content-center align-items-center row" id='pagination'></div>
	       </div>
	    </div>
	 </div>
</div>


<div class="modal fade bd-example-modal-xl modal-departamento" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
           <h5 class="modal-title"><i class="fa fa-plus-circle" aria-hidden="true"></i> Departamento </h5>
           </button>
        </div>
        <div class="modal-body">
      <form class="form-departamentos" autocomplete="off">
        <div class="col-md-12 row">
          <div class="col-md-12 mb-3">
            <label for="departamento">Departamento*</label>
            <input type="hidden" class="form-control departamento_id" name="departamento_id" value="0">
            <input type="text" class="form-control departamento" name="departamento">
          </div>
          <div class="col-md-12 mb-3">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control descripcion" name="descripcion"></textarea>
          </div>
          <!-- alert success -->
          <div class="col-md-12 alert bg-white alert-success" role="alert" style="display: none;">
            <div class="iq-alert-icon">
               <i class="ri-information-line"></i>
            </div>
            <div class="iq-alert-text alert-text-exito"></div>
            <button type="button" class="close text-muted" data-dismiss="alert" aria-label="Close">
              <i class="ri-close-line"></i>
            </button>
          </div>
          <!-- alert danger -->
          <div class="col-md-12 alert bg-white alert-danger" role="alert" style="display: none;">
            <div class="iq-alert-icon">
               <i class="ri-information-line"></i>
            </div>
            <div class="iq-alert-text alert-text-error"></div>
            <button type="button" class="close text-muted" data-dismiss="alert" aria-label="Close">
              <i class="ri-close-line"></i>
            </button>
          </div>
        </div>
      </form>
        </div>
        <div class="modal-footer">
      <button type="button" class="btn btn-success btn-form" onclick="validar_form();"> </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</button>
        </div>
     </div>
  </div>
</div>

<div class="modal fade bd-example-modal-xl modal-excel" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
           <h5 class="modal-title"><i class="fa fa-plus-circle" aria-hidden="true"></i> Departamento <span class="departamento_span"></span></h5>
           </button>
        </div>
        <div class="modal-body">
          <form class="form-excel" autocomplete="off">
            <div class="col-md-12 row">
              <div class="col-md-12 mb-3">
                <label for="archivo_excel">Cargar Servicios*</label>
                <input type="hidden" class="form-control excel_departamento_id" name="departamento_id" value="0">
                <input type="file" class="form-control-file archivo_excel" name="archivo_excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
              </div>
              <div class="col-md-12 mb-3 progress">
                <input type="hidden" class="total_servicios_cargados" value="0">
                <div class="progress-bar progress-bar-servicios" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-form btn-servicios-excel" onclick="validar_servicios_excel();"><i class="ri-add-circle-fill"></i> Agregar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</button>
        </div>
     </div>
  </div>
</div>

<div class="modal fade bd-example-modal-xl modal-excel-usuarios" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
        <div class="modal-header">
           <h5 class="modal-title"><i class="fa fa-plus-circle" aria-hidden="true"></i> Departamento <span class="departamento_usuarios_span"></span></h5>
           </button>
        </div>
        <div class="modal-body">
          <form class="form-excel-usuarios" autocomplete="off">
            <div class="col-md-12 row">
              <div class="col-md-12 mb-3">
                <select class="form-control perfil_id" name="perfil_id">
                  <option value="">Seleccione un Perfil</option>
                  <?php foreach ($perfiles as $p) { ?>
                    <option value="<?=$p['perfil_id'];?>"><?=$p['perfil'];?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-12 mb-3">
                <label for="archivo_usuarios_excel">Cargar Usuarios*</label>
                <input type="hidden" class="form-control excel_usuarios_departamento_id" name="departamento_id" value="0">
                <input type="file" class="form-control-file archivo_usuarios_excel" name="archivo_usuarios_excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
              </div>
              <div class="col-md-12 mb-3 progress">
                <input type="hidden" class="total_usuarios_cargados" value="0">
                <div class="progress-bar progress-bar-usuarios" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-form btn-usuarios-excel" onclick="validar_usuarios_excel();"><i class="ri-add-circle-fill"></i> Agregar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</button>
        </div>
     </div>
  </div>
</div>