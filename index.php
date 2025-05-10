<?php
// Connect to the database
include('conn.php');

// الحصول على عنوان IP للزائر والتاريخ
$ip_address = $_SERVER['REMOTE_ADDR'];
$today = date("Y-m-d");
$today_hour = date("Y-m-d H:i:s");
$current_year = date("Y");

// التحقق مما إذا كان الزائر قد تم تسجيله اليوم
$sql_check = "SELECT * FROM visitors WHERE ip_address = '$ip_address' AND visit_date = '$today'";
$result = $conn->query($sql_check);

if ($result->num_rows == 0) {
    // إذا لم يكن الزائر مسجلاً اليوم، قم بإضافته
    $sql_insert = "INSERT INTO visitors (ip_address, visit_date) VALUES ('$ip_address', '$today')";
    $conn->query($sql_insert);

    // تحديث عدد الزوار اليومي
    $sql_update_daily = "INSERT INTO daily_visitors (visit_date, visitor_count) 
                         VALUES ('$today', 1) 
                         ON DUPLICATE KEY UPDATE visitor_count = visitor_count + 1";
    $conn->query($sql_update_daily);

    // تحديث عدد الزوار السنوي
    $sql_update_yearly = "INSERT INTO yearly_visitors (visit_year, visitor_count) 
                          VALUES ('$current_year', 1) 
                          ON DUPLICATE KEY UPDATE visitor_count = visitor_count + 1";
	$conn->query($sql_update_yearly);
}

$sql_1 = "SELECT * FROM events";
$result_1 = $conn->query($sql_1);

