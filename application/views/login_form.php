<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/style.css">
</head>
<body>
<div class="parent">
<div id="form">
    <h1>User Login</h1>
    
    <?php if ($this->session->flashdata('error')): ?>
        <p style="color:red;"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>

    <?php echo validation_errors('<p style="color:red;">', '</p>'); ?>

    <?php echo form_open('user/login'); ?>
        <p>
            <label for="email">Email:</label>
            <input type="text" name="email" value="<?php echo set_value('email'); ?>">
        </p>

        <p>
            <label for="password">Password:</label>
            <input type="password" name="password">
        </p>

        <p>
            <input type="submit" class="btn" value="Login">
        </p>
</div>
</div>
    <?php echo form_close(); ?>
</body>
</html>
