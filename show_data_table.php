<?php
 //Our php code will be gose here.
$errors = [];
$name = $email = $password = $gender = $dept = $file = '';
if (isset($_POST['submit'])) {
    function validation($data)
    {
        $data = htmlentities($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        $data = trim($data);
        return $data;
    }

    if (empty($_POST['name'])) {
        $errors['name'] = 'Name Field id Required';
    } else {
        $name = validation($_POST['name']);
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'Email Field id Required';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please Enter The Valid Eamil';
        } else {
            $email = validation($email);
        }
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password Field is Required';
    } else {
        $password = validation($_POST['password']);
        if (strlen($password) < 5) {
            $errors = 'Password Must Be at least 6 Character';
        } else {
            $password = sha1($password);
        }
    }
    if (empty($_POST['gender'])) {
        $errors['gender'] = 'Please Select Your Gender';
    } else {
        $gender = validation($_POST['gender']);
    }
    if (empty($_POST['dept'])) {
        $errors['dept'] = 'Please Select Your Department';
    } else {
        $dept = $_POST['dept'];
    }
    if (empty($_FILES['file']['name'])) {
        $errors['file'] = 'Please Uploard Your Image';
    }else{
       $file = $_FILES['file']['name'];
    }
    if (empty($errors)){
       $connection = mysqli_connect('localhost','root','','show_data_table');
       if ($connection == true){
           $new_data = explode('.',$_FILES['file']['name']);
           $ext = end($new_data);
           $new_file = uniqid('oo_',true).' . '.$ext;
          $uploard = move_uploaded_file($_FILES['file']['tmp_name'],'image/'.$new_file);
          if ($uploard == true){
            $sql = "insert into user(name,email,password,gander,department,image) VALUES ('$name','$email','$password','$gender','$dept','$file')";
             $stmt = mysqli_query($connection,$sql);
             if ($stmt === true){
                 $success = 'Registration SuccessFully';
             }else{
                 echo mysqli_error($connection);
                 exit();
             }
          }else{
              $errors['file'] = 'File Uploard UnsuccessFully';
          }
       }else{
           echo mysqli_connect_errno();
           exit();
       }
    }


}



?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Show data table</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
            crossorigin="anonymous">

    </head>

    <body>
        <div class="container col-md-6">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <?php
              if (isset($success)){
                  ?>
                    <div class="alert alert-success">
                        <?php echo $success; ?>
                    </div>
                    <?php
              }
              ?>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" autofocus>
                            <?php
                       if (isset($errors['name'])){
                           ?>
                                <div class="alert alert-danger">
                                    <?php echo $errors['name']; ?>
                                </div>
                                <?php
                       }
                   ?>
                        </div>

                        <div class="form-group">
                            <label for="name">E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" autofocus>
                            <?php
                  if (isset($errors['email'])){
                      ?>
                                <div class="alert alert-danger">
                                    <?php echo $errors['email']; ?>
                                </div>
                                <?php
                  }
                  ?>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="password" autofocus>
                            <?php
                  if (isset($errors['password'])){
                      ?>
                                <div class="alert alert-danger">
                                    <?php echo $errors['password']; ?>
                                </div>
                                <?php
                  }
                  ?>
                        </div>
                        <div class="form-group">
                            <label for="gender">Select Your Gender</label>
                            <br>
                            <input type="radio" name="gender" value="Male">Male
                            <input type="radio" name="gender" value="Female">Female
                            <?php
                  if (isset($errors['gender'])){
                      ?>
                                <div class="alert alert-danger">
                                    <?php echo $errors['gender']; ?>
                                </div>
                                <?php
                  }
                  ?>
                        </div>
                        <div class="form-group">
                            <label for="dept">Select Department</label>
                            <select name="dept" class="form-control">
                                <option>Select One</option>
                                <option value="cse">Computer Science & Engineering</option>
                                <option value="swe">Software Engineering</option>
                                <option value="eee">Electrical & Electronic Engineering</option>
                                <option value="civil">Civil & Engineering</option>
                            </select>
                            <?php
                  if (isset($errors['dept'])){
                      ?>
                                <div class="alert alert-danger">
                                    <?php echo $errors['dept']; ?>
                                </div>
                                <?php
                  }
                  ?>
                        </div>
                        <div class="form-group">
                            <label for="file">Uploard Photo</label>
                            <input type="file" name="file" class="form-control" autofocus>
                            <?php
                   if (isset($errors['file'])){
                       ?>
                                <div class="alert alert-danger">
                                    <?php echo $errors['file']; ?>
                                </div>
                                <?php
                   }
                   ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control btn btn-primary" name="submit" value="Sign In">
                        </div>
            </form>
        </div>
    </body>

    </html>