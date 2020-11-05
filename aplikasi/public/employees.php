<?php 
session_start();
include('inc/API_Client.php');
$api = new API_Client();

if (isset($_SESSION['token'])) {
	$api->save_token($_SESSION['token']);
	$data = $api->go('mycompany/employees');
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
    <h1>Company App</h1>

    <div class="container">
        <div class="row">
            <div class="col" id="content">

<a href="addnew.php" class="btn btn-primary mb-1">Add New</a>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>FULL NAME</th>
                            <th>DESIGNATION</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody id="employees">
                    <!-- <pre><?php print_r($data); ?></pre> -->

                    <?php foreach($data['entry'] as $row) { ?>
                    <tr>
                        <td><?php echo $row['id'];?></td>
                        <td><?php echo $row['fullname'];?></td>
                        <td><?php echo $row['designation'];?></td>
                        <td></td>
                    </tr>
                    <?php } // tutup foreach ?>

                    </tbody>
                </table>


            </div>
        </div>
    </div>    

</body>
</html>