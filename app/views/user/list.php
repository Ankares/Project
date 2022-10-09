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
        <h2 class="mt-5 mb-5 text-center">All users</h2>

        <?php if (empty($data['users'])) : ?>
            <h3 class="text-center">No users found</h3>
        <?php endif; ?>

        <?php foreach($data['users'] as $user) : ?>
            <ul class="list-group">
                <button class="trigger-menu btn btn-outline-secondary shadow-none offset-md-2 offset-0 col-md-8 col-12 mb-3">
                    <h5>Show user: <?=$user['email']?></h5>
                </button>
                <li class="list-group-item offset-md-2 offset-0 col-md-8 col-12 mb-4 fs-5 p-4">
                    <form action="/user/list" method="post">                        
                        <h4 class="col-md-10 col-8 float-start"><?php echo 'User: ' . $user['email']?></h4>
                        <a href="/user/edit/<?=$user['id']?>" class="btn btn-primary col-md-2 col-4">Edit user</a> 
                        <div class="row mx-md-3 mx-0 mt-3">
                            <div class="col-3 col-md-3">
                                <p class="me-5">Email:</p>
                                <p class="me-5">Name:</p>
                                <p class="me-5">Gender:</p>   
                                <p class="me-5">Status:</p> 
                            </div>
                            <div class="offset-2 offset-md-0 col-7 col-md-9">
                                <input name="email" class="form-control-plaintext mb-2" disabled value="<?=$user['email']?>">
                                <p name="name" class="me-5" value=><?=$user['name']?></p>
                                <p name="gender" class="me-5" value=><?=$user['gender']?></p>
                                <p name="status" class="me-5" value=><?=$user['status']?></p>
                            </div>
                        </div> 
                    </form> 
                </li>
            </ul>
        <?php endforeach; ?>
    </div>

    <?php require_once "public/blocks/footer.php"?>
    <script src="/app/js/script.js"></script>
</body>
</html>