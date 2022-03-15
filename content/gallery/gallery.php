

<?php
    /* Idee: Datenbank gibt an, welche Bilder existieren und wie sie dargestellt werden (bootstrap carousel oder cards)
            Für Erstinbetriebnahme sollen beispielhaft alle Möglichkeiten dargestellt werden. 
            Also includen wir beides und laden ein paar Beispielbilder hoch.
    */
?>

<div class="card text-center bg-lightdark p-2" style="width: 18rem;">
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="./content/gallery/images/img1.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="./content/gallery/images/img2.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="./content/gallery/images/img3.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
  </div>
  <div class="card-body">
    <h5 class="card-title">Hier könnte ihre Werbung stehen.</h5>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>