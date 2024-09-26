<?php
$servername = "localhost"; 
$username = "root"; 
$password = "Kenc1k06"; 
$dbname = "olx_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $active = isset($_POST['active']) ? 1 : 0;

    $sql = "INSERT INTO category (name, number, active) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $name, $number, $active);

    if ($stmt->execute()) {
        echo "<script>alert('Category added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding category: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Category</title>
    <link href="admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="admin/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admin.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin page</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Main page</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="add_category.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Add category</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="add_products.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Add products</span>
                </a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>
            </nav>

            <div class="container-fluid">
                <h1 class="h3 mb-2 text-gray-800">Add New Category</h1>
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="name">Category Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="number">Number</label>
                                <input type="number" class="form-control" id="number" name="number" required>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="active" name="active">
                                <label class="form-check-label" for="active">Active</label>
                            </div>
                            <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="admin/vendor/jquery/jquery.min.js"></script>
    <script src="admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="admin/js/sb-admin-2.min.js"></script>
</body>

</html>
