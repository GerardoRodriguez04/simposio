<div class="iq-card">
  <div class="iq-card-body">
     <form class="form-user" autocomplete="off">
        <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="nombre">Nombre*</label>
              <input type="hidden" class="form-control" name="usuario_id" value="<?=$data['usuario_id'];?>">
              <input type="text" class="form-control" name="nombre" value="<?=$data['nombre'];?>" placeholder="">
            </div>
            <div class="col-md-4 mb-3">
              <label for="apellido">Apellido*</label>
              <input type="text" class="form-control" name="apellido" value="<?=$data['apellido'];?>" placeholder="">
            </div>
            <div class="col-md-4 mb-3">
              <label for="correo">Correo*</label>
              <input type="text" class="form-control" name="email" value="<?=$data['email'];?>" placeholder="">
            </div>
            <div class="col-md-4 mb-3">
              <label for="telefono">Telefono*</label>
              <input type="text" class="form-control" name="telefono" value="<?=$data['telefono'];?>" placeholder="" autocomplete="off">
            </div>
            <div class="col-md-4 mb-12">
              <label for="perfil">Empresas</label>
              <select class="form-control empresa_id" name="empresa_id">
                  <option value="">Seleccione una Empresa</option>
                  <?php foreach ($empresas as $e) { ?>
                    <?php if($data['empresa_id'] == $e['empresa_id']){$selected = 'selected = "selected" ';}else{$selected = '';} ?>
                    <option <?=$selected;?> value="<?=$e['empresa_id'];?>"><?=$e['razon_social'];?></option>
                  <?php } ?>
              </select>
            </div>
            <div class="col-md-4 mb-12">
              <label for="perfil">Departamentos</label>
              <select class="form-control departamento_id" name="departamento_id[]" multiple="multiple" style="width: 100%;">
                  <option value="">Seleccione un Departamento</option>
                  <?php foreach ($departamentos as $d) { ?>
                    <?php $selected = ''; ?>
                    <?php foreach ($departamentos_usuario as $du) { ?>
                      <?php if($du['departamento_id'] == $d['departamento_id']){ ?>
                        <?php $selected = 'selected = "selected" '; ?>
                      <?php } ?>
                    <?php } ?>
                    <option <?=$selected;?> value="<?=$d['departamento_id'];?>"><?=$d['departamento'];?></option>
                  <?php } ?>

              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="perfil">Perfiles</label>
              <select class="form-control" name="perfil_id">
              <?php if($data['usuario_id'] == 1){ ?>
                <option value="1">Administrador</option>
              <?php }else{ ?>
                <option value="">Seleccione un Perfil</option>
                <?php foreach ($perfiles as $p) { ?>
                  <?php if($data['perfil_id'] == $p['perfil_id']){$selected = 'selected = "selected" ';}else{$selected = '';} ?>
                  <option <?=$selected;?> value="<?=$p['perfil_id'];?>"><?=$p['perfil'];?></option>
                <?php } ?>
              <?php } ?>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="password">Password*</label>
              <input type="text" class="form-control" name="password" value="" placeholder="........">
            </div>
            <div class="col-md-4 mb-3">
              <label for="confirmar_password">Confirmar Password*</label>
              <input type="text" class="form-control" name="confirmar_password" value="" placeholder="........">
            </div>
            <div class="col-md-4 mb-3">
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
           <a href="<?= base_url(); ?>Usuarios" class="btn btn-secondary"><i class="ri-close-circle-fill"></i> Cancelar</a>
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
