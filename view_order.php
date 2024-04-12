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
    <link rel="stylesheet" href="add_users.css">
    <script src="https://kit.fontawesome.com/7e8518f6c7.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="dashboardMainContainer">
        <?php include('essentials/side_bar.php') ?>
        <div class="dashboard_content_container">
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-5 ">
                            <h1 class="section header"><i class="fa fa-plus"></i> All Orders</h1>

                            <div class="list_content">
                                <div class="users">
                                    <table id="user_list">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Action</th>
                                            <th>Status</th>
                                            <th>Service Provider</th>
                                            <th>Products</th>
                                            <th>Actions</th>
                                        </tr>
                                        <tbody id="user_list_body">
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


    <script>
        function populateTable() {
            $.ajax({
                url: 'database/fetch_all_orders.php',
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    var tableBody = '';
                    $.each(data, function(index, order) {
                        tableBody += '<tr>';
                        tableBody += '<td>' + order.order_id + '</td>';
                        tableBody += '<td>' + order.action + '</td>';
                        tableBody += '<td>' + (order.status == '0' ? 'Not Complete' : 'Complete') + '</td>';
                        tableBody += '<td>' + order.user.first_name + ' ' + order.user.last_name + '</td>';
                        tableBody += '<td>';
                        $.each(order.products, function(index, product) {
                            tableBody += '<ul>';
                            tableBody += '<li>Quantity: ' + product.quantity + '</li>';
                            tableBody += '<li>Product Name: ' + product.name + '</li>';
                            tableBody += '<li>Product Description: ' + product.description + '</li>';
                            tableBody += '</ul>';
                        });
                        tableBody += '</td>';
                        if (order.status == '0') {
                            tableBody += '<td><button class="completeOrder" data-order-id="' + order.order_id + '">Mark as Complete</button>';
                            tableBody += '<button class="cancelOrder" data-order-id="' + order.order_id + '">Cancel Order</button></td>';
                        }
                        tableBody += '</tr>';
                    });
                    $('#user_list_body').html(tableBody);
                },
                error: function() {
                    alert('Error fetching data');
                }
            });
        }

        $(document).ready(function() {
            populateTable();
        });

        $(document).on('click', '.completeOrder', function() {
            var orderId = $(this).data('order-id');

            $.ajax({
                url: 'database/complete_order.php',
                type: 'post',
                data: {
                    order_id: orderId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#responseMessageText').text(response.message).css('color', 'green');
                        populateTable();
                    } else {
                        $('#responseMessageText').text(response.message).css('color', 'red');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#responseMessageText').text('An error occurred: ' + textStatus).css('color', 'red');
                }
            });
        });

        $(document).on('click', '.cancelOrder', function() {
            var orderId = $(this).data('order-id');

            $.ajax({
                url: 'database/cancel_order.php',
                type: 'post',
                data: {
                    order_id: orderId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#responseMessageText').text(response.message).css('color', 'green');
                        populateTable();
                    } else {
                        $('#responseMessageText').text(response.message).css('color', 'red');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#responseMessageText').text('An error occurred: ' + textStatus).css('color', 'red');
                }
            });
        });
    </script>
</body>

</html>