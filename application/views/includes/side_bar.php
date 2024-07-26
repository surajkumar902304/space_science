<div class="sidebar">
    <ul>
    
        <li>
        
            <h1>FEATURED POSTS</h1>
            <a class="featured_blog" href="<?php echo site_url('singlepost/view/' . $featured_blog['blog_id']); ?>">
                <img src="<?= base_url() ?>assets/uploads/blog_img/<?php echo $featured_blog['image']; ?>" alt="">
            </a>
            <h2><?php echo $featured_blog['title']; ?></h2>
            <span><?php echo date('F j, Y', strtotime($featured_blog['date'])); ?></span>
        
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