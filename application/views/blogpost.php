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
			<div class="sidebar">
				<ul>
					<li>
						<h1>FEATURED POSTS</h1>
						<a href="singlepost.html"><img src="<?= base_url() ?>assets/images/moon-satellite.jpg"
								alt=""></a>
						<h2>SOYUZ TMA-M</h2>
						<span>FEBRUARY 6, 2023</span>
					</li>
					<li>
						<h1>RECENT Blogs</h1>
						<ul>
            				<?php foreach ($recent_blog as $blog): ?>
                			<li>
                    			<a class="recent_blog" href="<?= site_url('singlepost/view/' . $blog['blog_id']); ?>">
                        			<img src="<?= base_url('assets/uploads/blog_img/' . $blog['image']); ?>" height="50">
                    			</a>
                    				<h2><?= $blog['title']; ?></h2>
                    				<span><?= date('F d, Y', strtotime($blog['date'])); ?></span>
                			</li>
            				<?php endforeach; ?>
        				</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>