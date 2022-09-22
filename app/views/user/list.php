<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Users list</title>
</head>
<body>
    <?php require_once "public/blocks/header.php"?>
    <div class="container">
        <h2 class="mt-5 mb-3 text-center">All users</h2>
        <?php foreach($data['users'] as $user) : ?>
            <ul class="list-group">
                <li class="list-group-item offset-2 col-8 mb-4 fs-5">
                    <h4 class="col-10 float-start"><?php echo 'User: ' . $user['name']?></h4>
                    
                    <form action="/user/list" method="post">
                        <input type="hidden" name="delete" value="<?php echo $user['id']?>">
                        <button class="btn btn-danger offset-1 col-1">&times;</button>
                    </form>
                    
                    <div class="btn-group my-3 me-2 w-100">
                        <label class="p-2 me-3">Email:</label>
                        <input class="form-control-plaintext mx-3" value="<?php echo $user['email']?>">
                        <button class="btn btn-outline-primary col-3">Edit</button> 
                    </div>
                    <div class="btn-group my-3 me-2 w-100">
                        <label class="p-2 me-3">Name:</label>
                        <input class="form-control-plaintext mx-3" value="<?php echo $user['name']?>">
                        <button class="btn btn-outline-primary col-3">Edit</button> 
                    </div>
                    <div class="btn-group my-3 me-2 w-100">
                        <label class="p-2 me-3">Surname:</label>
                        <input class="form-control-plaintext mx-3" value="<?php echo $user['surname']?>">
                        <button class="btn btn-outline-primary col-3">Edit</button> 
                    </div>
                    <div class="btn-group my-3 me-2 w-100">
                        <label class="p-2 me-3">Gender:</label>
                        <input class="form-control-plaintext mx-3" value="<?php echo $user['gender']?>">
                        <button class="btn btn-outline-primary col-3">Edit</button> 
                    </div>
                    <div class="btn-group my-3 me-2 w-100">
                        <label class="p-2 me-3">Status:</label>
                        <input class="form-control-plaintext mx-3" value="<?php echo $user['status']?>">
                        <button class="btn btn-outline-primary col-3">Edit</button> 
                    </div>
                </li>
            </ul>
        <?php endforeach;?>
    </div>


    <?php require_once "public/blocks/footer.php"?>
</body>
</html>