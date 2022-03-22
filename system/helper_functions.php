<?php
/* Allgemeine Hilfsfunktionen */

// Shows a small Popup message on the bottom right, use it to display error Messages.
function showToastMessage($stringMessage) { 
    echo '<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="messageToast" class="showToast bg-blackened" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-highlighted text-dark">
                <img class="bi me-4" src="./ressources/icons/clanms_logo.svg" width="35" height="25" alt="ClanMS"></img>
                <strong class="me-auto">Systemnachricht</strong>
                <button type="button" class="btn-close" onclick="closeToast();" aria-label="Close"></button>
                </div>
                <div id="toastBody" class="toast-body">
                '.$stringMessage.'
                </div>
            </div>
        </div>';
}

// Debugs data to javascript console
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
?>