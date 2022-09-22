<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Adding users">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Adding users</title>
</head>
<body>
    <?php require_once 'public/blocks/header.php'?>

    <form action="/user" method="post" class="mt-5 mx-auto w-50 justify-content-center form-control">  
        <h4 class="text-center">Add user</h4>
        <div class="form-group">
            <label class="mb-2">Email address:</label>
            <input type="email" name="email" class="form-control mb-2" placeholder="Enter email" value="<? if(isset($_POST['email'])) echo $_POST['email'] ?>">  
        </div>
        <div class="form-group">
            <label class="mb-2">Name:</label>
            <input type="text" name="name" class="form-control mb-2" placeholder="Enter your name" value="<? if(isset($_POST['name'])) echo $_POST['name'] ?>">  
        </div>
        <div class="form-group">
            <label class="mb-2">Surname:</label>
            <input type="text" name="surname" class="form-control mb-2" placeholder="Enter surname" value="<? if(isset($_POST['surname'])) echo $_POST['surname'] ?>">    
        </div>
        <div class="form-group">
            <label class="mb-2">Gender:</label>
            <select name="gender" class="form-select" value="<? if(isset($_POST['gender'])) echo $_POST['gender'] ?>">
                <option value="male" <?php if(isset($_POST['gender']) && ($_POST['gender'] == 'male')) {echo "selected";}?>>
                    Male
                </option>
                <option value="female" <?php if(isset($_POST['gender']) && ($_POST['gender'] == 'female')) {echo "selected";}?>>
                    Female
                </option>
            </select>
        </div>
        <div class="form-group">
            <label class="mb-2 mt-2">Status:</label>
            <select name="status" class="form-select">
                <option value="active" <?php if(isset($_POST['status']) && ($_POST['status'] == 'active')) {echo "selected";}?>>
                    Active
                </option>
                <option  value="inactive" <?php if(isset($_POST['status']) && ($_POST['status'] == 'inactive')) {echo "selected";}?>>
                    Inactive
                </option>
            </select>
        </div>
        <div class="mt-2 text-danger fw-bold errorBlock">
            <?php if(!empty($data['error'])) {echo $data['error'];} ?>
        </div>
        <button type="submit" class="mt-3 mb-2 btn btn-primary">Регистрация</button>
           
    </form>


    <?php require_once 'public/blocks/footer.php'?>
</body>
</html>