<?php
echo view('template-bootstrap5/head');
echo view('template-bootstrap5/navbar');
?>

<div class="container">
  <div class="row mt-4">
    <div class="col-md-4 col-md-offset-4">
      <h4>Form Login</h4>
      <hr>
      <form action="<?= base_url('auth/processLogin') ?>" method="POST">
        <?= csrf_field() ?>

        <!-- NotifAddSuccessOrFailed -->
        <?php
        if (isset($message)) {
          echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        } elseif (isset($loginSucces)) {
          echo '<div class="alert alert-success" role="alert">' . $loginSucces . '</div>';
        }
        ?>
        <!-- End NotifAddSuccessOrFailed -->

        <div class="form-group mb-3">
          <label for="" class="mb-1">Username</label>
          <input type="text" class="form-control" name="username" placeholder="Enter your username" value="<?= isset($validation) ? set_value('username') : '' ?>" <?= isset($validation) && display_error($validation, 'username') ? 'autofocus' : '' ?> <?= isset($loginSucces) ? 'autofocus' : '' ?>>
          <span class="text-danger"><?= isset($validation) ? display_error($validation, 'username') : '' ?></span>
        </div>
        <div class="form-group mb-3">
          <label for="" class="mb-1">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Enter your password" value="<?= isset($validation) ? set_value('password') : '' ?>" <?= isset($validation) && display_error($validation, 'password') ? 'autofocus' : '' ?>>
          <span class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : '' ?></span>
        </div>
        <div class="form-group  mb-3">
          <button class="btn btn-primary w-100" type="submit">Sign In</button>
        </div>
        <div class="form-group  mb-3">
          <a href="/register" style="text-decoration: none;">Don't have an accout, click here</a>
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