<?php

/**
 * +-------------------------------------------------------------------+
 * |                    F I L E M A N A G E R   (v10.41)               |
 * |                                                                   |
 * | Copyright Gerd Tentler               www.gerd-tentler.de/tools    |
 * | Created: Dec. 7, 2006                Last modified: Sep. 22, 2015 |
 * +-------------------------------------------------------------------+
 * | This program may be used and hosted free of charge by anyone for  |
 * | personal purpose as long as this copyright notice remains intact. |
 * |                                                                   |
 * | Obtain permission before selling the code for this program or     |
 * | hosting this software on a commercial website or redistributing   |
 * | this software over the Internet or in any other medium. In all    |
 * | cases copyright must remain intact.                               |
 * +-------------------------------------------------------------------+
 */
include_once('class/FileManager.php');

?>
<!DOCTYPE html>
<html>
<head>
<title>File Manager</title>
</head>
<body class="fmBody">
<table border="0" style="width:100%; height:100%"><tr>
<td align="center">
<?php
var_dump(__dir__);
$FileManager = new FileManager();
$FileManager->tmpFilePath = __dir__.'\tmp';
$FileManager->fmWebPath  = './';
$FileManager->rootDir = __dir__.'\upload\media';
$FileManager->enableUpload  = true;
print $FileManager->create();

?>
</td>
</tr></table>
<script>
    function getUrlParam(paramName)
    {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i');
        var match = window.location.search.match(reParam);

        return (match && match.length > 1) ? match[1] : '';
    }    
    var mediaUrl= "http://depquatroi.com/upload/media";
</script>
</body>
</html>