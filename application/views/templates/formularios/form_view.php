<!doctype html>
<html lang="en">
  
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

	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine"> -->

	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
    <style>
		.btn-flotante {
			font-size: 16px; /* Cambiar el tamaño de la tipografia */
			text-transform: uppercase; /* Texto en mayusculas */
			font-weight: bold; /* Fuente en negrita o bold */
			color: #ffffff; /* Color del texto */
			border-radius: 5px; /* Borde del boton */
			letter-spacing: 2px; /* Espacio entre letras */
			background-color: #ffdd50; /* Color de fondo */
			padding: 18px 30px; /* Relleno del boton */
			position: fixed;
			bottom: 40px;
			right: 40px;
			transition: all 300ms ease 0ms;
			box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
			z-index: 99;
		}
		.btn-flotante:hover {
			background-color: #ffffff; /* Color de fondo al pasar el cursor */
			box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
			transform: translateY(-7px);
		}
		@media only screen and (max-width: 600px) {
		 	.btn-flotante {
				font-size: 14px;
				padding: 12px 20px;
				bottom: 20px;
				right: 50px;
			}
		}
    </style>
<body>

	<a href="#form-registrate" class="btn-flotante">Regístrate</a>

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

	<div class="" style="background: url(<?=PATH_ASSETS?>images/simposio/portada.jpg) no-repeat; background-size: cover;">
		<div  class="col-md-12 col-sm-12" style="background: url(<?=PATH_ASSETS?>images/simposio/banner.jpg) no-repeat; background-size: cover; height: 48vh;" data-aos="fade-down" data-aos-duration="2000">
			<div class="col-md-12 col-sm-12 pt-3 row">
				<div class="col-md-3"></div>
				<div class="col-md-3"></div>
				<div class="col-md-12" style="text-align: center; font-size: 22px; font-weight: bold; padding-top: 20px; color: #545454;">
					<br><br>
				</div>
			</div>
		</div>
		<div class="col-md-12 col-sm-12 pt-5" data-aos="flip-up" data-aos-duration="2000" style="text-align: center;">
			<h1 class="text-white" style="color: #002e7e; font-weight: bold; font-size: 35px; text-shadow: 1px 1px 2px black;">
				Jornada Académica con temas sobre el Tamiz Neonatal, alcances, <br> así como cifras y números del programa en Yucatán.
			</h1>
		</div>

		<div class="col-md-12 mt-5">			
			<div class="col-md-8 offset-md-2 row" style="color: white; text-align: center;">
				<div class="col-md-6 col-sm-12" data-aos="fade-right" data-aos-duration="3000" style="border: 4px #ffffff solid; background: white; color: #545454; font-weight: bold; height: 42vh;">
					<span class="blockquote" style="font-size: 28px;">
						Tamiz Neonatal, un enfoque integral. Hablemos de una sospecha
						<br>
					</span>
					<p style="font-size: 14px;">
						Dr.Geovanny Ismael Aguilar Canché <br> Supervisor Médico TamizMas
					</p>
				</div>
				<div class="col-md-6 col-sm-12" style="background: url(<?=PATH_ASSETS?>images/simposio/tamiz-1.jpg) no-repeat; background-position: center; background-color: #ffffff; background-size: cover; height: 42vh;"></div>
				<div class="col-md-6 col-sm-12" style="background: url(<?=PATH_ASSETS?>images/simposio/tamiz-2.jpg) no-repeat; background-position: center; background-color: #ffffff; background-size: cover; height: 42vh;"></div>
				<div class="col-md-6 col-sm-12" data-aos="fade-left" data-aos-duration="3000" style="border: 4px #ffffff solid; background: white; color: #545454; font-weight: bold; height: 42vh;">
					<span class="blockquote" style="font-size: 28px;">
						Conferencia magistral: Situación actual del Tamiz Neonatal en Yucatán
						<br>
					</span>
					<p style="font-size: 14px;">
						Dra. Verónica Elizabeth Zaldívar Cortés <br> Subdirectora de Normatividad Médica SSY
					</p>
				</div>
				<div class="col-md-6 col-sm-12" data-aos="fade-right" data-aos-duration="3000" style="border: 4px #ffffff solid; background: white; color: #545454; font-weight: bold; height: 42vh;">
					<span class="blockquote" style="font-size: 28px;">
						Mesa panel: Follow-up de casos tamiz
						<br>
					</span>
					<p style="font-size: 14px;">
						Dra.Jazmín Quiñones <br> Gastroenteróloga Pediatra
					</p>
				</div>
				<div class="col-md-6 col-sm-12" style="background: url(<?=PATH_ASSETS?>images/simposio/tamiz-5.jpg) no-repeat; background-position: center; background-color: #ffffff; background-size: cover; height: 42vh;"></div>
				<div class="col-md-6 col-sm-12" style="background: url(<?=PATH_ASSETS?>images/simposio/tamiz-6.jpg) no-repeat; background-position: center; background-color: #ffffff; background-size: contain; height: 42vh;"></div>
				<div class="col-md-6 col-sm-12" data-aos="fade-right" data-aos-duration="3000" style="border: 4px #ffffff solid; background: white; color: #545454; font-weight: bold; height: 42vh;">
					<span class="blockquote" style="font-size: 28px;">
						Experiencia ejecutivos "Alas"
						<br>
					</span>
					<p style="font-size: 14px;">
						Conversatorio TamizMas
					</p>
				</div>
				<div class="col-md-6 col-sm-12" data-aos="fade-right" data-aos-duration="3000" style="border: 4px #ffffff solid; background: white; color: #545454; font-weight: bold; height: 42vh;">
					<span class="blockquote" style="font-size: 28px;">
						Ictericia ocasionada por mutaciones en el gen UGT1A1
						<br>
					</span>
					<p style="font-size: 14px;">
						Dra.Doris Pinto Escalante <br> Especialista en Genética Médica <br> Hideyo Noguchi / UADY
					</p>
				</div>
				<div class="col-md-6 col-sm-12" style="background: url(<?=PATH_ASSETS?>images/simposio/tamiz-3.jpg) no-repeat; background-position: center; background-color: #ffffff; background-size: cover; height: 42vh;"></div>
				<div class="col-md-6 col-sm-12" style="background: url(<?=PATH_ASSETS?>images/simposio/tamiz-4.jpg) no-repeat; background-position: center; background-color: #ffffff; background-size: cover; height: 42vh;"></div>
				<div class="col-md-6 col-sm-12" data-aos="fade-left" data-aos-duration="3000" style="border: 4px #ffffff solid; background: white; color: #545454; font-weight: bold; height: 42vh;">
					<span class="blockquote" style="font-size: 28px;">
						Avances del tamiz neonatal en el mundo
						<br>
					</span>
					<p style="font-size: 14px;">
						Dra.Marcela Vela Amieva <br> Jefa de Laboratorio de Errores Innatos del Metabolismo. <br> Investigadora del Instituto Nacional de Pediatría.
					</p>
				</div>
			</div>
		</div>
	</div>

	<div class="p-0 col-sm-12" style="background: url(<?=PATH_ASSETS?>images/login/fondo-formulario.jpg) no-repeat; background-size: cover; z-index: 1;">
	   <div class="col-md-12 col-sm-12" style="background-color: rgba(248,225,133, 0.6);">
		   <div class="col-md-12 col-sm-12 p-0 row" data-aos="zoom-in" data-aos-duration="3000" style="z-index: 4;">
	    		<div class="col-md-12 col-sm-12 mt-5 mb-5 row">
	    			<div class="col-md-2 mt-3"></div>
					<div class="col-md-3 mt-3 col-sm-3">
						<img src="<?=PATH_ASSETS?>images/simposio/logo-tamiz.png" alt="<?=PATH_ASSETS?>images/simposio/logo-tamiz.png" style="width: 300px; height: 70px;">
					</div>
	    			<div class="col-md-2 mt-3 col-sm-3"></div>
					<div class="col-md-3 mt-3 col-sm-3">
						<img class="float-left" src="<?=PATH_ASSETS?>images/simposio/logo-uady.png" alt="<?=PATH_ASSETS?>images/simposio/logo-uady.png" style="width: 180px; height: 80px;">
					</div>
	    			<div class="col-md-2"></div>
	    		</div>
				<div class="col-md-12 col-sm-12 mt-3" style="text-align: center;">
					<span class="mt-3 text-white" style="color: #002e7e; font-weight: bold; font-size: 46px; text-shadow: 1px 1px 2px #545454;">Simposio "Tamiz neonatal. Prevenir para salvar vidas"</span>
				</div>
		    	<div class="col-md-8 mt-1" style="border-radius: 5px; text-shadow: 1px 1px 2px black; text-align: center; color: white; font-weight: bold; font-size: 55px;">
		    		<div class="col-md-12 col-sm-12">
						<span>UADY <br> Facultad de Medicina</span>
		    		</div>
		    		<div class="col-md-12 col-sm-12">
						<span>Viernes 29 de septiembre</span>
		    		</div>
		    		<div class="col-md-12 col-sm-12">
						<span>8:00 am a 2:00 pm</span>
		    		</div>
		    	</div>
			   <div class="col-md-4 col-sm-12 mt-1" style="background: #001e43; border-radius: 5px;">
					<h3 class="pt-3 mb-3 text-center" style="color: white; font-weight: bold; text-align: center;">PRE-REGISTRO</h3>
				  	<form class="col-md-12 form-registro mt-4" id="form-registrate" autocomplete="off">
				      <div class="form-group col-md-12" id="form">
				          <label style="color: white; font-weight: bold;" for="nombre">Nombre completo</label>
                		 <input type="hidden" name="participante_id" class="form-control mb-0 participante_id" value="0">
				          <input type="text" name="nombre" class="form-control mb-0" id="nombre" value="" style="background: white; height: 35px;">
				      </div>
				      <div class="form-group col-md-12">
				          <label style="color: white; font-weight: bold;" for="telefono">Whatsapp</label>
				          <input type="text" name="telefono" class="form-control mb-0" id="telefono" value="" style="background: white; height: 35px;">
				      </div>
				      <div class="form-group col-md-12">
				          <label style="color: white; font-weight: bold;" for="correo_electronico">Correo electrónico</label>
				          <input type="text" name="correo_electronico" class="form-control mb-0" id="correo_electronico" value="" style="background: white; height: 35px;">
				      </div>
				      <div class="form-group col-md-12">
				          <label style="color: white; font-weight: bold;" for="universidad">Universidad</label>
				          <input type="text" name="universidad" class="form-control mb-0" id="universidad" value="" style="background: white; height: 35px;">
				      </div>
				      <div class="form-group col-md-12">
				          <label style="color: white; font-weight: bold;" for="carrera">Carrera</label>
				          <input type="text" name="carrera" class="form-control mb-0" id="carrera" value="" style="background: white; height: 35px;">
				      </div>
				      <div class="form-group col-md-12">
				          <label style="color: white; font-weight: bold;" for="area_interes">Área de interés</label>
				          <input type="text" name="area_interes" class="form-control mb-0" id="area_interes" value="" style="background: white; height: 35px;">
				      </div>
				      <div class="form-group col-md-12">
						<div class="form-check-inline">
						  <label style="color: white; font-weight: bold;" class="form-check-label">
						    <input type="radio" name="tipo" class="form-check-input" id="tipo" value="1">Presencial
						  </label>
						</div>
						<div class="form-check-inline">
						  <label style="color: white; font-weight: bold;" class="form-check-label">
						    <input type="radio" name="tipo" class="form-check-input" id="tipo" value="2">En línea
						  </label>
						</div>
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
				      <div class="form-group mt-1 col-md-12">
				         <button type="button" id="button_submit" class="btn btn-danger col-md-12 btn-cons" onclick="validar_form();" style="text-shadow: 1px 1px 2px black;">
				          	<i class="fa fa-paper-plane" aria-hidden="true"></i> Guardar registro
				         </button>
				         <span style="color: #ffffff; font-weight: bold; font-size: 14px; text-shadow: 1px 1px 2px black;">
				         	<!-- Evento gratuito, este pre-registro garantiza tu lugar siempre y cuando acudas puntualmente al evento. -->
				         </span>
				      </div>
				  	</form>
			   </div>
		   </div>
		   <div class="col-md-12 mt-5" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="1000" style="text-align: center;">
		    	<span class="mt-5 text-white" style="color: #002e7e; font-weight: bold; font-size: 24px; text-shadow: 1px 1px 2px black;">
		    		Este pre-registro te permitirá descargar tu constancia posterior al evento.
		    	</span>
		   </div>
	   </div>
	</div>
	<div class="col-md-12" style="background: url(<?=PATH_ASSETS?>images/simposio/portada.jpg) no-repeat; background-size: cover; padding-top: 10px; padding-bottom: 10px;">
		<div class="col-md-12 row">
			<span class="col-md-6" style="color: white; font-weight: bold;">
				© Copyright TamizMas. Todos los derechos reservados 
			</span>
			<span class="col-md-6" style="color: white; font-weight: bold; text-align: right;">
				Desarrollado por el departamento de TICS. 
			</span>
		</div>
	</div>



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

	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

	<script type="text/javascript">
		var base_url = "<?=base_url()?>";
	</script>
	<script src="<?=PATH_VIEW?>js/forms.js"></script>
	<script>
		$(function() {
		    $('#form-login').validate();
		});
	</script>
  	<script>
   	AOS.init();
  	</script>
</body>

</html>