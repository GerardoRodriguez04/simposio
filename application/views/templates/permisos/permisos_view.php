<div class="col-sm-12">
	 <div class="iq-card">
		<div class="iq-card-body">
		   <ul class="nav nav-pills mb-3 nav-fill" id="pills-tab-1" role="tablist">
		   	<?php foreach ($perfil as $p) { ?>
		   	<?php if($p['perfil_id'] == 1){$show = 'show'; $active = 'active';}else{$show = ''; $active = '';} ?>
		      <li class="nav-item">
		         <a class="nav-link <?=$active;?>" id="pills-<?=$p['perfil_id'];?>-tab-fill" data-toggle="pill" href="#pills-<?=$p['perfil_id'];?>-fill" role="tab" aria-controls="pills-<?=$p['perfil_id'];?>" aria-selected="true" onclick="get_permisos('perfil_<?=$p['perfil_id'];?>', 'perfil-<?=$p['perfil_id'];?>');"><?=$p['perfil'];?></a>
		      </li>
		   	<?php } ?>
		   </ul>
		   <div class="tab-content" id="pills-tabContent-1">
		   	<?php foreach ($perfil as $p) { ?>
		   	<?php if($p['perfil_id'] == 1){$show = 'show'; $active = 'active';}else{$show = ''; $active = '';} ?>
		      <div class="tab-pane fade <?=$show;?> <?=$active;?>" id="pills-<?=$p['perfil_id'];?>-fill" role="tabpanel" aria-labelledby="pills-<?=$p['perfil_id'];?>-tab-fill">
		      	<ul class="list-group perfil-<?=$p['perfil_id'];?>"></ul>
		      </div>
		   	<?php } ?>
		   </div>
		</div>
	</div>
</div>