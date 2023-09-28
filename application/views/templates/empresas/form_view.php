<div class="iq-card">
  <div class="iq-card-body">
     <form class="form-empresas" autocomplete="off">
        <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="razon_social">Razón social*</label>
              <input type="hidden" class="form-control" name="empresa_id" value="<?=$data['empresa_id'];?>">
              <input type="text" class="form-control" name="razon_social" value="<?=$data['razon_social'];?>" placeholder="">
            </div>
            <div class="col-md-6 mb-3">
              <label for="direccion">Dirección*</label>
              <input type="text" class="form-control" name="direccion" value="<?=$data['direccion'];?>" placeholder="">
            </div>
            <div class="col-md-6 mb-3">
              <label for="telefono">Teléfono*</label>
              <input type="text" class="form-control" name="telefono" value="<?=$data['telefono'];?>" placeholder="" autocomplete="off">
            </div>
            <div class="col-md-6 mb-3">
              <br><br>
               <div class="custom-control custom-switch custom-switch-color custom-control-inline">
                  <?php if($data['activo'] == 1){ $checked = 'checked="checked"';}else{$checked = ''; } ?>

                  <input type="checkbox" class="custom-control-input bg-primary" id="activo" name="activo" <?=$checked?> value="1">
                  <label class="custom-control-label" for="activo">Activar Usuario</label>
               </div>
            </div>
        </div>
        <div class="form-group">
           <button class="btn btn-success" type="button" onclick="validar_form();"><i class="ri-add-circle-fill"></i> <?=$button;?></button>
           <a href="<?= base_url(); ?>Empresas" class="btn btn-secondary"><i class="ri-close-circle-fill"></i> Cancelar</a>
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
