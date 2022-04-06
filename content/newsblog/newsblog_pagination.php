<?php
    $page = $_GET['page'];
?>
<ul id="tableNav" class="nav d-flex justify-content-between mb-3">
    <li class="d-flex justify-content-center align-items-center">
        <a href="?nav=news&page=<?php echo $page > 1 ? ($page - 1) : 1; ?>" class="nav-link rounded-start bg-danger border-black eventday text-white">
            <i class="bi-arrow-left"></i>
        </a>
    </li>
    <li id="showPageNr" class="d-flex flex-grow-1 nav-item justify-content-center align-items-center border-dark shadow-sm"><?php echo "Seite ".$page; ?></li>
    <li class="d-flex justify-content-center align-items-center">
        <a href="?nav=news&page=<?php echo $page < $totalPages ? ($page + 1) : $totalPages; ?>" class="nav-link rounded-end bg-danger border-black eventday text-white">
            <i class="bi-arrow-right"></i>
        </a>
    </li>
</ul>