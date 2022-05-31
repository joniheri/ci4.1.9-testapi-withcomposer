<?php
echo view('template-bootstrap5/head');
echo view('template-bootstrap5/navbar');

?>

<div class="container">
  <!-- NotifAddSuccessOrFailed -->
  <?php
  if (isset($dataMessage) && !empty($dataMessage['message'])) {
    echo '<div class="alert alert-success" role="alert">' . $dataMessage['message'] . '</div>';
  }
  ?>
  <!-- End NotifAddSuccessOrFailed -->
  <h1>Welcome <?= isset($dataUser['fullname']) && empty($dataUser['fullname']) ? $dataUser['fullname'] : '' ?>, This is Dashboard Page </h1>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(1000, function() {
        $(this).remove();
      });
    }, 3400);

  });
</script>

<?= view('template-bootstrap5/foot'); ?>