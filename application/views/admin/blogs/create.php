<!DOCTYPE html>
<html>

<head>
    <title>Create Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/style.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
</head>

<body>
    <div class="container">
        <h2>Create a new blog</h2>

        <?php echo validation_errors(); ?>
        




        
       
        <form action="<?=base_url("admin/blogs/create")?>" method="post" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="image">Image URL:</label>
            <input type="file" class="form-control" id="image" name="image" value="<?php echo set_value('image'); ?>">
        </div>
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title'); ?>">
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" id="category" name="category">
                <option value="">Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['cat_id']; ?>" <?php echo set_select('category', $category['cat_name']); ?>>
                        <?php echo $category['cat_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>       
        </div>

        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" class="form-control" id="date" name="date" value="<?php echo set_value('date'); ?>">
        </div>

        <div class="form-group">
        
            <label for="long_content">Content:</label>
            <textarea class="form-control" id="editor" name="long_content"><?php echo set_value('long_content'); ?></textarea>       
       </div>

        <button type="submit" class="btn btn-primary mb-2">Add Blog</button>
        
        

        </form>
        
        <button class="btn btn-warning mt-2" onclick="window.location.href='<?php echo site_url('admin/blogs'); ?>'">
            Go to list        
        </button>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>