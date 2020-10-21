<?php
function resize($file, $quality = null)
{
    global $tmp_upload_path;

    if ($quality == null) $quality = 100;

    if ($file['type'] == 'image/jpg' || $file['type'] == 'image/jpeg' ) {
        $source = imagecreatefromjpeg($file['tmp_name']);
    }
    if ($file['type'] == 'image/png'){
        $source = imagecreatefrompng($file['tmp_name']);
    }

    imagejpeg($source, $tmp_upload_path.'/'.$file['name'], $quality);
    imagedestroy($source);

    return $file['name'];
}


function createCropp($img_path){
    $position = [3, 2, 1, 2, 3 ];
    $pos_y = [3,4,1,4,3];
    $i = 0;
    foreach($position as $key => $pos ){

        $im = imagecreatefromjpeg($img_path);
        $width = imagesx($im) / 5;
        $height = imagesy($im) / $pos;
        $x = $width * $i;
        $y = $pos == 1 ? 0 : imagesy($im) / $pos_y[$key];

        $im2 = imagecrop($im, ['x' => $x, 'y' => $y, 'width' => $width, 'height' => $height]);
        if ($im2 !== FALSE) {
            imagejpeg($im2, 'img/cropp'.$i.'.jpg');
            imagedestroy($im2);
        }
        imagedestroy($im);
        $i++;
    }
}

function createPattern($img_path = null)
{
    $size = getimagesize($img_path);
    $img = imagecreate($size[0]+60, $size[1]+20);
    imagecolorallocate($img, 255, 255, 255);
    imagejpeg($img, 'img/pattern.jpg');
}

function createMerge()
{
    $i = 0;
    while ($i < 5) {
        $dest = $i == 0 ? imagecreatefromjpeg('img/pattern.jpg') : imagecreatefromjpeg('img/result.jpg');
        $src = imagecreatefromjpeg('img/cropp' . $i . '.jpg');

        $size = getimagesize('img/cropp' . $i . '.jpg');
        $size_pattern = getimagesize('img/pattern.jpg');

        $y = $size_pattern[1] / 2 - $size[1] / 2;
        $x = ($i == 0 ? 10 : ($size[0] + 10) * $i + 10);

        imagealphablending($dest, false);
        imagesavealpha($dest, true);

        imagecopymerge($dest, $src, $x, $y, 0, 0, $size[0], $size[1], 100);

        imagejpeg($dest, 'img/result.jpg');

        imagedestroy($dest);
        imagedestroy($src);
        $i++;
    }
}
