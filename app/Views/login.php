<?php
echo view('template-bootstrap5/head');
echo view('template-bootstrap5/navbar');
?>

<div class="container">
  <div class="row mt-4">
    <div class="col-md-4 col-md-offset-4">
      <h4>Form Login</h4>
      <hr>
      <form action="<?= base_url('auth/processlogin') ?>">
        <?= csrf_field() ?>
        <div class="form-group mb-3">
          <label for="">Username</label>
          <input type="text" class="form-control" name="username" placeholder="Enter your username">
        </div>
        <div class="form-group mb-3">
          <label for="">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Enter your password">
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

<?= view('template-bootstrap5/foot'); ?>