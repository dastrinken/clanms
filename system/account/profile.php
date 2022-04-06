<form action='./?nav=profile' method='post' enctype='multipart/form-data'>
    <div class="mb-3">
        <label for="profilename" class="form-label">Profilname</label>
        <input type="text" class="form-control" id="profilename" value="<?php echo $pname; ?>" name="pname" placeholer="Ändere deinen öffentlichen Namen">
    </div>
    <div class="mb-3">
        <label for="avatar" class="form-label">Profilbild</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="64000" />
        <input class="form-control" type="file" id="avatar" name="ppic" accept="image/png, image/jpeg">
    </div>
    <div class="mb-3">
        <label for="infotext" class="form-label">Profilinfo</label>
        <textarea class="form-control" id="infotext" rows="3" name="pinfo" placeholer="Der Infotext deines öffentlichen Profils..."></textarea>
    </div>
    <div class="mb-3">
        <input class="btn sendbtn" name="changeProfile" type="submit" value="Absenden"/>
    </div>
</form>