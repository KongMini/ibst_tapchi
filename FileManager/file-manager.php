<?php
include_once('class/FileManager.php');
?>
<table border="0" style="width:100%; height:100%"><tr>
    <td align="center">
    <?php
    $FileManager = new FileManager();
    $FileManager->tmpFilePath = 'tmp';
    $FileManager->rootDir = '/upload';
    $FileManager->fmWebPath  =  '/upload';
    $FileManager->enableUpload  = true;
    print $FileManager->create();    
    ?>
    </td>
    </tr>
</table>
<script>
    function getUrlParam(paramName)
    {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i');
        var match = window.location.search.match(reParam);
        return (match && match.length > 1) ? match[1] : '';
    }    
    var mediaUrl= '/upload';
</script>