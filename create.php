<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $address = $age = $phone_num = $roll_num = $password =  $email = "";
$name_err = $address_err = $age_err = $phone_err = $roll_err = $password_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    

    // Validate phone number
    $input_phone = trim($_POST["phone"]);
    if(empty($input_phone)){
        $phone_err = "Please enter an phone number.";     
    } else{
        $phone = $input_phone;
    }

    // Validate age
    $input_age = (int)($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Please enter your age.";     
    } else{
        $age = $input_age;
    }

    // Validate roll number
    $input_roll_number = trim($_POST["roll"]);
    if(empty($input_roll_number)){
        $roll_err = "Please enter your roll number.";     
    } else{
        $roll_num = $input_roll_number;
    }

    //Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter your email.";     
    } else{
        $email = $input_email;
    }

    $input_password = trim($_POST["password"]);
    if(empty($input_password)){
        $password_err = "Please enter your password.";     
    } else{
        $password = $input_password;
    }

    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($email_err) && empty($age_err) && empty($phone_err) && empty($roll_err) && empty($password_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO student (name, age,phone_num, roll_num, password, email) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_age, $param_phone, $param_roll, $param_password, $param_email);
            
            // Set parameters
            $param_name = $name;
            $param_age = $age;
            $param_phone = $phone;
            $param_roll = $roll_num;
            $param_password = $password;
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Add New Student</h2>
                    <p>Please fill this form and submit to add new student.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $phone_num; ?>">
                            <span class="invalid-feedback"><?php echo $phone_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Age</label>
                            <input type="text" name="age" class="form-control <?php echo (!empty($age_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $age; ?>">
                            <span class="invalid-feedback"><?php echo $age_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Roll Number</label>
                            <input type="text" name="roll" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $roll_num; ?>">
                            <span class="invalid-feedback"><?php echo $roll_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="paaword" name="password" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>