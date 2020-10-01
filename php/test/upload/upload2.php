<?php

  $json = '{"upload":"Pending"}';

  try {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"][1]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $fileSize = getimagesize($_FILES["file"]["tmp_name"][1]);
    $json = '{"upload":"success"}';

  } catch (Exception $ex) {
    $json = '{"upload":"fail"}';
  }

  echo $json;

?>