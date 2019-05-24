<?php echo form_open('register/submit', ['class' => 'container-fluid px-4']); ?>
    <div class="col-12 col-md-6 mx-auto py-3">
        <div class="card">
            <div class="card-header">
                <h3>Register</h3>
            </div>
            <div class="card-body">
                <h5 class="mb-3">Account Information</h5>
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

                <?php echo form_error('user-conf-password'); ?>
                <?php echo custom_form_input('Confirm Password', [
                    'name'          => 'user-conf-password',
                    'class'         => 'form-control',
                    'placeholder'   => 'confirm password',
                    'type'          => 'password'
                ]); ?>

                <h5 class="mb-3 mt-4">Personal Details</h5>
                <?php echo form_error('user-name'); ?>
                <?php echo custom_form_input('Name', [
                    'name'          => 'user-name',
                    'class'         => 'form-control',
                    'placeholder'   => 'John',
                    'value'         => set_value('user-name')
                ]); ?>

                <?php echo form_error('user-surname'); ?>
                <?php echo custom_form_input('Surname', [
                    'name'          => 'user-surname',
                    'class'         => 'form-control',
                    'placeholder'   => 'Borg',
                    'value'         => set_value('user-surname')
                ]); ?>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Register</button>
                <small class="d-block pt-1">
                    or <a href="<?php echo site_url('login'); ?>">login</a>
                </small>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>
