<?php
// connect to db
include('conn.php');

session_start(); // بدء الجلسة

// التحقق من تسجيل الدخول
if (!isset($_SESSION['admin_users'])) {
    session_destroy(); // حذف الجلسة إذا كانت غير صالحة
    header("Location: login.php"); // إعادة التوجيه لصفحة تسجيل الدخول
    exit();
}else
{
    $admin_users = $_SESSION['admin_users'];
    
    $sql_1 = "SELECT fields_data, created_at, ip_address FROM users ORDER BY id DESC ";
    $users_result = $conn->query($sql_1);
    $user_data = [];

    if ($users_result) {
        while ($row = $users_result->fetch_assoc()) {
            $user_data[] = [
                "fields_data" => $row["fields_data"],
                "visit_date" => $row["created_at"]
            ];
        }
    }
    $last_four_users = array_slice($user_data, 0, 5);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ASU Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    
    <link rel="icon" type="image/png" href="img/logo.png"/>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    
    <link href="./lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="./lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    
    <link href="./css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        


        
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary">ASU Dashboard</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="img/user2.png" alt="" style="width: 70px; height: 70px;">
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $admin_users ?></h6>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="index.php" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="events.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Events</a>
                    <a href="forms.php" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>forms</a>
                    <a href="users.php" class="nav-item nav-link"><i class="fa fa-user me-2"></i>Users</a>
                    <a href="about.php" class="nav-item nav-link"><i class="fa fa-info-circle me-2"></i>About</a>
                    <a href="logout.php" class="nav-item nav-link"><i class="fa fa-sign-out-alt me-2"></i>Logout</a>
                </div>
            </nav>
        </div>
        


        
        <div class="content">
            
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="img/user.png" alt="" style="width: 50px; height: 50px;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="index.php" class="dropdown-item">Dashboard</a>
                            <a href="events.php" class="dropdown-item">Events</a>
                            <a href="forms.php" class="dropdown-item">forms</a>
                            <a href="users.php" class="dropdown-item">Users</a>
                            <a href="about.php" class="dropdown-item">About</a>
                            <a href="logout.php" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </nav>
            

            
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">Today Visitors</h6>
                            </div>
                            <canvas id="worldwide-sales"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary text-center rounded p-4">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <h6 class="mb-0">All Visitors</h6>
                            </div>
                            <canvas id="salse-revenue"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            


            
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Registered</h6>
                        <a href="users.php">Show All</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th scope="col">Date</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Grade</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Choose</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($last_four_users){
                                        foreach ($last_four_users as $row) {
                                            echo' 
                                                <tr>
                                                    <td>' . htmlspecialchars($row["user_name"]) . '</td>
                                                    <td>' . htmlspecialchars($row["visit_date"]) . '</td>
                                                    <td>' . htmlspecialchars($row["user_number"]) . '</td>
                                                    <td>' . htmlspecialchars($row["grade"]) . '</td>
                                                    <td>' . htmlspecialchars($row["choosen"]) . '</td>
                                                </tr>
                                        ';}
                                    }else{
                                        echo' 
                                        <tr>
                                            <td> None </td>
                                            <td> None </td>
                                            <td> None </td>
                                            <td> None </td>
                                            <td> None </td>
                                        </tr>
                                        ';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            

            
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="https://maok3ak.rf.gd">Maok3ak</a>, All Right Reserved. 
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            Designed By <a href="https://maok3ak.rf.gd">EssamAboElmgd</a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        


        
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    
    <script src="js/main.js"></script>
</body>

</html>


<?php 
}
?>