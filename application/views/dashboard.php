<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Add your CSS files here -->
</head>
<body>
    <h1>Welcome to your Dashboard, <?php echo $this->session->userdata('name'); ?>!</h1>
    <p>Email: <?php echo $this->session->userdata('email'); ?></p>
    <p><a href="<?php echo site_url('user/logout'); ?>">Logout</a></p>
</body>
</html>
