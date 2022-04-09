<?php

    $dispDate = date_create_from_format("Y-m-d H:i:s", $commentDate)->format("d.m.Y");
    $dispTime = date_create_from_format("Y-m-d H:i:s", $commentDate)->format("H:i");
$output = '<form method="post" class="submit">
        <div class="border-bottom border-dark rounded bg-lightdark mb-3 pb-3">
            <div class="d-flex flex-column p-3 ">
                <p class="px-1">
                    '.$commentContent.'
                </p>
            </div>
            <hr class="mt-0">
            <div class="d-flex flex-row align-items-center justify-content-between px-2">
                <div class="d-flex">
                    <img src="data:image/png;base64,'.$commentPpic.'" width="25" height="25" class="rounded-circle" alt="profilepicture">
                    <p class="small mb-0 ms-2">'.$commentAuthor.'</p>
                </div>
                <span>
                <p class="small mb-0">'.$dispDate.' - '.$dispTime.'</p>';
if(!empty($_SESSION)){
    if(checkPermission("newsblogComment",true, $authorid)){
                        $output.='<input type="hidden" name="commentid" value="'.$commentid.'">
                                    <input type="hidden" name="nav" value="news">
                                    <input type="hidden" name="page" value="'.$page.'">
                                    <button class="btn btn-danger btn-sm submit" name="deleteComment" value="true">Löschen</button>';
                    }
                }
$output.='</span></div></div></form>';
echo $output;
?>