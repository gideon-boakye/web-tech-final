<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    header('location: logout.php');
}

?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://kit.fontawesome.com/7e8518f6c7.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="dashboardMainContainer">
        <div class="dashboard_sidebar">
            <div class="dashboard_sidebar_user">
                <img src="images/149071.png" alt="User image." />
                <span>Gideon</span>
            </div>
             
            <div class="dashboard_sidebar_menus">
                <ul class="dashboard_menu_lists">
                     
                    <li class="menuActive">
                        <a href="#">
                            <i class="fa fa-dashboard"></i> Product <i class="fa fa-angle-up nest"></i>
                        </a>
                        <ul class="subMenus">
                            
                            <li><a href=" view_product.php" class="vplink"><i class="fa fa-circle-o"></i> View Product</a></li>
                            <li><a href="add_product.php" class="aplink"><i class="fa fa-circle-o"></i> Add Product</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-truck"></i> Supplier <i class="fa fa-angle-up nest"></i>
                        </a>
                        <ul class="subMenus">
                            <li><a href="view_supplier.php" class="vslink"><i class="fa fa-circle-o"></i> View Supplier</a></li>
                            <li><a href="add_supplier.php" class="aslink"><i class="fa fa-circle-o"></i> Add Supplier</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-shopping-cart"></i> Order <i class="fa fa-angle-up nest"></i>
                        </a>
                        <ul class="subMenus">
                            <li><a href="create_order.php"><i class="fa fa-circle-o"></i> Create Order</a></li>
                            <li><a href="view_order.php"><i class="fa fa-circle-o"></i> View Orders</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="add_users.php">
                            <i class="fa fa-user-plus"></i> Add User <i class=""></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="dashboard_logout">
                <a href="login.php" class="logout"><i class="fa fa-power-off"></i> Log-out</a>
            </div>
        </div>
        <div class="dashboard_content_container">
             
        </div>
    </div>
    <script src="dashboard.js"></script>
</body>

</html>