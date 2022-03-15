<ul id="newsTableNav" class="nav d-flex justify-content-between mb-3">
    <li class="d-flex nav-item justify-content-center align-items-center border border-secondary rounded-start">
        <a href="#" class="nav-link rounded-start" onclick="page > 1 ? --page : page = 1; getTableView(saveContent, saveDisplay); return false;">
            <i class="bi-arrow-left"></i>
        </a>
    </li>
    <li id="showPageNr" class="d-flex flex-grow-1 nav-item justify-content-center align-items-center border"></li>
    <li class="d-flex nav-item justify-content-center align-items-center border border-secondary rounded-end">
        <a href="#" class="nav-link rounded-end" onclick="page < <?php echo $totalPages; ?> ? ++page : page = <?php echo $totalPages; ?>; getTableView(saveContent, saveDisplay); return false;">
            <i class="bi-arrow-right"></i>
        </a>
    </li>
</ul>