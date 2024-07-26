<div id="body">
    <div class="header">
        <div>
            <h1><?php echo $cat_name; ?></h1>
            <div class="article">
                <ul>
                <?php if (!empty($blogs)) { // Add this check
                    $i = 1; foreach ($blogs as $blog) { 
                        if ($blog['cat_id'] == $cat_id) { 
                ?>
                    <li>
                    <img src="<?php echo base_url('assets/uploads/blog_img/' . $blog['image']); ?>"  height="400">
            		<h1><?php echo $blog['title']; ?></h1>
            		<span><?php echo $blog['date']; ?></span>
            		<p><?php echo $blog['long_content']; ?></p>
                    <a href="<?php echo site_url('singlepost/view/' . $blog['blog_id']); ?>" class="more">Read More</a>
                    </li>
                <?php } $i++; } } else { ?>
                    <p>No blogs found in this category.</p>
                <?php } ?>
                </ul>
            </div>
            <?php include('includes/side_bar.php'); ?>
        </div>
    </div>
</div>