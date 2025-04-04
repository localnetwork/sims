<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Sims</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <h1>Signup Form</h1>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="fname" class="form-label">Firstname</label>
                    <input type="text" class="form-control" id="fname" placeholder="First Name" name="fname" required>
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="lname" placeholder="Last Name" name="lname" required>
                </div>
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" placeholder="Age" name="age" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Gender</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="2" required>
                        <label class="form-check-label" for="male">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="3" required>
                        <label class="form-check-label" for="female">
                            Female
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="password" name="password" required>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="submit">Sign up</button>
                </div>
            </form>
        </div> 
    </div> 

    <!-- //prevent from resubmission -->
    <script>
        if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
        }
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html> 

<?php
    require_once 'connect.php'; // do not forget to include this to connect to db 

    if (isset($_POST['submit']))
    {
        $fname = isset($_POST['fname'])?$_POST['fname']:'';
        $lname = isset($_POST['lname'])?$_POST['lname']:'';
        $age = isset($_POST['age'])?$_POST['age']:'';
        $gender =isset($_POST['gender'])?$_POST['gender']:'';
        $password =isset($_POST['password'])?$_POST['password']:'';

        // msql query to insert
        $insert = "INSERT INTO student_info(fname,lname,age,gender,password) VALUE('$fname','$lname','$age','$gender','$password')";
        $query=mysqli_query($con, $insert);

        // to check if the data is inserted successfully 
        if($query) {
            header('location:index.php'); 
        }
        else
            echo "<script>alert('Failed to insert')</script>";
    }
 
?>