<div class="row content">
    <div class="col">
Booking
        <div class="card">
            <div class="card-body p-0 text-center">
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="text-left" style="width: 60%">Title</th>
                            <th scope="col">Date</th>
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
                            <td class="text-left"><a href="<?php echo site_url("movie/view/{$movie['slug']}"); ?>"><?php echo $movie['title']; ?></a></td>
                            <td>No date</td>
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
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
