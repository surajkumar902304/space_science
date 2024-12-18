<!doctype html>
<!-- Website template by freewebsitetemplates.com -->
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Space Science Website Template</title>
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/style.css">
	<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/mobile.css">
	<script src="<?= base_url() ?>assets/js/mobile.js" type="text/javascript"></script>
	<style>
		.menu {
			position: relative;
			display: inline-block;
			z
		}

		.secondary{
			display: none;
			position: absolute;
			background-color: #333;
			min-width: 60px;
			z-index: 1;
		}

		#header div ul li.menu ul li a {
			background: none;
		}

		.menu:hover {
			display: block;
		}

		.secondary li{
			color: white;

			text-decoration: none;
			display: block;
		}

		

		.sport_hover li {
			color: white;
			position: relative;
			z-index: 9999;
			background: red;
			width: 50%;
			height: 50%;

		}

		.secondary li:hover {

			width: 100%;
			background-color: #620031;

		}

		.secondary li:hover .main {
			display: flex;

		}






		.menuLi {
			display: block !important;
		}

		.main {
			position: absolute;
			top: 0;
			left: 100%;
			background-color: #333;
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			display: none;
			width: 200px;
		}

		.main .subsubmenu {

			padding: 4px !important;
			width: 100% !important;

		}
	</style>
</head>

<body>
	<div id="page">
		<div id="header">
			<div>
				<a href="<?= base_url() ?>" class="logo"><img src="<?= base_url() ?>assets/images/logo.png" alt=""></a>
				<ul id="navigation">
					<li class="selected">
						<a href="<?= base_url() ?>">Home</a>
					</li>
					<li>
						<a href="<?= base_url() ?>suraj">About</a>
					</li>
					<li class="menu">
						<a href="<?= base_url() ?>projects">Projects</a>
						<ul class="primary">
							<li>
								<a href="<?= base_url() ?>proj1">proj 1</a>
							</li>
						</ul>
					</li>
					<li class="menu">
						<a href="<?= base_url() ?>blogpost">Blog</a>
						<ul class="secondary position-relative">
							<?php
							$CI =& get_instance();
							$CI->load->model('category_model');
							$categories = $CI->category_model->get_categories();
							?>
							<?php foreach ($categories as $category) { ?>
								<li style="width: 100%; color:white" class="menuLi">
									<a href="<?php echo site_url('categorypost/index/' . $category['cat_id']); ?>">
										<?php echo $category['cat_name']; ?>
									</a>
									<div class="main">
										<?php
										$CI->load->model('blog_model');
										$blogs = $CI->blog_model->get_blogs_by_category($category['cat_id']);
										if (!empty($blogs)) {
										?>
										<?php foreach ($blogs as $blog) { ?>
											<div class="subsubmenu">
												<a href="<?php echo site_url('singlepost/view/' . $blog['blog_id']); ?>"><?php echo $blog['title']; ?></a>
											</div>
										<?php } ?>
									</div>
									<?php } ?>
								</li>

							<?php } ?>

						</ul>
					</li>

					<li class="menu">
						<a href="<?= base_url() ?>contact">Contact</a>
					</li>
				</ul>

				</ul>
			</div>
		</div>