<?php
    $role = $this->session->userdata('role');
?>

<div class="content m-4 w-75 d-block justify-content-center">
<?php if (!$movies): ?>
  <div class="card">
      <div class="card-body p-0 text-center">
          <span colspan="3">No movies in the database.</span>
      </div>
  </div>
<?php else: foreach ($movies as $movie): ?>
  <div class="d-block row p-2">
    <div class="border border-secondary">
      <div class="p-2">
     <h4 class="d-block w-100 p-2"><?php echo $movie['cinema']; ?></h4>
      <div class="d-flex text-center">
        <div class="d-block mb-5 w-25 p-2">
            <img src="<?php echo base_url($movie['image']); ?>" alt="" class="w-100">
        </div>
        <div class="text-left p-4 w-75">
            <h4 class="d-block"><a href="<?php echo site_url("movie/view/{$movie['slug']}"); ?>"><?php echo $movie['title']; ?></a></h4>
            <span class="d-block"><?php echo $movie['text']; ?></span>
        </div>
      </div>
    </div>
    </div>
  </div>
<?php endforeach; endif; ?>
</div>
