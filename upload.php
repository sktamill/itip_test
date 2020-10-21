<?
if($_SERVER["REQUEST_METHOD"] == "POST"){

    require_once ('function.php');

    $types = array('image/png', 'image/jpg', 'image/jpeg');

    $size = 30000000;

    $tmp_upload_path = 'tmp';

    if(!is_dir($tmp_upload_path)) mkdir($tmp_upload_path);

    $error = [];

    $mess = [
        1 => 'Допускаются форматы: png, jpg',
        2 => 'Допускаются файлы размером до 30MB',
        3 => 'Файл не загружен!',
    ];

    if(!isset( $_POST['my_file_upload'])) $error[] = $mess[3];

    $files = $_FILES;

    foreach ($files as $file){
        if (!in_array($file['type'], $types)) $error[] = $mess[1];
        if($file['size'] > $size) $error[] = $mess[2];
    }

    if(count($error)){
        foreach ($error as $val){
            echo '<p>'.$val.'</p>';
        }
    }else{
        $uploaddir = 'upload';

        if(!is_dir($uploaddir)) mkdir($uploaddir);

        foreach( $files as $file ){

            $parts_file_name = pathinfo($file['name']);

            $resize_file = resize($file, null);

            $new_file_name = $parts_file_name['filename'].'.'.strtolower($parts_file_name['extension']);

            if(copy($tmp_upload_path.'/'.$resize_file, $uploaddir.'/'.$new_file_name)){

                echo '{"status":"1","image":"'.$new_file_name.'"}';

                unlink($tmp_upload_path.'/'.$resize_file);
            }
        }
    }

}

