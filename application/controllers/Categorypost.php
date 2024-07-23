<div id="body">
	<div class="header">
		<div>
			<h1>Blogs</h1>
			<div class="article">
				<ul>
				<?php $i = 1; foreach ($blogs as $blog){ ?>
					<li>
						
						<img src="<?php echo base_url('assets/uploads/blog_img/' . $blog['image']); ?>" width="1000" height="400" class="img-fluid">
						
						<h1><?php echo $i.")  ".$blog['title']; ?></h1>
						<span><?php echo "Post Date : ".$blog['date']; ?></span>
						<p><?php echo $blog['long_content']; ?></p>
						<a href="<?php echo site_url('singlepost/view/' . $blog['blog_id']); ?>" class="more">Read More</a>
					</li>
					
					<?php $i++; } ?>
				</ul>
			</div>
			
			<?php include('includes/side_bar.php'); ?>
		</div>
	</div>
</div>