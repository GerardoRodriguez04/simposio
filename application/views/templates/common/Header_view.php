     <!-- TOP Nav Bar -->
     <div class="iq-top-navbar">
        <div class="iq-navbar-custom">
           <div class="iq-sidebar-logo">
              <div class="top-logo">
                 <a href="Dashboard" class="logo">
                 <img src="<?=PATH_ASSETS?>images/logo-1.png" class="img-fluid" alt="">
                 <!-- <span style="font-size: 22px; font-weight: bold; color: #e4783e;">AMG </span> <span style="font-size: 22px; font-weight: bold; color: #001b54;">Desarrollos </span> -->
                 </a>
              </div>
           </div>
           <div class="navbar-breadcrumb">
              <h5 class="mb-0"><?=$title?></h5>
              <nav aria-label="breadcrumb">
                 <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=$controller?>"><?=$sub_title?></a></li>
                 </ul>
              </nav>
           </div>
           <nav class="navbar navbar-expand-lg navbar-light p-0">
              <div class="iq-menu-bt align-self-center">
                 <div class="wrapper-menu">
                    <div class="line-menu half start"></div>
                    <div class="line-menu"></div>
                    <div class="line-menu half end"></div>
                 </div>
              </div>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                 <ul class="navbar-nav ml-auto navbar-list">
                    <li class="nav-item">
                       <a href="javascript:void(0);" onclick="get_notificaciones();" class="search-toggle iq-waves-effect icon-notificaciones"></a>
                       <div class="iq-sub-dropdown">
                          <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow-none m-0">
                             <div class="iq-card-body p-0 ">
                                <div class="bg-danger p-3">
                                   <span class="mb-0 text-white">Notificaciones</span>
                                </div>
                                <div class="div-notificaciones" style="overflow-y: scroll; height: 300px;"></div>
                             </div>
                          </div>
                       </div>
                    </li>
                    <li class="nav-item">
                       <a href="javascript:void(0);" class="" style="cursor: default;"></a>
                    </li>
                    <li class="nav-item">
                       <a href="javascript:void(0);" class="" style="cursor: default;"></a>
                    </li>
                 </ul>
              </div>
              <ul class="navbar-list">
                 <li>
                  <?php if(!empty($_SESSION['_USER_APP_']['nombre'])){$primera_inicial = $_SESSION['_USER_APP_']['nombre'];}else{$primera_inicial[0] = '';} ?>
                  <?php if(!empty($_SESSION['_USER_APP_']['apellido'])){$segunda_inicial = $_SESSION['_USER_APP_']['apellido'];}else{$segunda_inicial[0] = '';} ?>

                    <a href="javascript:void(0);" class="search-toggle iq-waves-effect bg-primary text-white">
                      <i class="ri-shield-user-fill"></i> <?= $primera_inicial[0].$segunda_inicial[0]; ?>
                    </a>
                    <div class="iq-sub-dropdown iq-user-dropdown">
                       <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow-none m-0">
                          <div class="iq-card-body p-0 ">
                             <div class="bg-primary p-3">
                                <h5 class="mb-0 text-white line-height">Bienvenido <?=$_SESSION['_USER_APP_']['nombre'].' '.$_SESSION['_USER_APP_']['apellido']; ?></h5>
                                <span class="text-white font-size-12">Perfil: <?= $_SESSION['_USER_APP_']['perfil']; ?></span>
                                <br>
                                <?php foreach ($_SESSION['_USER_APP_']['departamentos'] as $d) { ?>
                                <span class="text-white font-size-12">Departamento: <?= $d['departamento']; ?></span><br>
                                <?php } ?>
                             </div>
                             <a href="usuarios/perfil_view/<?=$_SESSION['_USER_APP_']['usuario_id'];?>" class="iq-sub-card iq-bg-primary-hover">
                                <div class="media align-items-center">
                                   <div class="rounded iq-card-icon iq-bg-primary">
                                      <i class="ri-file-user-line"></i>
                                   </div>
                                   <div class="media-body ml-3">
                                      <h6 class="mb-0 ">Mi Perfil</h6>
                                      <p class="mb-0 font-size-12">Ver los detalles.</p>
                                   </div>
                                </div>
                             </a>
                             <div class="d-inline-block w-100 text-center p-3">
                                <a class="iq-bg-danger iq-sign-btn" href="auth/logout" role="button">Cerrar Sesión<i class="ri-login-box-line ml-2"></i></a>
                             </div>
                          </div>
                       </div>
                    </div>
                 </li>
              </ul>
           </nav>
        </div>
     </div>
     <!-- TOP Nav Bar END -->