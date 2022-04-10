<?php 
    if($_GET['code']) {
        include(__DIR__."/system/account/login/activation.php");
    } elseif($_GET['nav'] === 'news') {
        include(__DIR__."/content/newsblog/newsblog_functions.php");
        showAllNews();
    } elseif($_GET['nav'] === 'info') {
        include(__DIR__."/content/about_us/about_us.php");
    } elseif($_GET['nav'] === 'profile') {
        include(__DIR__."/system/account/settings.php");
    } elseif($_GET['nav'] === 'calendar') {
        include(__DIR__."/content/calendar/calendar_functions.php");
        include(__DIR__."/content/calendar/calendar_page.php");
    } elseif($_GET['nav'] === 'gallery') {
        include(__DIR__."/content/gallery/gallery_functions.php");
        include(__DIR__."/content/gallery/galleryframe.php");     
    } elseif($_GET['nav'] === 'faq'){
        include(__DIR__."/content/faq/faq_functions.php");
        include(__DIR__."/content/faq/faq.php");
    } elseif($_GET['nav'] === 'imp') {
        include(__DIR__."/content/impressum/impressum_funtions.php");
        include(__DIR__."/content/impressum/impressum.php");
    } elseif($_GET['openGallery'] === 'true'){
        include(__DIR__."/content/gallery/gallery_functions.php");
        include(__DIR__."/content/gallery/gallerypicture.php");
    } else {
        /* default, vorerst Kalender + Willkommenstext einbinden, später variabel machen */
        include(__DIR__."/content/calendar/calendar_functions.php");
        include(__DIR__."/content/calendar/eventorganizer/widget.php");
    }
?>