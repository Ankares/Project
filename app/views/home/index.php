<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Home page</title>
</head>
<body>
    <div class="container text-center mt-5">
    <h1 class="display-3 mb-3">Welcome</h1>
    <a class="link-primary fs-3" href="/user">Add user</a> <br><br>
    <a class="link-primary fs-3" href="/user/list">Users list</a> <br><br>

    <?php if(!isset($_COOKIE['login'])):?>
        <a class="link-primary fs-3" href="/login">Login</a> 
    <?php else:?>
        <a class="link-primary fs-3" href="/login/dashboard">Dashboard</a> 
    <?php endif;?>

    </div>
</body>
</html>