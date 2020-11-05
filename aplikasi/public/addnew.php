<?php 
session_start();
include('inc/API_Client.php');

    if($_POST) {

        $api = new API_Client();
        if (isset($_SESSION['token'])) {
            $api->save_token($_SESSION['token']);

            //$_POST['salary'] = (int)$_POST['salary'];

            $data = $api->go('company/employee', 'POST', $_POST);

            if(isset($data['success']) && $data['success']) {
                ?>
                <script>
                alert('Insert successful');
                window.location.href = 'employees.php';
                </script>
                <?php
                exit();
            } 

        } else {
            header('Location: a_index.php');
        }
        ?>
        <script>
            alert('Error adding new employee');
            window.history.go(-1)
        </script>
        <?php
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company App</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">    
</head>
<body>
    <h1>Add New Employee</h1>

    <div class="container">
        <div class="row">
            <div class="col" id="content">
                <a href="employees.php" class="btn btn-primary mb-1"> &laquo; Back </a>

                <form method="POST">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="fullname" >
                    </div>
                    <div class="form-group">
                        <label>Designation</label>
                        <input type="text" class="form-control" name="designation" >
                    </div>
                    <div class="form-group">
                        <label>Department</label>
                        <input type="text" class="form-control" name="department" >
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <input type="text" class="form-control" name="salary" >
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control" name="status" >
                    </div>
                    <button type="submit" id="post_employee" class="mb-5 btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>    

</body>
</html>