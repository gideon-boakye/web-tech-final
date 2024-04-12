<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    header('location: logout.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="add_product.css">
    <script src="https://kit.fontawesome.com/7e8518f6c7.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="dashboardMainContainer">
        <?php include('essentials/side_bar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="column column-7 ">
                        <h1 class="section header"><i class="fa fa-list"></i> List of Products</h1>
                        <div class="list_content">
                            <div class="users">
                                <table id="user_list">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Supplier</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
    </div>
    </div>

    <script src="dashboard.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(populateTable);

        function populateTable() {
            $.ajax({
                url: 'database/view_products.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var table = $('#user_list tbody');
                    table.empty();
                    if (data.length > 0) {
                        $.each(data, function(index, product) {
                            var row = '<tr>';
                            row += '<td>' + (index + 1) + '</td>';
                            row += '<td>' + product.name + '</td>';
                            row += '<td>' + product.description + '</td>';
                            row += '<td>' + product.quantity_in_stock + '</td>';
                            row += '<td>' + product.first_name + ' ' + product.last_name + '</td>';
                            row += '<td><button class="deleteButton" data-id="' + product.product_id + '"><i class="fa fa-trash"></i> Delete</button></td>';
                            row += '</tr>';
                            table.append(row);
                        });
                    } else {
                        table.append('<tr><td colspan="6">No products found</td></tr>');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $('#user_list').on('click', '.deleteButton', function() {
            var productId = $(this).data('id');
            $.ajax({
                url: 'database/delete_product.php',
                type: 'POST',
                data: {
                    product_id: productId
                },
                success: function(response) {
                    console.log(response);
                    populateTable();
                },
                error: function() {
                    console.log('Error occurred while deleting product.');
                }
            });
        });
    </script>

</body>

</html>