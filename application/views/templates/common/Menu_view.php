 <!-- Sidebar  -->
 <div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
       <a href="Dashboard">
       <img src="<?=PATH_ASSETS?>images/logo-1.png" class="img-fluid" alt="">
       <!-- <span style="font-size: 22px; font-weight: bold; color: #e4783e;">AMG </span> <span style="font-size: 22px; font-weight: bold; color: #001b54;">Desarrollos </span> -->
       </a>
       <div class="iq-menu-bt align-self-center">
          <div class="wrapper-menu">
             <div class="line-menu half start"></div>
             <div class="line-menu"></div>
             <div class="line-menu half end"></div>
          </div>
       </div>
    </div>
    <div id="sidebar-scrollbar">
       <nav class="iq-sidebar-menu">
          <ul id="iq-sidebar-toggle" class="iq-menu">
             <li class="iq-menu-title"><i class="ri-separator"></i><span>Menú</span></li>

            <?php if (have_permission('Dashboard-List')){ ?>
             <li>
                <a href="<?=base_url();?>Dashboard" class="iq-waves-effect"><i class="fa fa-users" aria-hidden="true"></i><span>Participantes</span></a>
             </li>
            <?php } ?>

            <li>
               <a href="#administrador" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="false"><i class="ri-settings-2-fill"></i><span>Configuraciones</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
               <ul id="administrador" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                   <?php if (have_permission('Departamentos-List')){ ?>
                   <li>
                      <a href="<?=base_url();?>Departamentos" class="iq-waves-effect"><i class="ri-building-fill"></i><span>Departamentos</span></a>
                   </li>
                  <?php } ?>

                  <?php if(have_permission('Usuarios-List')){ ?>
                   <li>
                      <a href="<?=base_url();?>Usuarios"><i class="ri-user-3-fill"></i><span>Usuarios</span></a>
                   </li>
                  <?php } ?>

                  <?php if(have_permission('Empresas-List')){ ?>
                   <li>
                      <a href="<?=base_url();?>Empresas"><i class="ri-building-2-fill"></i><span>Empresas</span></a>
                   </li>
                  <?php } ?>

                  <?php if(have_permission('Permisos-List')){ ?>
                   <li>
                      <a href="<?=base_url();?>Permisos"><i class="ri-door-lock-fill"></i><span>Permisos</span></a>
                   </li>
                  <?php } ?>
                  <?php if(have_permission('Indicadores-List')){ ?>
                   <li>
                      <a href="<?=base_url();?>Indicadores"><i class="ri-bar-chart-fill"></i><span>Indicadores</span></a>
                   </li>
                  <?php } ?>
               </ul>
            </li>
          </ul>
       </nav>
       <div class="p-3"></div>
    </div>
 </div>