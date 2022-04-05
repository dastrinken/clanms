<?php
    $dispDate = date_create_from_format("Y-m-d H:i:s", $commentDate)->format("d.m.Y");
    $dispTime = date_create_from_format("Y-m-d H:i:s", $commentDate)->format("H:i");
echo '<div class="border-bottom border-dark rounded bg-lightdark">
            <div class="d-flex flex-row p-3">
                <p>
                    '.$commentContent.'
                </p>
            </div>
            <hr class="mt-0">
            <div class="d-flex flex-row align-items-center justify-content-between px-2 pb-2">
                <div class="d-flex">
                    <img src="data:image/png;base64,'.$commentPpic.'" width="25" height="25" class="rounded-circle" alt="profilepicture">
                    <p class="small mb-0 ms-2">'.$commentAuthor.'</p>
                </div>
                <p class="small mb-0">'.$dispDate.' - '.$dispTime.'</p>
            </div>
        </div>';
?>