<!DOCTYPE html>
<html>
<head>
    <title>Blogs</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/style.css">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Include FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
<div style="text-align: center; margin-top: 0;">
    <img src="<?= base_url() ?>assets/images/blog_logo.avif" alt="Blog Image" style="display: block; margin: 0 auto; width: 300px;">
</div>

<div class="row">
    
    <div class="col">
    
    <a href="<?php echo site_url('admin/dashboard'); ?>" class="btn btn-secondary ">Dashboard</a>
    <a href="<?php echo site_url('admin/blogs/create_form'); ?>" class="btn btn-primary mb-3 float-right">Create a new blog</a>
</div>
</div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width:20%">Image</th>
                                    <th style="width:20%">Title</th>
                                    <th style="width:15%">Category</th>
                                    <th style="width:20%">Date</th>
                                    <th style="width:18%">Status</th>                                   
                                    <th style="width:18%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; foreach ($blogs as $blog){ ?>    
                                <tr>
                                    
                                    <td><img src="<?php echo base_url('assets/uploads/blog_img/' . $blog['image']); ?>" width="50%" height="50%" class="img-fluid"></td>
                                    <td><?php echo $blog['title']; ?></td>
                                    <td><?php echo $blog['category']; ?></td>
                                    <td><?php echo $blog['date']; ?></td>
                                    <td><?= ($blog['status']=='0')?'Deactive':'Active'; ?></td>                                   
                                    <td>
                                        <a href="<?php echo site_url('admin/blogs/edit/'.$blog['blog_id']); ?>">
                                            <i class="fa fa-pencil-alt fa-lg" aria-hidden="true"></i>
                                        </a>
                                        <?php if ($blog['status'] == 0) { ?>
                                            <a onclick="return confirm('Are you sure you want to Restore this blog?') ? 
                                            window.location.href='<?php echo site_url('admin/blogs/restore/' . $blog['blog_id']); ?>' : false;">
                                                <i class="fa fa-undo fa-lg" aria-hidden="true" style="color: #050505;"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a 
                                            onclick="return confirm('Are you sure you want to Delete this blog?') ? 
                                            window.location.href='<?php echo site_url('admin/blogs/delete/' . $blog['blog_id']); ?>' : false;" 
                                            class="action-btn delete-btn">
                                                <i class="fa fa-trash fa-lg" aria-hidden="true" style="color: #050505;"></i>
                                            </a>
                                        <?php } ?>                                    
                                    </td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
        </div>                          
    
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


</body>
</html>
