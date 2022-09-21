<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Регистрация</title>
  <meta name="description" content="Регистрация">
</head>
<body>
  <div class="container main">
    <h1>Регистрация</h1>   <br>
    <p>Здесь вы можете зарегистрироваться</p>
    <form action="/user/index" method="post" class="form-control">
      <input type="text" name="name" placeholder="Введите имя" ><br>
      <input type="email" name="email" placeholder="Введите почту"><br>
      <input type="password" name="pass" placeholder="Введите пароль"><br>
      <input type="password" name="re_pass" placeholder="Повторите пароль" ><br>
      <button class="btn" id="send">Регистрация</button>
    </form>
  </div>
</body>
</html>