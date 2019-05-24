<?php
    $role = $this->session->userdata('role');
?>

<div class="content mt-2">
<?php if (!$movies): ?>
  <div class="card">
      <div class="card-body p-0 text-center">
                  <span colspan="3">No movies in the database.</span>
                </div>
            </div>
<?php else: foreach ($movies as $movie): ?>
                  <div class="d-flex">
                      <div class="d-block w-25 h-25 mb-5">
                          <img src="<?php echo base_url($movie['image']); ?>" alt="" class="w-100">
                      </div>
                      <div class="text-left">
                          <span><a href="<?php echo site_url("movie/view/{$movie['slug']}"); ?>"><?php echo $movie['title']; ?></a></span>
                          <span><?php echo $movie['text']; ?></span>
                      </div>
                  </div>
<?php endforeach; endif; ?>
</div>
