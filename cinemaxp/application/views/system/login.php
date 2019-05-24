<?php echo form_open('login/submit', ['class' => 'container-fluid px-4']); ?>
    <div class="col-12 col-md-6 mx-auto py-3">
        <div class="card">
            <div class="card-header">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <?php echo form_error('user-email'); ?>
                <?php echo custom_form_input('Email', [
                    'name'          => 'user-email',
                    'class'         => 'form-control',
                    'placeholder'   => 'me@example.com',
                    'type'          => 'email',
                    'value'         => set_value('user-email')
                ]); ?>

                <?php echo form_error('user-password'); ?>
                <?php echo custom_form_input('Password', [
                    'name'          => 'user-password',
                    'class'         => 'form-control',
                    'placeholder'   => 'password',
                    'type'          => 'password'
                ]); ?>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Login</button>
                <small class="d-block pt-1">
                    or <a href="<?php echo site_url('register'); ?>">register</a>
                </small>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>
