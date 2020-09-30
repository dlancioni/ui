<?php

  try {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $fileSize = getimagesize($_FILES["file"]["tmp_name"]);
    echo '{"upload":"success"}';

  } catch (Exception $ex) {
    echo '{"upload":"fail"}';
  }

?>