<!DOCTYPE html>
<html>
<head>
    <title>Edit Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/style.css">
</head>
<body>

<div class="container">
<div style="text-align: left; margin-top: 0;">
    <img src="<?= base_url() ?>assets/images/blog_edit.png" alt="Blog Image" style="margin: 0 auto; width: 100px;">
</div>

    <?php echo validation_errors(); ?>

    
    <form action="<?=base_url("admin/blogs/edit/".$blog['blog_id']);?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
    <label for="image">Image:</label>
        <input type="file" id="image" name="image">
        <?php if (!empty($blog['image'])): ?>
            <div id="currentImage">
                <img src="<?php echo base_url("./assets/uploads/blog_img/".$blog['image']); ?>" alt="Current Image" style="max-width: 100px; max-height: 100px;">
            </div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title', $blog['title']); ?>">
    </div>
    <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" id="category" name="category">
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['cat_name']; ?>" <?php echo set_select('category', $category['cat_name']); ?>>
                        <?php echo $category['cat_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>       
        </div>

    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" class="form-control" id="date" name="date" value="<?php echo set_value('date', $blog['date']); ?>">
    </div>

    <div class="form-group">
        <label for="long_content">Content:</label>
        <textarea class="form-control" id="long_content" name="long_content"><?php echo set_value('long_content', $blog['long_content']); ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Blog</button>
    
    </form>
    <button class="btn btn-warning mt-2" onclick="window.location.href='<?php echo site_url('admin/blogs'); ?>'">
            Back to list
            
        </button>
</div>

</body>
</html>
