<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <div class="col-md-4 d-flex align-items-center">
      <a href="./" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
        <img class="bi" src="./ressources/icons/clanms_logo.svg" width="46" height="34" alt="Logo"></img>
      </a>
      <span class="text-muted">&copy; 2022 ClanMS</span>
    </div>
    <div class="col d-flex justify-content-center"><a href="./?nav=imp" class="text-muted text-decoration-none lh-1"><i class="bi-bookmarks me-2"></i>Impressum</a></div>
    <!-- Social media links TODO: load from database-->
    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
      <?php
        $mysqli = connect_DB();
        $select = "SELECT * FROM clanms_social_media WHERE 1=1;";
        $query = $mysqli->query($select);
        while($row = $query->fetch_assoc()) {
          echo '<li class="ms-3"><a class="text-muted" href="'.$row["url"].'" target="_blank"><i class="'.$row["icon"].' footer-icon"></i></a></li>';
        }
        $mysqli->close();
      ?>
    </ul>
</footer>