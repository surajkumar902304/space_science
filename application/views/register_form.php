<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/style.css">
</head>
<body>
<div class="parent">
<div id="form">
    <h1>User Registration</h1><br><br>
    
    <?php if ($this->session->flashdata('success')): ?>
        <p style="color:green;"><?php echo $this->session->flashdata('success'); ?></p>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <p style="color:red;"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>

    <?php echo validation_errors('<p style="color:red;">', '</p>'); ?>

    <?php echo form_open('user/register'); ?>
    
        
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo set_value('name'); ?>"><br><br><br>
       

      
            <label for="email">Email:</label>
            <input type="text" name="email" value="<?php echo set_value('email'); ?>"><br><br><br>
     

        
            <label for="password">Password:</label>
            <input type="password" name="password"><br><br><br>
        

        
            <input type="submit" class="btn" value="Register">
        
</div>
</div>
    <?php echo form_close(); ?>
</body>
</html>
<!-- <div class="parent">
<div id="form">
    <h1>Register Form</h1>
    <form method="post" action="register.php">
        <label>Username:</label>
        <input type="text" name="user"><br><br>
        <br>
        <label>Password:</label>
        <input type="password" name="pass"><br><br>
        <br>
        <input type="submit" id="btn" name="submit" value="Register"><br><br>
    </form>
    <a href="login.php">Already have an account? Login here</a>
</div>
</div> -->
