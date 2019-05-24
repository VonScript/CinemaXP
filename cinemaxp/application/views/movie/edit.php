<?php echo form_open_multipart("movie/edit/{$movie['slug']}/submit", ['class' => 'row content']); ?>
    <div class="col-12 col-lg-9">
        <div class="card">
            <div class="card-body">
                <?php echo form_error('movie-title'); ?>
                <?php echo custom_form_input('Title', [
                    'name'          => 'movie-title',
                    'class'         => 'form-control',
                    'placeholder'   => 'movie Title',
                    'value'         => $movie['title'] ?: set_value('movie-title')
                ]); ?>

                <?php echo form_error('movie-release-date'); ?>
                <?php echo custom_form_input('Release Date', [
                    'name'          => 'movie-release-date',
                    'class'         => 'form-control',
                    'placeholder'   => 'dd/mm/yyyy',
                    'value'         => $movie['release_date'] ?: set_value('movie-release-date')
                ]); ?>

                <?php echo form_error('movie-rating'); ?>
                <?php echo custom_form_input('Rating', [
                    'name'          => 'movie-rating',
                    'class'         => 'form-control',
                    'placeholder'   => 'Rating',
                    'value'         => $movie['rating'] ?: set_value('movie-rating')
                ]); ?>

                <?php echo form_error('movie-actors'); ?>
                <?php echo custom_form_input('Actors', [
                    'name'          => 'movie-actors',
                    'class'         => 'form-control',
                    'placeholder'   => 'Name the stars of this movie',
                    'value'         => $movie['actors'] ?: set_value('movie-actors')
                ]); ?>

                <?php echo form_error('movie-writers'); ?>
                <?php echo custom_form_input('Writers', [
                    'name'          => 'movie-writers',
                    'class'         => 'form-control',
                    'placeholder'   => 'Name the writers of this movie',
                    'value'         => $movie['writers'] ?: set_value('movie-writers')
                ]); ?>

                <?php echo form_error('movie-directors'); ?>
                <?php echo custom_form_input('Directors', [
                    'name'          => 'movie-directors',
                    'class'         => 'form-control',
                    'placeholder'   => 'Name the director/s of this movie',
                    'value'         => $movie['directors'] ?: set_value('movie-directors')
                ]); ?>

                <?php echo form_error('movie-text'); ?>
                <?php echo form_textarea([
                    'rows'          => 8,
                    'cols'          => 80,
                    'name'          => 'movie-text',
                    'placeholder'   => 'This is the start of your next work!',
                    'class'         => 'form-control mb-3',
                    'value'         => $movie['text'] ?: set_value('movie-text')
                ]); ?>

                <?php echo form_error('movie-price'); ?>
                <?php echo custom_form_input('Ticket Price', [
                    'name'          => 'movie-price',
                    'class'         => 'form-control',
                    'placeholder'   => '00.00',
                    'value'         => $movie['price'] ?: set_value('movie-price')
                ]); ?>

                <img src="<?php echo base_url($movie['image']); ?>" alt="" class="d-block w-100 mb-3">

                <?php echo form_error('movie-image'); ?>
                <?php echo custom_form_upload('Choose Image', [
                    'type'          => 'file',
                    'name'          => 'movie-image',
                    'accept'        => 'image/*'
                ]); ?>
                <small>Upload a new image to replace the current one.</small>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-3 mt-3 mt-lg-0">
        <div class="card">
            <div class="card-body">
                <?php echo form_multiselect(
                    'movie-categories[]',
                    $categories,
                    $movie['categories'] ?: set_value('movie-categories'),
                    [
                        'class' => 'custom-select form-control',
                        'size'  => count($categories)
                    ]
                ); ?>

                <small class="d-block mt-1 mb-3"><?php echo ($platform == 'mac os x') ? 'Cmd' : 'Ctrl'; ?>-click to select multiple options.</small>

                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>
