<?php include '.\..\header.php';
echo '

<form id="form0" method="post" action="doUpload.php" enctype="multipart/form-data"> 
    <fieldset id="info">
        <input type="hidden" name="src" value="uploadtest.php" />
        
        <legend>Upload 1 File</legend>
		<label title="userfile" for="userfile">File: <span>*</span></label>
		<input type="file" name="userfile" id="userfile" size="25" />

    <fieldset id="submit">
        <input type="submit" id="uploadFile" name="uploadFile" value="Upload File" />
    </fieldset>
</form>


';
?>