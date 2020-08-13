<?php
require 'header.php';
?>

<main>
  <div class="wrapper-main">
    <section class="section-default">
      <div class="title">
        <h1>Search certificates</h1>
        <hr>
      </div>
      <div class="formulary">
        <form action="includes/search.inc.php" method="post">
          <p>Token</p>
          <input type="text" name="key">
          <button class="highlight-button" type="submit" name="search-submit">Search</button>
        </form>
      </div>
    </section>

    <section class="section-default">
      <?php
      if (isset($_GET['id'])) {
        require 'includes/dbh.inc.php';
        $sql = "SELECT * FROM certs WHERE idCerts=?;";
        $stmt = mysqli_stmt_init($conn_certs);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../certificates.php?id=" . $_GET['id'] . "error=sqlerror");
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if ($row = mysqli_fetch_assoc($result)) {

            $sql = "SELECT * FROM certscompany WHERE certId=?;";
            $stmt = mysqli_stmt_init($conn_certs);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              header("Location: ../certificates.php?id=" . $_GET['id'] . "error=sqlerror");
              exit();
            } else {
              mysqli_stmt_bind_param($stmt, "s", $row['issuerCerts']);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
              if ($rowissuer = mysqli_fetch_assoc($result)) {
                $command = escapeshellcmd('includes/scripts/generateCert.py 001.png ' . $row['userName'] . ' ' . $row['titleCerts'] . ' ' . $row['tokenCerts'] . ' '. $rowissuer['issuerName']);
                shell_exec($command);
                
              }
            }
          }
        }
      ?>

        <img src="includes/Test_.jpg" alt="Test">
        <?php

        if (isset($_GET['claimed']) && !$_SESSION['isCompany']) {
          if (isset($_SESSION['userId'])) {
        ?>
            <form action="includes/claim.inc.php" method="post">
              <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
              <input type="hidden" name="userId" value="<?php echo $_SESSION['userId']; ?>">
              <div class="options-horizontal">
                <ul>
                  <li>
                    <p>Claim Code</p>
                  </li>
                  <li><input style="text-align:center;" name="ccode" type="text" maxlength="6"></li>
                  <li><button class="highlight-button" name="claim-submit">Claim Certificate</button></li>
                </ul>
            </form>
          <?php
          } else {
          ?>
            <form action="login.php" method="put">
              <button class="highlight-button">Claim Certificate</button>
            </form>
      <?php
          }
        }
      }
      ?>
    </section>

    <section class="section-table">
      <?php
      if (isset($_SESSION['userId']) && !$_SESSION['isCompany']) {
      ?>
        <h1>My certificates</h1>
        <hr>
        <?php
        if (true) {
        ?>
          <section class="section-default">
            <p>You dont have any certificates yet!</p>
            <br>
            <?php
            if ($_SESSION['isCompany']) {
            ?>
              <a class="highlight-link" href="create-certificate.php">Create new certificate</a>
          </section>
      <?php
            }
          }
        } else if (isset($_SESSION['userId']) && $_SESSION['isCompany']) {
      ?>

      <h1>Certificates Emitted(<?php
                                require 'includes/dbh.inc.php';

                                $sql = "SELECT * FROM certs WHERE issuerCerts=?;";
                                $stmt = mysqli_stmt_init($conn_certs);

                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                  header("Location: ../certificates.php?error=sqlerror");
                                  exit();
                                } else {
                                  mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
                                  mysqli_stmt_execute($stmt);
                                  $result = mysqli_stmt_get_result($stmt);
                                  $num_rows = mysqli_num_rows($result);
                                  echo $num_rows;
                                }
                                ?>/<?php
                                    require 'includes/dbh.inc.php';

                                    $sql = "SELECT * FROM users WHERE idUsers=?;";
                                    $stmt = mysqli_stmt_init($conn);

                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                      header("Location: ../certificates.php?error=sqlerror");
                                      exit();
                                    } else {
                                      mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
                                      mysqli_stmt_execute($stmt);
                                      $result = mysqli_stmt_get_result($stmt);
                                      if ($row = mysqli_fetch_assoc($result)) {
                                        echo $row['certificatesAv'];
                                      } else {
                                        header("Location: ../login.php?error=nouser");
                                        exit();
                                      }
                                    }
                                    ?>)</h1>
      <hr>

      <div>
        <?php
          require 'includes/dbh.inc.php';

          $sql = "SELECT * FROM certsCompany WHERE issuerCerts=?;";
          $stmt = mysqli_stmt_init($conn_certs);

          if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../certificates.php?error=sqlerror");
            exit();
          } else {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while ($row = $result->fetch_assoc()) {
        ?>

            <div>
              <div>
                <h3><?php echo $row['titleCerts']; ?></h3>
              </div>
              <div>
                <div>
                  <h4>URL:</h4>
                  <p><?php echo "192.168.100.100/survey.php?id=" . $row['certId']; ?></p>
                </div>
                <div>
                  <h4>Certificates:</h4>
                  <p><?php echo $row['certsCreated'] . "|" . $row['certsAssigned']; ?></p>
                </div>
              </div>
            </div>

        <?php
            }
          }
        ?>
        <div>
          <h3><a href="create-certificate.php">Create Certificate</a></h3>
        </div>
        <div>
          <h3><a href="buy-certificates.php">Buy Certificates</a></h3>
        </div>
      </div>
    <?php
        }
    ?>
    </section>
  </div>
</main>

<?php
require 'footer.php';
?>