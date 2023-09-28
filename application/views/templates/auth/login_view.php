<!doctype html>
<html lang="en">
   
<!-- Mirrored from iqonic.design/themes/sofbox-admin/html/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 23 Nov 2020 02:04:39 GMT -->
<head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Simposio</title>
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
   </head>
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
        <!-- Sign in Start -->
        <section class="sign-in-page bg-white">
            <div class="container-fluid p-0">
                <div class="row no-gutters">
                    <div class="col-sm-6 align-self-center">
                        <div class="sign-in-from">
                            <h1 class="mb-0">Iniciar Sesión</h1>
                            <p>Ingrese su usuario y contraseña para acceder al sistema.</p>
                            <form class="mt-4" id="form-login">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Usuario</label>
                                    <input type="email" name="email" class="form-control mb-0" id="exampleInputEmail1" placeholder="Enter email" value="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Contraseña</label>
                                    <input type="password" name="password" class="form-control mb-0" id="exampleInputPassword1" placeholder="Password" value="">
                                </div>
                                <div class="d-inline-block w-100">
                                    <button type="button" id="button_submit" class="btn btn-primary float-right btn-cons">Entrar</button>
                                </div>
                                <div class="d-inline-block w-100">
                                  <ul>
                                    <br>
                                  </ul>
                                </div>
                               <div class="alert alert-danger" role="alert" style="display: none;">
                                  <div class="iq-alert-icon">
                                     <i class="ri-information-line"></i>
                                  </div>
                                  <div class="iq-alert-text text-alert"></div>
                               </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="sign-in-detail text-white" style="background: url(<?=PATH_ASSETS?>images/login/logo_inicio.jpg) no-repeat; background-size: cover; height: 100vh; padding-top: 22%; opacity: 0.9;">
                            <!-- <span style="font-size: 45px; text-align: center; text-transform: uppercase; color: #19574e; font-weight: bold;"> ADMINISTRADOR</span> -->
                            <!-- <a class="sign-in-logo mb-5 text-center" href="#"><img src="<?=PATH_ASSETS?>images/logo-1.png" class="img-fluid" alt="logo" style="padding: 8px 8px 8px 8px; width: 300px; height: 135px;"></a> -->
                            <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
                                <div class="item" style="padding-top: 32%;">
                                    <!-- <img src="<?=PATH_ASSETS?>images/login/5.jpg" class="img-fluid mb-4" alt="logo"> -->
                                    <span class="float-right" style="color: #19574e">Copyright © DQMedica Integral <?= date('Y'); ?> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- Sign in END -->
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->

      <script src="<?=PATH_ASSETS?>js/jquery.min.js"></script>
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
      <!-- Chart Custom JavaScript -->
      <script src="<?=PATH_ASSETS?>js/chart-custom.js"></script>
      <!-- Custom JavaScript -->
      <script src="<?=PATH_ASSETS?>js/custom.js"></script>
      <!-- js Validation -->
      <script src="<?=PATH_ASSETS?>jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>

      <script type="text/javascript">
        var base_url = "<?=base_url()?>";
      </script>
      <script src="<?=PATH_VIEW?>js/auth.js"></script>
      <script>
        $(function() {
            $('#form-login').validate();
        })
      </script>
   </body>

<!-- Mirrored from iqonic.design/themes/sofbox-admin/html/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 23 Nov 2020 02:04:45 GMT -->
</html>