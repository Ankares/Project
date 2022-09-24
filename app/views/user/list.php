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

        <?php if(empty($data['users'])):?>
            <h3 class="text-center">No user found</h3>
        <?php endif;?>

        <?php foreach($data['users'] as $user) : ?>
            <ul class="list-group">
                <li class="list-group-item offset-2 col-8 mb-4 fs-5 p-4">
                    
                    <form action="/user/list" method="post" onsubmit="return confirm('Are you sure?');">
                        <input type="hidden" name="delete" value="<?php echo $user['id']?>">
                        <button class="btn btn-danger offset-11 col-1">&times;</button>
                    </form>

                    <form action="/user/list" method="post">                        
                        <h4 class="col-12 ms-2"><?php echo 'User: ' . $user['name']?></h4>
                        <div class="row mx-3 mt-3">
                            <div class="col-3">
                                <label class="p-2 me-5">Email:</label>
                                <label class="p-2 me-5">Name:</label>
                                <label class="p-2 me-5">Surname:</label>
                                <label class="p-2 me-5">Gender:</label>   
                                <label class="p-2 me-5">Status:</label> 
                            </div>
                            <div class="col-9">
                                <input type="hidden" name="id" value="<?php echo $user['id']?>">
                                <input name="email" class="form-control-plaintext px-2" value="<?php echo $user['email']?>">
                                <input name="name" class="form-control-plaintext px-2 mt-1" value="<?php echo $user['name']?>">
                                <input name="surname" class="form-control-plaintext px-2" value="<?php echo $user['surname']?>">
                                <select name="gender" class="form-select mt-2" value="<?php echo $user['gender'] ?>">
                                    <option value="male" <?php if(isset($user['gender']) && ($user['gender'] == 'male')) {echo "selected";}?>>
                                        Male
                                    </option>
                                    <option value="female" <?php if(isset($user['gender']) && ($user['gender'] == 'female')) {echo "selected";}?>>
                                        Female
                                    </option>
                                </select>
                                <select name="status" class="form-select mt-2" value="<?php echo $user['status'] ?>">
                                    <option value="active" <?php if(isset($user['status']) && ($user['status'] == 'active')) {echo "selected";}?>>
                                        Active
                                    </option>
                                    <option  value="inactive" <?php if(isset($user['status']) && ($user['status'] == 'inactive')) {echo "selected";}?>>
                                        Inactive
                                    </option>
                                </select>
                                <?php if(isset($data['message'])): ?>
                                    <p class="text-danger mt-3"><?php echo $data['message'];?></p>
                                <?php endif;?>
                            </div>
                        </div> 
                        <button class="btn btn-outline-primary mt-4 p-2 offset-10 col-2">Save changes</button> 
                    </form>
                  
                </li>
            </ul>
        <?php endforeach;?>
    </div>


    <?php require_once "public/blocks/footer.php"?>
</body>
</html>