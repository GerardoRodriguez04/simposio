<div class="iq-card">
  <div class="iq-card-body">
     <form class="form-principal" autocomplete="off">
        <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="correo_principal">Correo electrónico*</label>
              <input type="hidden" class="form-control" name="principal_id" value="1">
              <input type="text" class="form-control" name="correo_principal" value="<?=$data['correo_principal'];?>" placeholder="">
            </div>
            <div class="col-md-6 mb-3">
              <label for="telefono_1">Teléfono 1*</label>
              <input type="text" class="form-control" name="telefono_1" value="<?=$data['telefono_1'];?>" placeholder="">
            </div>
            <div class="col-md-6 mb-3">
              <label for="telefono_2">Teléfono 2*</label>
              <input type="text" class="form-control" name="telefono_2" value="<?=$data['telefono_2'];?>" placeholder="">
            </div>
            <div class="col-md-6 mb-3">
              <label for="logo_inicio">Logo inicio*</label>
              <input type="file" class="form-control-file" name="logo_inicio" value="<?=$data['logo_inicio'];?>" placeholder="">
            </div>
            <div class="col-md-12 mb-3">
              <label for="mensaje_inicio_1">Mensaje Bienvenida 1*</label>
              <input type="text" class="form-control" name="mensaje_inicio_1" value="<?=$data['mensaje_inicio_1'];?>" placeholder="">
            </div>
            <div class="col-md-12 mb-3">
              <label for="mensaje_inicio_2">Mensaje Bienvenida 2*</label>
              <input type="text" class="form-control" name="mensaje_inicio_2" value="<?=$data['mensaje_inicio_2'];?>" placeholder="">
            </div>
            <div class="col-md-4 mb-3">
              <label for="mision_inicio">Misión*</label>
              <textarea class="form-control" rows="5" name="mision_inicio" value="" placeholder=""><?=$data['mision_inicio'];?></textarea>
            </div>
            <div class="col-md-4 mb-3">
              <label for="vision_inicio">Visión*</label>
              <textarea class="form-control" rows="5" name="vision_inicio" value="" placeholder=""><?=$data['vision_inicio'];?></textarea>
            </div>
            <div class="col-md-4 mb-3">
              <label for="giro_inicio">Giro*</label>
              <textarea class="form-control" rows="5" name="giro_inicio" value="" placeholder=""><?=$data['giro_inicio'];?></textarea>
            </div>
            <div class="col-md-12 mb-3">
              <label for="subtitulo_nosotros">Subtitulo nosotros*</label>
              <input type="text" class="form-control" name="subtitulo_nosotros" value="<?=$data['subtitulo_nosotros'];?>" placeholder="">
            </div>
            <div class="col-md-12 mb-3">
              <label for="descripcion_nosotros">Descripción nosotros*</label>
              <textarea class="form-control" rows="3" name="descripcion_nosotros" value="<?=$data['descripcion_nosotros'];?>" placeholder=""></textarea>
            </div>
            <div class="col-md-6 mb-3">
              <label for="imagen_nosotros_1">Imagen nosotros 1*</label>
              <input type="file" class="form-control-file" name="imagen_nosotros_1" value="<?=$data['imagen_nosotros_1'];?>" placeholder="">
            </div>
            <div class="col-md-6 mb-3">
              <label for="imagen_nosotros_2">Imagen nosotros 2*</label>
              <input type="file" class="form-control-file" name="imagen_nosotros_2" value="<?=$data['imagen_nosotros_2'];?>" placeholder="">
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