$sql_2 = "SELECT * FROM about";
$result_2 = $conn->query($sql_2);


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>ASU KFS</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/logo.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body class="animsition">
	
	<!-- Header -->
	<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->		
					<a href="index.html" class="logo">
						<img src="images/LOGO gold2.png" alt="IMG-LOGO">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li data-target="section" class="active-menu">
								<a href="#section">Home</a>
							</li>

							<li data-target="about">
								<a href="#about">About</a>
							</li>

							<li class="label1" data-target="events" data-label1="hot">
								<a href="#events">Events</a>
							</li>

							<li data-target="contact">
								<a href="#contact">Contact</a>
							</li>
						</ul>
					</div>	
				</nav>
			</div>	
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<a href="index.html"><img src="images/LOGO gold2.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="main-menu-m">
				<li>
					<a href="#section">Home</a>
				</li>

				<li>
					<a href="#about">About</a>
				</li>

				<li>
					<a href="#events" class="label1 rs1" data-label1="hot">Event</a>
				</li>

				<li>
					<a href="#contact">Contact</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>
	<!-- Section -->
	<section class="section-slide" id="section">
		<div class="wrap-slick1">
			<div class="slick1">
				<div class="item-slick1" style="background-image: url(images/section-1.jpg);">
				</div>
			</div>
		</div>
	</section>
	<!-- Events Form -->
	<section class="bg0 p-t-23 p-b-140" id="events">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
					Events Forms
				</h3>
			</div>

			<div class="flex-w flex-sb-m p-b-52">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
						All Events
					</button>

					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".scientific">
						Scientific
					</button>

					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".art">
						Art
					</button>

					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".athletic">
						Athletic
					</button>

					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".social">
						Social
					</button>

					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".voyager">
						Voyager
					</button>
					
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".cultural">
						Cultural
					</button>
				</div>
			</div>
			<div class="row isotope-grid">
				<?php
					if (isset($result_1) && $result_1->num_rows > 0) {
						while ($row = $result_1->fetch_assoc()) {
							$is_expired = strtotime($today_hour) > strtotime($row["expiry_time"]); // هل انتهى الحدث؟
							echo '
							<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item ' . htmlspecialchars($row["event_type"]) . '">
								<div class="block2">
									<div class="block2-pic hov-img0">
										<img src="' . htmlspecialchars($row["img_url"]) . '" alt="IMG-PRODUCT">';
										if (!$is_expired) {
											echo '<a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
													Enter Event
												</a>';
										} else {
											echo '<button class="block2-btn flex-c-m stext-103 cl2 size-102 bor2 disabled p-lr-15">
													Event Ended
												</button>';
										};
									echo'
									</div>
									<div class="block2-txt flex-w flex-t p-t-14">
										<div class="block2-txt-child1 flex-col-l">
												' . htmlspecialchars($row["title"]) . '
										</div>
										<div class="block2-txt-child2 flex-r p-t-3">
											' . htmlspecialchars($row["expiry_time"]) . '
										</div>
									</div>
								</div>
							</div>';
						}
					} else {
						echo '
						<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item">
							<div class="block2">
								<div class="block2-txt flex-w flex-t p-t-14">
									<div class="block2-txt-child1 flex-col-l">
										<p class="stext-104 cl4 p-b-6">🚫 No Events Yet</p>
									</div>
								</div>
							</div>
						</div>';
					}
				?>
			</div>
		</div>
	</section>
	<!-- about -->
	<section class="section-slide" id="about">
		<div class="wrap-slick1">
			<div class="slick1">
				<?php
					if (isset($result_2) && $result_2->num_rows > 0) {
						while ($row = $result_2->fetch_assoc()) {
							echo '						
								<div class="item-slick1" style="background-image: url(\'' . htmlspecialchars($row["img_url"]) . '\');">
									<div class="container h-full">
										<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
											<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
												<span class="ltext-101 cl2 respon2">
													' . htmlspecialchars($row["about_header"]) . '
												</span>
											</div>
												
											<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
												<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
													' . htmlspecialchars($row["about_body"]) . ' 
												</h2>
											</div>

											<div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
												<a href="#events" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
													See Now
												</a>
											</div>
										</div>
									</div>
								</div>
							';
						}
					}
				?>
			</div>
		</div>
	</section>

	<!-- start contact-->
	<section class="bg0 p-t-104 p-b-116" id="contact">
		<div class="container">
			<form>
				<h4 class="mtext-105 cl2 txt-center p-b-30">
					Send Us A Message
				</h4>

				<div class="bor8 m-b-20 how-pos4-parent">
					<input class="stext-111 plh3 size-116 p-l-62 p-r-30" type="tel" name="phone_num" id="phone_num" minlength="11" maxlength="11" placeholder="Your Number" required>
					<img class="how-pos4 pointer-none" src="images/icons/icon-email.png" alt="ICON">
				</div>

				<div class="bor8 m-b-30">
					<textarea class="stext-111 plh3 size-120 p-lr-28 p-tb-25" name="msg" placeholder="How Can We Help?" required></textarea>
				</div>

				<button class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
					Submit
				</button>
			</form>
		</div>
	</section>
	<!-- end contact-->

	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Categories
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Women
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Men
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Shoes
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Watches
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Help
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Track Order
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Returns 
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								Shipping
							</a>
						</li>

						<li class="p-b-10">
							<a href="#" class="stext-107 cl7 hov-cl1 trans-04">
								FAQs
							</a>
						</li>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						GET IN TOUCH
					</h4>

					<p class="stext-107 cl7 size-201">
						Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879
					</p>

					<div class="p-t-27">
						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

						<a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-pinterest-p"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Newsletter
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Subscribe
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">
					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-01.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-02.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-03.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-04.png" alt="ICON-PAY">
					</a>

					<a href="#" class="m-all-1">
						<img src="images/icons/icon-pay-05.png" alt="ICON-PAY">
					</a>
				</div>

				<p class="stext-107 cl6 txt-center"> Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made by <a href="https://maok3ak.rf.gd" target="_blank">EssamAboElmgd</a> </p>
			</div>
		</div>
	</footer>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

	<!-- MODAL -->
	<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
    <div class="overlay-modal1 js-hide-modal1"></div>

    <div class="container">
        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
            <!-- زر إغلاق المودال -->
            <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                <img src="images/icons/icon-close.png" alt="CLOSE">
            </button>

            <!-- iframe لعرض الصفحة داخل المودال -->
            <iframe id="modalIframe" src="user_form.php" width="100%" height="500px" frameborder="0"></iframe>
        </div>
    </div>
</div>

<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/slick/slick.min.js"></script>
	<script src="js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script src="vendor/parallax100/parallax100.js"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/sweetalert/sweetalert.min.js"></script>
	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		$('.js-addcart-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});
	
	</script>
<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>