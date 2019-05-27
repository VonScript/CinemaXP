<?php $user_id = $this->session->userdata('id'); ?>
<?php echo form_open('movie/bookseats/submit'); ?>
<div class="row content">
    <div class="col">
        <div class="card">
            <div class="card-body p-0 text-center">
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="text-left" style="width: 60%">Book Your Seats</th>
                            <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td>
                          <?php echo form_error('movie-viewing'); ?>
                          <label class="text-left">Movie:</label>
                          <select name='movie-viewing' class="text-left">
                            <?php foreach($movie as $film): ?>
                              <option value="<?php echo $film['id']; echo $film['movie_id']; ?>"><?php echo $film['title']; ?></option>
                            <?php endforeach; ?>
                          </select>
                          </td>
                        </tr>
                          <tr>
                            <td>
                              <?php echo form_error('movie-showtime'); ?>
                            <label class="text-left">Showtimes:</label>
                            <select name='movie-showtime' class="text-left">
                              <?php foreach($showtimes as $show): ?>
                                <option value="<?php echo $show['id']; ?>"><?php echo $show['info']; ?></option>
                              <?php endforeach; ?>
                            </select>
                            </td>
                          </tr>
                          <tr>
                            <td>
                          <?php echo form_error('movie-seats'); ?>
                          <label class="text-left">Seats:</label><br>
                            <?php foreach($rows as $row): ?>
                              <?php echo $row['info']; ?>
                              <?php foreach($columns as $col): ?>
                              <?php echo $col['info']; ?>
                              <input type="checkbox" name="movie-seats[]" value="<?php echo $row['id']; echo $col['id']; ?>">
                            <?php endforeach; ?>
                            <?php echo "<br>"; ?>
                          <?php endforeach; ?>
                        </td>
                          </tr>
                        <tr>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary w-25">Submit</button>
            </div>
        </div>

    </div>
</div>
<?php echo form_close(); ?>
