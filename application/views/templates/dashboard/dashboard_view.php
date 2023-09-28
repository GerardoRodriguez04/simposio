<div class="col-sm-12">
    <div class="iq-card">
       <div class="iq-card-header d-flex justify-content-between">
         <div class="iq-header-title">
            <div class="row">
               <div class="col-sm-12 col-md-12">
                  <button type="button" class="btn mb-6 btn-primary" onclick="ver_buscador();">
                     <i class="ri-search-2-fill"></i> Buscador
                  </button>
        
                  <a class="btn btn-success" href="<?= base_url(); ?>Dashboard/reporte_excel" style="margin-left: 4px;">
                     <i class="fa fa-file-excel-o" aria-hidden="true"></i> Reporte usuarios
                  </a>

                  <button type="button" class="btn mb-6 btn-info" onclick="enviar_correo();">
                     <i class="fa fa-envelope-o" aria-hidden="true"></i> Enviar correo
                  </button>
               </div>
            </div>
         </div>
       </div>
       <div class="iq-card-body">
          <div>
            <form method="GET" class="form-buscador container-fluid" style="display: none;" autocomplete="off">
               <div class="row">
                  <div class="form-group col-md-6">
                     <input type="text" class="form-control" name="nombre" placeholder="Nombre completo" onkeyup="crear_paginacion(0);">
                  </div>
                  <div class="form-group col-md-6">
                     <input type="text" class="form-control" name="correo_electronico" placeholder="Correo electrónico" onkeyup="crear_paginacion(0);">
                  </div>
                  <div class="form-group col-md-6">
                     <input type="text" class="form-control" name="telefono" placeholder="Whatsapp" onkeyup="crear_paginacion(0);">
                  </div>
                  <div class="form-group col-md-6">
                     <input type="text" class="form-control" name="universidad" placeholder="Universidad" onkeyup="crear_paginacion(0);">
                  </div>
                  <div class="form-group col-md-6">
                     <input type="text" class="form-control" name="carrera" placeholder="Carrera" onkeyup="crear_paginacion(0);">
                  </div>
                  <div class="form-group col-md-6">
                     <input type="text" class="form-control" name="area_interes" placeholder="Área de interes" onkeyup="crear_paginacion(0);">
                  </div>
                  <div class="form-group col-md-6">
                     <select class="form-control" name="tipo" onchange="crear_paginacion(0);">
                        <option value="">Seleccione un tipo</option>
                        <option value="1">Presencial</option>
                        <option value="2">En línea</option>
                     </select>
                  </div>
               </div>
            </form>
            <div class="col-md-12 table-responsive p-0">            
               <table class="table" style="text-transform: uppercase;">
                 <thead class="thead-dark">
                     <tr>
                        <th>Nombre</th>
                        <th>Contactos</th>
                        <th>Universidad</th>
                        <th>Carrera</th>
                        <th>Área de interes</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                     </tr>
                 </thead>
                 <tbody class="tbody-participantes"></tbody>
               </table>
            </div>
            <div class="col-md-12 div-pagination justify-content-center align-items-center row" id='pagination'></div>
          </div>
       </div>
    </div>
</div>

<div class="modal fade bd-example-modal-xl modal-participante" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
     <div class="modal-content">
        <div class="modal-header">
           <h5 class="modal-title"><i class="fa fa-plus-circle" aria-hidden="true"></i> Participante </h5>
           </button>
        </div>
        <div class="modal-body">
      <form class="form-registro" autocomplete="off">
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label for="nombre">Nombre completo</label>
                <input type="hidden" name="participante_id" class="form-control mb-0 participante_id">
                <input type="text" name="nombre" class="form-control mb-0 nombre">
            </div>
            <div class="form-group col-md-6">
                <label for="telefono">Whatsapp</label>
                <input type="text" name="telefono" class="form-control mb-0 telefono">
            </div>
            <div class="form-group col-md-6">
                <label for="correo_electronico">Correo electrónico</label>
                <input type="text" name="correo_electronico" class="form-control mb-0 correo_electronico">
            </div>
            <div class="form-group col-md-6">
                <label for="universidad">Universidad</label>
                <input type="text" name="universidad" class="form-control mb-0 universidad">
            </div>
            <div class="form-group col-md-6">
                <label for="carrera">Carrera</label>
                <input type="text" name="carrera" class="form-control mb-0 carrera">
            </div>
            <div class="form-group col-md-6">
                <label for="area_interes">Área de interés</label>
                <input type="text" name="area_interes" class="form-control mb-0 area_interes">
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
            <button type="button" class="btn btn-success btn-form" onclick="validar_form();"> 
               <i class="fa fa-plus-circle" aria-hidden="true"></i> Actualizar
            </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
               <i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar
            </button>
        </div>
     </div>
  </div>
</div>