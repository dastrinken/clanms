
<?php 
    if($_GET['code']) {
        include(__DIR__."/../system/login/activation.php");
    } elseif($_GET['nav'] === 'news') {
        for($i = 0; $i < 5; $i++) {
            include(__DIR__."/../content/articles/article_template.php"); 
        }
    } elseif($_GET['nav'] === 'info') {
        /* include("info.php"); */
    } elseif($_GET['nav'] === 'profile') {
        include(__DIR__."/../system/account/settings.php");
    } elseif($_GET['nav'] === 'calendar') {
        include(__DIR__."/../content/calendar/calendarpage.php");
    } else {
        /* default, vorerst Kalender + Willkommenstext einbinden, später variabel machen */
        include(__DIR__."/../content/eventorganizer/main.php");
    }
        /* TODO: 
        **   - autom. include all articles
        **   - avoid potential security risk when using get
        */
?>