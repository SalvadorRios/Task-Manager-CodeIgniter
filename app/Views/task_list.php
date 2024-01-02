<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tasksList</title>
</head>
<body>

    <h1>
       <?php foreach( $tasks as $val) : ?>
        <?php  echo $val['title']; ?>
       <?php endforeach; ?>
    </h1>
    
</body>
</html>