
<?php 
    if($_GET['code']) {
        include(__DIR__."/system/login/activation.php");
    } elseif($_GET['nav'] === 'news') {
        showAllNews();
    } elseif($_GET['nav'] === 'info') {
        /* include("info.php"); */
    } elseif($_GET['nav'] === 'profile') {
        include(__DIR__."/system/account/settings.php");
    } elseif($_GET['nav'] === 'calendar') {
        include(__DIR__."/content/calendar/calendarpage.php");
    } elseif($_GET['nav'] === 'gallery') {
        include(__DIR__."/content/gallery/gallery.php");
    } else {
        /* default, vorerst Kalender + Willkommenstext einbinden, später variabel machen */
        include(__DIR__."/content/eventorganizer/main.php");
    }
        /* TODO: 
        **   - autom. include all articles
        **   - avoid potential security risk when using get
        */
?>