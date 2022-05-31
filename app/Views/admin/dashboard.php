<?php
echo view('template-bootstrap5/head');
echo view('template-bootstrap5/navbar');
?>

<div class="container">
  <!-- NotifAddSuccessOrFailed -->
  <?php
  if (isset($message)) {
    echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
  }
  ?>
  <!-- End NotifAddSuccessOrFailed -->
  <textarea name="" id="" rows="5" style="width: 100%;">
    <? //= $token; 
    ?>
  </textarea>
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