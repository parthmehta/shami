<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Uploader</title>
    </head>
    <body>
        <?php echo $error; ?>
        <?php echo form_open_multipart('admin/do_upload'); ?>            
            ID no : <input type="number" name="stud_id" /><br />
            Name  : <input type="text" name="name" /><br />        
            Image : <input type="file" name="userfile" /><br />        
        <input type="submit" value="upload" /><br />
        </form>    
    </body>
</html>