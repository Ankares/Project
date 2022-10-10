<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Dashboard</title>
</head>
<body>
    <?php if(isset($_COOKIE['login'])): ?>
        <div class="container mt-5 text-center p-4">
            <h1>Welcome back, <?=htmlspecialchars($data['user']['name'])?></h1>
            <a class="btn btn-outline-primary fs-4 mt-4 col-5" href="/home">Home</a>
            <form action="/login/dashboard" method="post">
                <input type="hidden" name="logout">
                <button class="btn btn-outline-danger fs-4 mt-3 col-5">Log out</button>
            </form>
        </div>

    <?php else: ?>
        <div class="container mt-5 text-center p-4">
            <h2>You should log in to see your dashboard</h2>
            <a class="btn btn-outline-primary fs-5 mt-4 col-5" href="/login">Login</a>
        </div>
    <?php endif; ?>
</body>
</html>