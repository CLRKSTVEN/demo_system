<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('includes/title.php'); ?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<!--===============================================================================================-->
	<link rel="icon" type="<?= base_url(); ?>assets/image/ico" href="<?= base_url(); ?>assets/images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/main.css">
	<!--===============================================================================================-->

	<style>
		/* Fix for autofill styling */
		input:-webkit-autofill,
		input:-webkit-autofill:focus,
		input:-webkit-autofill:hover,
		input:-webkit-autofill:active {
			-webkit-box-shadow: 0 0 0 30px #fff8c6 inset !important;
			box-shadow: 0 0 0 30px #fff8c6 inset !important;
			-webkit-text-fill-color: #000 !important;
		}

		/* Force floating label to move up when autofilled */
		input:-webkit-autofill~.focus-input100,
		input:-webkit-autofill~.label-input100 {
			top: -15px;
			font-size: 12px;
			color: #999999;
		}

		/* Keep the login layout flush with the top so the scrollbar doesn't reveal a header band */
		html,
		body {
			background-color: #f2f2f2;
			scrollbar-width: none;
		}

		body {
			-ms-overflow-style: none;
		}

		html::-webkit-scrollbar,
		body::-webkit-scrollbar {
			display: none;
		}
.container-login100 {
    padding-bottom: 0 !important;
}
	</style>

</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">


				<form action="<?php echo site_url('Login/auth'); ?>" method="post" class="login100-form validate-form">
					<?php if ($this->session->flashdata('success')) : ?>

						<?= '<div class="alert alert-success alert-dismissible fade show" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>'
							. $this->session->flashdata('success') .
							'</div>';
						?>
					<?php endif; ?>

					<?php if ($this->session->flashdata('danger')) : ?>
						<?= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>'
							. $this->session->flashdata('danger') .
							'</div>';
						?>
					<?php endif;  ?>
					<span class="login100-form-title p-b-43"></span>
					<span class="login100-form-title p-b-43">
						<img src="<?= base_url(); ?>upload/banners/<?php echo $data[0]->login_form_image; ?>" alt="mySRMS Portal" width="40%">
					</span>


					<div class="wrap-input100 validate-input" data-validate="Username is required">
						<input class="input100" type="text" name="username">
						<span class="focus-input100"></span>
						<span class="label-input100">Username</span>
					</div>


					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<!-- <div class="wrap-input100 validate-input" data-validate="School Year is required.  Example: 2020-2021">
						<input class="input100" type="text" name="sy" value="<?php echo isset($active_sy) ? $active_sy : ''; ?>">

						<span class="focus-input100"></span>
						<span class="label-input100">School Year</span>
					</div> -->


					<input class="input100" type="hidden" name="sy" value="<?php echo isset($active_sy) ? $active_sy : ''; ?>">


					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center p-t-46 p-b-20">
						<!--<span class="txt2">
							<a href="<?= base_url(); ?>Login/registration">Create an Account</a>
						</span>  |  -->
						<span>
							<a href="#" data-toggle="modal" data-target="#forgotModal" class="txt1">
								Forgot Password
							</a>
						</span>
					</div>


				</form>

				<div class="login100-more" style="background-image: url('<?= base_url(); ?>upload/banners/<?php echo $data[0]->loginFormImage; ?>');">


				</div>
			</div>
		</div>
	</div>





	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/popper.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/js/main.js"></script>
	<script>
		// Snap the login page to the bottom so the top band stays hidden on load
		(function() {
			var isSnapping = false;

			function scrollToBottom() {
				var bottomPosition = getBottomPosition();
				if (bottomPosition <= 0) {
					return;
				}

				isSnapping = true;
				window.scrollTo({
					top: bottomPosition,
					behavior: 'auto'
				});
				setTimeout(function() {
					isSnapping = false;
				}, 0);
			}

			function getBottomPosition() {
				var fullHeight = Math.max(
					document.body.scrollHeight,
					document.documentElement.scrollHeight
				);
				return Math.max(fullHeight - window.innerHeight, 0);
			}

			function lockAtBottom(event) {
				if (isSnapping) {
					return;
				}

				var bottomPosition = getBottomPosition();
				if (bottomPosition <= 0) {
					return;
				}

				if (window.scrollY < bottomPosition) {
					if (event && typeof event.preventDefault === 'function') {
						event.preventDefault();
					}
					scrollToBottom();
				}
			}

			window.addEventListener('load', function() {
				setTimeout(scrollToBottom, 150);
			});

			window.addEventListener('pageshow', function(evt) {
				if (evt.persisted) {
					setTimeout(scrollToBottom, 50);
				}
			});

			window.addEventListener('resize', function() {
				setTimeout(scrollToBottom, 0);
			});

			window.addEventListener('scroll', lockAtBottom);

			window.addEventListener('wheel', function(event) {
				if (event.deltaY < 0) {
					lockAtBottom(event);
				}
			}, {
				passive: false
			});

			window.addEventListener('touchmove', function(event) {
				lockAtBottom(event);
			}, {
				passive: false
			});
		})();
	</script>

</body>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="forgotModalLabel" style="color:black">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="forgotModalLabel">Forgot Password</h4>
			</div>
			<div class="modal-body">
				<form id="resetPassword" name="resetPassword" method="post" action="<?php echo base_url(); ?>login/forgot_pass" onsubmit='return validate()'>
					<div class="input-group mb-3">
						<input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<input type="submit" value="Request a New Password" class="btn btn-primary btn-block name=" forgot_pass">
						</div>
						<!-- /.col -->
					</div>
				</form>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
</div>
<!-- End Forgot Password Modal -->

</html>