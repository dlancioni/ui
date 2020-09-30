<?php

  $json = '{"upload":"Pending"}';

  try {
    throw new Exception("Deu pau");
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $fileSize = getimagesize($_FILES["file"]["tmp_name"]);
    $json = '{"upload":"success"}';

  } catch (Exception $ex) {
    $json = '{"upload":"fail"}';
  }

  echo $json;

?>