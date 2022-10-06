<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

<div class="container">
    <h2 class="mt-5 mb-5 text-center">Editing User</h2>

    <!-- if user exists - show user info -->
    <?php if (isset($data['user']['id'])) : ?>
        <ul class="list-group">
            <li class="list-group-item offset-md-2 offset-0 col-md-8 col-12 mb-4 fs-5 p-4">
                <a href="/user/list" class="btn btn-outline-primary float-start col-md-2 col-4">Return</a> 
                <form action="/user/delete" method="post" onsubmit="return confirm('Are you sure?');">
                    <input type="hidden" name="delete" value="<?=$data['user']['id']?>">
                    <button class="btn btn-danger offset-md-9 offset-6 col-md-1 col-2">&times;</button>
                </form>

                <form action="/user/edit/<?=$data['user']['id']?>" method="post">                        
                    <h4 class="col-12 ms-2 mt-4"><?='User: ' . $data['user']['email']?></h4>
                    <div class="row mx-3 mt-3">
                        <div class="col-md-3 col-6">
                            <label class="p-2 me-5">Email:</label>
                            <label class="p-2 me-5">Name:</label>
                            <label class="p-2 me-5">Gender:</label>   
                            <label class="p-2 me-5">Status:</label> 
                        </div>
                        <div class="col-md-9 col-6">
                            <input type="hidden" name="id" value="<?=$data['user']['id']?>">
                            <!-- making remembering of previous values -->
                            <input name="email" class="form-control-plaintext px-2" value="<?=isset($_POST['email']) ? $_POST['email'] : $data['user']['email']?>">
                            <input name="name" class="form-control-plaintext px-2 mt-1" value="<?=isset($_POST['name']) ? $_POST['name'] : $data['user']['name']?>">
                            <select name="gender" class="form-select mt-2" value="<?=isset($_POST['gender']) ? $_POST['gender'] : $data['user']['gender']?>">
                                <option value="male" <?=isset($data['user']['gender']) && ($data['user']['gender'] == 'male') ? "selected" : ''?>>
                                    Male
                                </option>
                                <option value="female" <?=isset($data['user']['gender']) && ($data['user']['gender'] == 'female') ? "selected" : ''?>>
                                    Female
                                </option>
                            </select>
                            <select name="status" class="form-select mt-2" value="<?=isset($_POST['status']) ? $_POST['status'] : $data['user']['status']?>">
                                <option value="active" <?=isset($data['user']['status']) && ($data['user']['status'] == 'active') ? "selected" : ''?>>
                                    Active
                                </option>
                                <option  value="inactive" <?=isset($data['user']['status']) && ($data['user']['status'] == 'inactive') ? "selected" : ''?>>
                                    Inactive
                                </option>
                            </select>
                            <?php if (isset($data['error'])) : ?>
                                <div class="error text-danger mt-3 fw-bold fs-4"><?=$data['error'];?></в>
                            <?php endif; ?>
                            <?php if (isset($data['success'])) : ?>
                                <div class="success text-success mt-3 fs-4 fw-bold"><?=$data['success'];?></div>
                            <?php endif; ?>
                        </div>
                    </div> 
                    <button class="outfit btn btn-primary offset-lg-10 offset-8 col-lg-2 col-4 mt-4 p-2">Save changes</button>
                </form>
                
            </li>
        </ul>

    <!-- if user doesnt exist -->
    <?php else : ?>
        <div class="container text-center">
            <h2 class="col-12">User does not found</h2>
            <a href="/user/list" class="btn btn-outline-primary mt-4 col-md-3 col-5 text-center">Return</a>
        </div> 
    <?php endif; ?>
</div>

<script src="/app/js/script.js"></script> 
</body>
</html>