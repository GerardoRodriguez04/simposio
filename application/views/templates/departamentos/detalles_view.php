<div class="col-sm-12">
	 <div class="iq-card">
		<div class="iq-card-body">
		<ul class="nav nav-pills mb-1 nav-fill">
				<li class="nav-item">Departamento de <?=$departamento[0]['departamento'];?></li>
			</ul>
			<ul class="nav nav-pills mb-3 nav-fill" id="pills-tab-1" role="tablist">
			  	<li class="nav-item">
			     	<a class="nav-link active" id="pills-descripcion-tab-fill" data-toggle="pill" href="#pills-descripcion-fill" role="tab" aria-controls="pills-descripcion" aria-selected="true">Descripción</a>
			  	</li>
			  	<li class="nav-item">
			     	<a class="nav-link" id="pills-servicios-tab-fill" data-toggle="pill" href="#pills-servicios-fill" role="tab" aria-controls="pills-servicios" aria-selected="false">Servicios</a>
			  	</li>
			  	<li class="nav-item">
			     	<a class="nav-link" id="pills-Usuarios-tab-fill" data-toggle="pill" href="#pills-Usuarios-fill" role="tab" aria-controls="pills-Usuarios" aria-selected="false">Usuarios</a>
			  	</li>
			</ul>
			<div class="tab-content" id="pills-tabContent-1">
			  	<div class="tab-pane fade active show" id="pills-descripcion-fill" role="tabpanel" aria-labelledby="pills-descripcion-tab-fill">
			     	<p><?=$departamento[0]['descripcion'];?></p>
			  	</div>
			  	<div class="tab-pane fade" id="pills-servicios-fill" role="tabpanel" aria-labelledby="pills-servicios-tab-fill">
					<div class="row">
			     	<?php foreach ($servicios as $s) { ?>
						<div class="col-md-4">
							<div class="iq-card dash-hover-gradient iq-card-block iq-card-stretch iq-card-height" style="outline: 1px #edf1f8 solid;">
								<div class="iq-card-body">
									<h5><i class="fa fa-list-alt" aria-hidden="true"></i> <?=$s['servicio'];?></h5>
									<p class="mb-0"><?=$s['descripcion'];?></p>
								</div>
							</div>
						</div>
			     	<?php } ?>
					</div>
			  	</div>
			  	<div class="tab-pane fade" id="pills-Usuarios-fill" role="tabpanel" aria-labelledby="pills-Usuarios-tab-fill">
					<div class="row">
			     	<?php foreach ($usuarios as $u) { ?>
						<div class="col-md-4">
							<div class="iq-card dash-hover-gradient iq-card-block iq-card-stretch iq-card-height" style="outline: 1px #edf1f8 solid;">
								<div class="iq-card-body">
									<h5><i class="fa fa-user" aria-hidden="true"></i> <?=$u['nombre'];?> <?=$u['apellido'];?></h5>
									<p class="mb-0"><i class="fa fa-phone" aria-hidden="true"></i> <?=$u['telefono'];?></p>
									<p class="mb-0"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?=$u['email'];?></p>
									<p class="mb-0"><i class="fa fa-address-card-o" aria-hidden="true"></i> <?=$u['perfil'];?></p>
								</div>
								<div class="card-action font-size-14 p-3"></div>
							</div>
						</div>
			     	<?php } ?>
			     	</div>
			  	</div>
			</div>
		</div>
	</div>
</div>