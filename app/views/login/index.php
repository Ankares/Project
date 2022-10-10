<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Adding users">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Login form</title>
</head>
<body>
    <?php require_once "public/blocks/header.php"?>

    <?php if(!isset($_COOKIE['login'])):?>
        <div class="container p-4">
            <form action="/login" method="post" onchange="checkLoginForm(['.inp_email', '.inp_pass'], '.forButton')" class="form-control mt-1 p-4 mx-auto justify-content-center w-50 ">  
                <h2 class="text-center mb-4">Login</h2>
                <div class="form-group fs-4">
                    <label class="mb-2">Email:</label>
                    <input type="email" name="email" class="inp_email form-control mb-2" placeholder="Enter email" value="<? if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']) ?>">  
                </div>
                <div class="form-group fs-4">
                    <label class="mb-2">Password:</label>
                    <input type="password" name="password" class="inp_pass form-control mb-2" placeholder="Enter your password" value="<? if (isset($_POST['password'])) echo htmlspecialchars($_POST['password']) ?>">  
                </div>
                
                <?php if(isset($data['error'])): ?>
                    <div class="error mt-3 fw-bold fs-4 text-danger"><?=htmlspecialchars($data['error'])?></div>
                <?php endif;?>
                <?php if(isset($data['success'])): ?>
                    <div class="success mt-3 fw-bold fs-4 text-success "><?=htmlspecialchars($data['success']);?></div>
                <?php endif;?>
            
                <div class="forButton">

                </div>
            </form>
        </div>

    <?php else: ?>
        <div class="container mt-5 text-center p-4">
            <h2>You are already logged in</h2>
            <a class="btn btn-outline-primary fs-5 mt-4 col-5" href="/login/dashboard">Dashboard</a>
        </div>
    <?php endif;?>

    <?php require_once "public/blocks/footer.php"?>

    <script src="/app/js/script.js"></script>
</body>
</html>