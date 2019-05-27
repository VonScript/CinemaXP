<?php
    $role = $this->session->userdata('role');
?>
<div class="content m-4 w-75 d-block justify-content-center">
    <div class="col">
        <div class="card">
            <div class="card-header border-bottom-0 d-flex">
<?php if($role == 1): ?>
                <a href="<?php echo site_url('movie/create'); ?>" class="ml-auto">New Movie</a>
<?php elseif($role == 8): ?>
                <a href="<?php echo site_url('movie/bookseats'); ?>" class="ml-auto">New Booking</a>
<?php endif; ?>
            </div>

            <div class="card-body p-0 text-center">
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="text-left w-25" style="width: 60%"><h5>Movie Information</h5></th>
                            <th scope="col"></th>
<?php if($role == 1): ?>
                            <th scope="col">Actions</th>
<?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left"><h6><?php echo $movie['title']; ?></h6></td>
                            <td></td>
<?php if($role == 1): ?>
                            <td class="d-flex justify-content-center">
                                <a href="<?php echo site_url("movie/edit/{$movie['slug']}"); ?>" class="d-block mx-2">
                                    <i class="icon fas fa-pencil-alt"></i>
                                </a>
                                <a href="<?php echo site_url("movie/delete/{$movie['slug']}"); ?>" class="d-block mx-2">
                                    <i class="icon fas fa-trash"></i>
                                </a>
                            </td>
<?php endif; ?>
                        </tr>
                        <tr>
                            <td class="text-left">Release Date:</td>
                            <td class="text-left"><?php echo $movie['release_date']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Actors:</td>
                            <td class="text-left"><?php echo $movie['actors']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Writers:</td>
                            <td class="text-left"><?php echo $movie['writers']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Directors:</td>
                            <td class="text-left"><?php echo $movie['directors']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Genres:</td>
                            <td class="text-left"><?php echo $movie['categories']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Synopsis:</td>
                            <td class="text-left"><?php echo $movie['text']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Ticket Price:</td>
                            <td class="text-left"><?php echo $movie['price']; ?></td>
                        </tr>
                        <tr>
                            <td><img src="<?php echo base_url($movie['image']); ?>" alt="" class="d-block w-100 mb-3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
