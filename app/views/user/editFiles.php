<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Editing files</title>
</head>
<body>
   
    <div class="container">
        <?php if(isset($data['user']['id'])) : ?>
            <h2 class="mt-5 mb-5 text-center">Editing files</h2>
                <ul class="list-group">
                    <li class="list-group-item offset-md-2 offset-0 col-md-8 col-12 mb-4 fs-5 p-4">
                    <a href="/user/edit/<?=$data['user']['id']?>" class="btn btn-outline-primary col-md-2 col-4 mb-4">Return</a> 

                        <?php foreach($data['files'] as $file): ?>
                            <div class="form-group">
                                <hr>
                                <form action="/user/deleteFiles" method="post" onsubmit="return confirm('Are you sure?');">
                                    <button class="btn btn-outline-danger offset-md-10 offset-8 col-md-2 col-4 mb-3">Delete</button>
                                    <input type="hidden" name="imageToDelete" value="<?=$file['path']?>">
                                    <input type="hidden" name="idToDelete" value="<?=$data['user']['id']?>">
                                    <?php $ext = pathinfo($file['file'], PATHINFO_EXTENSION)?>
                                    <?php if($ext == 'txt' || $ext == 'docx'): ?>
                                        <p><?=$file['file']?></p>
                                    <?php else: ?>
                                        <button type="button" class="trigger-menu btn btn-outline-secondary col-12 mb-3">Show image: <?=$file['file']?></button>
                                        <img src="/public/userFiles/<?=$file['path']?>" class="img-thumbnail">
                                    <?php endif; ?>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </li>
                </ul>
           
        <?php else: ?>
            <h1 class="mt-5 text-center">Editing files</h1>
            <h4 class="mt-5 text-center">User does not found</h4>
            <a href="/user/list" class="btn btn-outline-primary mt-4 offset-4 col-4 text-center">Return to users list</a>
        <?php endif; ?>
    </div>

    <script src="/app/js/script.js"></script>
</body>
</html>