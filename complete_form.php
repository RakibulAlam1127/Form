<?php
/**
 * Created by Rakib.
 * User: Rakib
 * Date: 2/27/2018
 * Time: 9:17 PM
 */
//Our php code will be gose here..
$errors= [];
$username = $email = $password = $gender = $language = $comments = '';
if (isset($_POST['submit'])) {
    function validation($data)
    {
        $data = htmlspecialchars($data);
        $data = htmlentities($data);
        $data = stripslashes($data);
        $data = trim($data);
        return $data;
    }

    if (empty($_POST['username'])) {
        $errors['username'] = 'Username Field is Required';
    }else{
        $username = validation($_POST['username']);
    }
    if (empty($_POST['email'])){
        $errors['email'] = 'Email Field is Required';
    }else{
        $email = validation($_POST['email']);
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Please Enter The Valid Email';
        }
    }
    if (empty($_POST['password'])){
        $errors['password'] = 'Password Field is Required';
    }else{
        $password = validation($_POST['password']);
        if (strlen($password) < 5){
            $errors['password'] = 'Password Must be at least 6 Character';
        }else{
            $password = sha1($password);
        }
    }
    if (empty($_POST['gender'])){
        $errors['gender'] = 'Please Select Your Gender';
    }else{
        $gender = validation($_POST['gender']);
    }
     if (empty($_POST['language'])){
        $errors['language'] = 'You Must Select One or More';
     }else{
        $language = $_POST['language'];
     }
    if (empty($_POST['comment'])){
        $errors['comment'] = 'Comments Field is Require';
    }else{
        $comments = validation($_POST['comment']);
    }
    if (!isset($_POST['check'])){
        $errors['check'] = 'You Must Agree The terms';
    }
    if (empty($errors)){
        //Database Connection
        $connection = mysqli_connect('localhost','root','','complete_form');
        if ($connection == false){
            echo mysqli_connect_errno();
            exit();
        }else{
            //data insert code will be gose here..
            $insert = "insert into user(username,email,password,gander,language,comments) VALUES ('$username','$email','$password','$gender','$language','$comments')";
            $stmt = mysqli_query($connection,$insert);
            if ($stmt == false){
                echo mysqli_error($connection);
                exit();
            }else{
                $success = 'Welcome!! You are Successfull To Insert Your Data';
            }
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
        <title>Document</title>
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
                            <label for="username">UserName</label>*
                            <input type="text" name="username" class="form-control" placeholder="UserName" autofocus>
                            <?php
                    if (isset($errors['username'])){
                        ?>
                                <div class="alert alert-danger">
                                    <?php echo $errors['username']; ?>
                                </div>
                                <?php
                    }
                    ?>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" class="form-control" placeholder="E-mail" autofocus>
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
                            <input type="password" name="password" class="form-control" placeholder="Password" autofocus>
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
                            <label for="gender">Gender</label>
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
                            <label for="language">Select Your Language</label>
                            <select name="language" class="form-control">
                                <option>Select One</option>
                                <option value="Bangla">Bangla</option>
                                <option value="English">English</option>
                                <option value="Hindi">Hindi</option>
                                <option value="Tamil">Tamil</option>
                                <option value="Urdu">Urdu</option>
                            </select>
                            <?php
                   if (isset($errors['language'])){
                       ?>
                                <div class="alert alert-danger">
                                    <?php echo $errors['language']; ?>
                                </div>
                                <?php
                   }
                   ?>
                        </div>
                        <div class="form-group">
                            <label for="Comments">Comments</label>
                            <textarea name="comment" class="form-control" cols="10" rows="5"></textarea>
                            <?php
                   if (isset($errors['comment'])){
                       ?>
                                <div class="alert alert-danger">
                                    <?php echo $errors['comment']; ?>
                                </div>
                                <?php
                   }
                   ?>
                        </div>
                        <div class="form-group">
                            <label for="agree">Agree</label>
                            <input type="checkbox" name="check" value="1" autofocus>
                            <?php
                   if (isset($errors['check'])){
                       ?>
                                <div class="alert alert-danger">
                                    <?php echo $errors['check']; ?>
                                </div>
                                <?php
                   }
                   ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Submit" class="form-control btn btn-primary">
                        </div>
            </form>

        </div>
    </body>

    </html>