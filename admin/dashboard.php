<?php
session_start();
if (empty($_SESSION['userid']) || empty($_SESSION['username'])) {
  echo "<a href='../'>You're not logged in!</a>";
  exit;
}
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ClanMS - Admin Dashboard</title>

  <!-- Markdown Editor -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
  <!-- Bootstrap core CSS and icons -->
  <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="../bootstrap/icons/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="./style/dashboard.css" rel="stylesheet">
  <?php
  require(__DIR__ . "/scripts/adminfunctions.php");
  ?>
</head>

<body>
  <?php include(__DIR__ . "/header.php"); ?>

  <!-- Sidebar Menu -->
  <div class="container-fluid">
    <div class="row">
      <?php include(__DIR__ . "/sidebar.php"); ?>

      <!-- Main Content -->
      <main id="mainContentWrapper" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <?php include(__DIR__ . "/scripts/loadContent.php"); ?>
      </main>

    </div>
  </div>

  <?php include(__DIR__ . "/gallery/upload_modal.php"); ?>

  <script src="../bootstrap/js/bootstrap.bundle.js"></script>
  <script type="text/javascript">
    var userid = '<?php echo $userid; ?>';
    var username = '<?php echo $username; ?>';
  </script>
  <script src="./scripts/admin.js"></script>
  <script src="../system/js/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
</body>

</html>
