<?php
require "header.php";
?>
<main>
   <div class="wrapper-main">
      <section class="section-default">
         <?php
         $id = $_GET["id"];
         require 'includes/dbh.inc.php';
         $sql = "SELECT * FROM certscompany WHERE certId=?;";
         $stmt = mysqli_stmt_init($conn_certs);

         if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: survey.php?id=" . $id . "&error=sql");
            exit();
         } else {
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
               $title = $row['titleCerts'];
               $name = $row['issuerName'];
               $supportmail = $row['emailCert'];
            } else {
               header("Location: survey.php?id=" . $id . "&error=nocertificate");
               exit();
            }
         }

         if (empty($id)) {
            echo "<p>Could not validate your request!</p>";
         } else {
         ?>
            <form action="includes/certificate-create.inc.php" method="post">
               <div>
                  <h1><?php echo $title; ?></h1>
                  <h3>By <?php echo $name; ?></h3>
                  <h3>For support or information, contact: <?php echo $supportmail; ?></h3>
                  <hr>
               </div>
               <div>
                  <label>First Name
                     <input type="text" name="fname">
                  </label>
                  <label>Second Name
                     <input type="text" name="sname">
                  </label>
               </div>
               <div>
                  <label>First Last Name
                     <input type="text" name="flname">
                  </label>
                  <label>Second Last Name
                     <input type="text" name="slname">
                  </label>
               </div>
               <div>
                  <label>Email
                     <input type="text" name="email">
                  </label>
               </div>
               <input type = "hidden" name="id" value="<?php echo $id; ?>" >
               <button class="highlight-button" type="submit" name="survey-submit">Send information</button>
            </form>
         <?php
         }
         ?>
      </section>
   </div>
</main>
<?php
require "footer.php";
?>