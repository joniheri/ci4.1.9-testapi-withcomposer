<?php
echo view('template-bootstrap5/head');
echo view('template-bootstrap5/navbar');
?>

<div class="container">
  <div class="row mt-4">
    <div class="col-md-4 col-md-offset-4">
      <h4>Form Register</h4>
      <hr>
      <form action="<?= base_url('auth/processRegister') ?>" method="POST">
        <?= csrf_field() ?>

        <!-- NotifAddSuccessOrFailed -->
        <?php
        if (isset($message)) {
          echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        } elseif (isset($registerSucces)) {
          echo '<div class="alert alert-success" role="alert">' . $registerSucces . '</div>';
        }
        ?>
        <!-- End NotifAddSuccessOrFailed -->

        <div class="form-group mb-3">
          <label for="" class="mb-1">Username</label>
          <input type="text" class="form-control" name="username" placeholder="Enter your username" value="<?= isset($registerSucces) ? '' : set_value('username') ?>" <?= isset($validation) && display_error($validation, 'username') ? 'autofocus' : '' ?> <?= isset($message) || isset($registerSucces) ? 'autofocus' : '' ?>>
          <span class="text-danger"><?= isset($validation) ? display_error($validation, 'username') : '' ?></span>
        </div>
        <div class="form-group mb-3">
          <label for="" class="mb-1">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Enter your password" value="<?= isset($registerSucces) ? '' : set_value('password') ?>" <?= isset($validation) && display_error($validation, 'password') ? 'autofocus' : '' ?>>
          <span class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : '' ?></span>
        </div>
        <div class="form-group mb-3">
          <label for="" class="mb-1">Confirm Password</label>
          <input type="password" class="form-control" name="cpassword" placeholder="Enter your password" value="<?= isset($registerSucces) ? '' : set_value('cpassword') ?>" <?= isset($validation) && display_error($validation, 'cpassword') ? 'autofocus' : '' ?>>
          <span class="text-danger"><?= isset($validation) ? display_error($validation, 'cpassword') : '' ?></span>
        </div>
        <div class="form-group mb-3">
          <button class="btn btn-primary w-100" type="submit">Register</button>
        </div>
        <div class="form-group  mb-3">
          <a href=""></a>
        </div>
        <div class="form-group  mb-3">
          <a href="/login" style="text-decoration: none;">Already have an account, click here</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(1000, function() {
        $(this).remove();
      });
    }, 4000);

  });
</script>

<?= view('template-bootstrap5/foot'); ?>