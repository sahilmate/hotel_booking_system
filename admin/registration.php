<?php
include_once 'include/class.user.php'; 
$user = new User(); 

if (isset($_REQUEST['submit'])) { 
    extract($_REQUEST); 

    // Check availability with check-in and check-out dates
    if ($user->check_available($check_in, $check_out)) {
        // Proceed with the registration logic
        $register = $user->reg_user($fullname, $uname, $upass, $uemail); 
        if ($register) { 
            echo "
            <script type='text/javascript'>
                alert('Your Manager has been Added Successfully');
            </script>"; 
            echo "
            <script type='text/javascript'>
                window.location.href = '../admin.php';
            </script>"; 
        } else {
            echo "
            <script type='text/javascript'>
                alert('Registration failed! username or email already exists');
            </script>";
        }
    } else {
        echo "
        <script type='text/javascript'>
            alert('Room not available for the selected dates.');
        </script>";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/reg.css" type="text/css">
    <script language="javascript" type="text/javascript">
        function submitreg() {
            var form = document.reg;
            if (form.fullname.value == "") {
                alert("Enter Full Name.");
                return false;
            } else if (form.uname.value == "") {
                alert("Enter username.");
                return false;
            } else if (form.upass.value == "") {
                alert("Enter Password.");
                return false;
            } else if (form.uemail.value == "") {
                alert("Enter email.");
                return false;
            } else if (form.check_in.value == "") {
                alert("Select check-in date.");
                return false;
            } else if (form.check_out.value == "") {
                alert("Select check-out date.");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="well">
            <h2>Add Your Manager</h2>
            <hr>
            <form action="" method="post" name="reg">
                <div class="form-group">
                    <label for="fullname">Full Name:</label>
                    <input type="text" class="form-control" name="fullname" placeholder="example: Leo Messi" required>
                </div>
                <div class="form-group">
                    <label for="uname">User Name:</label>
                    <input type="text" class="form-control" name="uname" placeholder="example: lionelmessi" required>
                </div>
                <div class="form-group">
                    <label for="uemail">Email:</label>
                    <input type="email" class="form-control" name="uemail" placeholder="example: abc@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="upass">Password</label>
                    <input type="text" class="form-control" name="upass" placeholder="password" required>
                </div>
                <div class="form-group">
                    <label for="check_in">Check-in Date:</label>
                    <input type="date" class="form-control" name="check_in" required>
                </div>
                <div class="form-group">
                    <label for="check_out">Check-out Date:</label>
                    <input type="date" class="form-control" name="check_out" required>
                </div>

                <button type="submit" class="btn btn-lg btn-primary button" name="submit" value="Add Manager" onclick="return(submitreg());">Submit</button>

                <br>
                <div id="click_here">
                    <a href="../admin.php">Back to Admin Panel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
