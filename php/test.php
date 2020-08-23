<html>
<head>    
<title>UI</title>
</head>    
<body>
<?php


$rows = array(
    array(
        'id' => 33,
        'parent_id' => 0,
    ),
    array(
        'id' => 34,
        'parent_id' => 0,
    ),
    array(
        'id' => 27,
        'parent_id' => 33,
    ),
    array(
        'id' => 17,
        'parent_id' => 27,
    ),
);

function buildTree(array $elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}

$tree = buildTree($rows);

print_r( $tree );


?>
</body>
</html>
        
        