<?
if($_SERVER["REQUEST_METHOD"] == "POST"){

    require_once 'function.php';

    $img = 'upload/'.$_POST['img'];

    createCropp($img);

    createPattern($img);

    createMerge();

    echo 1;

}

