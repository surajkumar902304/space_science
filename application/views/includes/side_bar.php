<div class="sidebar">
    <ul>
        <li>
            <h1>FEATURED POSTS</h1>
            <a href="singlepost.html"><img src="<?= base_url() ?>assets/images/moon-satellite.jpg" alt=""></a>
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