<?php
    $role = $this->session->userdata('role');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>CINEMA XP</title>

        <!-- The Bootstrap CSS file -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="<?php echo base_url('style.css'); ?>">

        <!-- FontAwesome Icons -->
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>
    </head>
    <body>
      <header class="navbar navbar-light align-items-stretch">
          <h2 class="navbar-brand ml-4">CINEMA XP</h2>
          <div class="mr-4">
<?php if($role == 1): ?>
            <a href="<?php echo site_url('movie/index'); ?>" class="p-1">Home</a>
            <a href="<?php echo site_url('movie/movielist'); ?>" class="p-1">Movie List</a>
<?php elseif($role == 8): ?>
            <a href="<?php echo site_url('movie/index'); ?>" class="p-1">Home</a>
            <a href="<?php echo site_url('movie/bookseats'); ?>" class="p-1">New Booking</a>
<?php endif; ?>
            <a href="<?php echo site_url('system/logout'); ?>" class="p-1">Logout</a>
          </div>
      </header>
