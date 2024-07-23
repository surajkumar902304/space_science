</style>
<div id="body">
	<div class="header">
		<div>
			<h1>Single Blog</h1>
			<div class="article">
				<?php if ($blog): ?>
            		<img src="<?php echo base_url('assets/uploads/blog_img/' . $blog['image']); ?>"  height="400">
            		<h1><?php echo $blog['title']; ?></h1>
            		<span><?php echo $blog['date']; ?></span>
            		<p><?php echo $blog['long_content']; ?></p>
        		<?php else: ?>
            		<p>No blog found.</p>
        		<?php endif; ?>
			</div>
			<?php include('includes/side_bar.php'); ?>
		</div>
	</div>
</div>

