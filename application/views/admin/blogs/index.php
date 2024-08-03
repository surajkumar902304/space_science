<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h1 class="card-title" style="text-align: center;">BLOGS</h1>
            
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:1%">S. No.</th>
                            <th style="width:5%">Image</th>
                            <th style="width:10%">Title</th>
                            <th style="width:10%">Category</th>
                            <th style="width:10%">Date</th>
                            <th style="width:10%">Status</th>                                   
                            <th style="width:15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php $i = 1; foreach ($blogs as $blog){ ?>    
                                <tr>
                                    <td><?php echo "$i" ?></td>
                                    <td><img src="<?php echo base_url('assets/uploads/blog_img/' . $blog['image']); ?>" width="50%" height="50%" class="img-fluid"></td>
                                    <td><?php echo $blog['title']; ?></td>
                                    <td><?php echo $blog['cat_name']; ?></td>
                                    <td><?php echo $blog['date']; ?></td>
                                    <td><?= ($blog['status']=='0')?'Deactive':'Active'; ?></td>                                   
                                    <td>
                                        <a href="<?php echo site_url('admin/blogs/update/'.$blog['blog_id']); ?>">
                                            <i class="fa fa-pencil"></i>
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

