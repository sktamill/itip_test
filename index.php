<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/style.css" rel="stylesheet">
    <title>Upload Image</title>
</head>
<body>

    <h1>Upload Image</h1>

    <div id="wrapper">

        <form id="upload" action="#">
            <input id="avatar" type="file" hidden>
            <label for="avatar">UPLOAD PHOTO</label>
        </form>

        <progress max="100" value="0"></progress>

        <div class="preview"></div>

        <div class="mess"></div>

    </div>

    <script src="js/jquery-1.7.2.min.js"></script>
    <script src="js/script.js"></script>

</body>
</html>