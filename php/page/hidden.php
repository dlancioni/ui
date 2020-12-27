<!-- Session -->
<input type="hidden" id="_PARENT_" name="_PARENT_" value="<?php echo $id; ?>">
<input type="hidden" id="_MODULE_" name="_MODULE_" value="<?php echo $moduleId; ?>">
<input type="hidden" id="_FORMAT_" name="_FORMAT_" value="<?php echo $format; ?>">
<input type="hidden" id="_EVENT_" name="_EVENT_" value="<?php echo $event; ?>">
<input type="hidden" id="_PAGING_" name="_PAGING_" value="<?php echo $pageOffset; ?>">


<script>
// must clear the _PARENT_ otherwise it conflicts with _ID_
setId(0);
</script>