<div class="row content">
    <div class="col">

        <div class="card">
            <div class="card-header border-bottom-0 d-flex">
                <a href="<?php echo site_url('movie/create'); ?>" class="ml-auto">New Movie</a>
            </div>

            <div class="card-body p-0 text-center">
<?php echo form_open('movie/change_cinemas/submit'); ?>
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="text-left" style="width: 60%">Title</th>
                            <th scope="col">Cinema</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
<?php if (!$movies): ?>
                        <tr>
                            <td colspan="3">No movies in the database.</td>
                        </tr>
<?php else: foreach ($movies as $movie): ?>
                        <tr>
                            <td class="text-left"><a href="<?php echo site_url("movie/view/{$movie['slug']}"); ?>"><?php echo $movie['title'];?></a></td>
                            <td>
                            <select name='cinema_movie[]'>
                              <?php foreach($cinemas as $cinema): ?>
                                <option value="<?php echo $cinema['id']; echo $movie['id']; ?>" <?php if($cinema['movie_id'] == $movie['movie_id']) echo "selected"; ?>><?php echo $cinema['name']; ?></option>
                              <?php endforeach; ?>
                            </select>
                          </td>
                            <td class="d-flex justify-content-center">
                                <a href="<?php echo site_url("movie/edit/{$movie['slug']}"); ?>" class="d-block mx-2">
                                    <i class="icon fas fa-pencil-alt"></i>
                                </a>
                                <a href="<?php echo site_url("movie/delete/{$movie['slug']}"); ?>" class="d-block mx-2">
                                    <i class="icon fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
<?php endforeach; endif; ?>
                        <tr>
                          <td></td>
                          <td><button type="submit" class="btn btn-primary w-50">Submit</button></td>
                          <td></td>
                        </tr>
                    </tbody>
<?php echo form_close(); ?>
                </table>
            </div>
        </div>

    </div>
</div>
