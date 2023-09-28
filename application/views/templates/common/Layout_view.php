<?php $session_usuario = $this->session->userdata('_USER_APP_'); ?>
<?php $permisos = $session_usuario['permisos']; ?>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Distribución integral del sureste</title>
      <!-- Favicon -->
      <link rel="shortcut icon" href="<?=PATH_ASSETS?>images/favicon.ico" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="<?=PATH_ASSETS?>css/bootstrap.min.css">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="<?=PATH_ASSETS?>css/typography.css">
      <!-- Style CSS -->
      <link rel="stylesheet" href="<?=PATH_ASSETS?>css/style.css">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="<?=PATH_ASSETS?>css/responsive.css">
      <!-- LightBox Image CSS -->
      <link rel="stylesheet" href="<?=PATH_ASSETS?>lightbox2-master/dist/css/lightbox.min.css">
      <!-- Select2 CSS -->
      <link rel="stylesheet" href="<?=PATH_ASSETS?>select2/dist/css/select2.min.css">
      <!-- include summernote css/js -->
      <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.css">

      <script>
        var base_url = "../../";
        // var base_url = "<?=base_url();?>";
        var path_assets = "<?=PATH_ASSETS?>";
        var path_image = "<?=base_url();?>assets/images/";
        var PERMISOS = <?=json_encode($permisos)?>;
        var perfil_id = <?=json_encode($session_usuario['perfil_id'])?>;
        var usuario_session_id = <?=json_encode($session_usuario['usuario_id'])?>;
         listar = '';
         agregar = '';
         eliminar = '';
         actualizar = '';
         cambiar_estatus = '';
      </script>
      <!-- Jquery -->
      <script src="<?=PATH_ASSETS?>js/jquery.min.js"></script>
      <!-- Script views and general -->
      <script src="<?=PATH_VIEW?>js/general.js" type="text/javascript"></script>
      <script src="<?=PATH_VIEW?>js/<?=$custom?>.js?v=<?php echo(rand()); ?>" type="text/javascript"></script>
   </head>
   <style>
      table{
         font-size: 13px !important;
      }
   </style>
   <body>
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
            <div class="loader">
               <div class="cube">
                  <div class="sides">
                     <div class="top"></div>
                     <div class="right"></div>
                     <div class="bottom"></div>
                     <div class="left"></div>
                     <div class="front"></div>
                     <div class="back"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- loader END -->
      <!-- Wrapper Start -->
      <div class="wrapper">
        
         <?php $this->load->view('templates/common/Menu_view'); ?>

         <?php $this->load->view('templates/common/Header_view'); ?>

         <div id="content-page" class="content-page">
            <div class="container-fluid">
               <!-- <button type="button" onclick="mostrar_notificacion();">mostrar_notificacion</button> -->
            <?php $this->load->view('templates/' . $content); ?>
            </div>
         </div>

      </div>
      <!-- Wrapper END -->

      <?php $this->load->view('templates/common/Footer_view'); ?>

      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="<?=PATH_ASSETS?>js/popper.min.js"></script>
      <script src="<?=PATH_ASSETS?>js/bootstrap.min.js"></script>
      <!-- Appear JavaScript -->
      <script src="<?=PATH_ASSETS?>js/jquery.appear.js"></script>
      <!-- Countdown JavaScript -->
      <script src="<?=PATH_ASSETS?>js/countdown.min.js"></script>
      <!-- Counterup JavaScript -->
      <script src="<?=PATH_ASSETS?>js/waypoints.min.js"></script>
      <script src="<?=PATH_ASSETS?>js/jquery.counterup.min.js"></script>
      <!-- Wow JavaScript -->
      <script src="<?=PATH_ASSETS?>js/wow.min.js"></script>
      <!-- Apexcharts JavaScript -->
      <script src="<?=PATH_ASSETS?>js/apexcharts.js"></script>
      <!-- Slick JavaScript -->
      <script src="<?=PATH_ASSETS?>js/slick.min.js"></script>
      <!-- Select2 JavaScript -->
      <script src="<?=PATH_ASSETS?>js/select2.min.js"></script>
      <!-- Owl Carousel JavaScript -->
      <script src="<?=PATH_ASSETS?>js/owl.carousel.min.js"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="<?=PATH_ASSETS?>js/jquery.magnific-popup.min.js"></script>
      <!-- Smooth Scrollbar JavaScript -->
      <script src="<?=PATH_ASSETS?>js/smooth-scrollbar.js"></script>
      <!-- lottie JavaScript -->
      <script src="<?=PATH_ASSETS?>js/lottie.js"></script>
      <!-- Chart Custom JavaScript -->
      <script src="<?=PATH_ASSETS?>js/chart-custom.js"></script>
      <!-- Custom JavaScript -->
      <script src="<?=PATH_ASSETS?>js/custom.js"></script>
      <!-- Script lightbox JS -->
      <script src="<?=PATH_ASSETS?>lightbox2-master/dist/js/lightbox.js"></script>
      <!-- Script Select2 JS -->
      <script src="<?=PATH_ASSETS?>select2/dist/js/select2.min.js"></script>

      <!-- <script src="<?=PATH_ASSETS?>faceApi/face-api.min.js"></script> -->

      <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
      <!-- Latest compiled and minified JavaScript -->
      <script src="https://unpkg.com/multiple-select@1.5.2/dist/multiple-select.min.js"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
      <!-- fullcalendar -->
      <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   </body>

</html>
