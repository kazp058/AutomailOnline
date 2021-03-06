<?php
require "header.php"
?>

<main>
  <div class="wrapper-main">
    <section class="message-container">
      <?php require "messages.php"; ?>
    </section>
    <section class="section-default">
      <?php
      $selector = $_GET["selector"];
      $validator = $_GET["validator"];

      if (empty($selector) || empty($validator)) {
        echo "<p>Could not validate your request!</p>";
      } else {
        if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
      ?>
          <h1>Reset your password</h1>
          <form action="includes/reset-password.inc.php" method="post">
            <input type="hidden" name="selector" value="<?php echo $selector; ?>">
            <input type="hidden" name="validator" value="<?php echo $validator; ?>">
            <input type="password" name="pwd" placeholder="Enter a new password">
            <input type="password" name="pwd-repeat" placeholder="Repeat new password">
            <button type="submit" name="reset-password-submit">Reset password</button>
          </form>
      <?php
        }
      }
      ?>
    </section>
  </div>
</main>

<?php
require "footer.php"
?>