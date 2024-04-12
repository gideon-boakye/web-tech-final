<?php
session_start();
if (!isset($_SESSION['first_name'])) {
    header('location: logout.php');
}
echo "<script>console.log('Debug Objects: " . $_SESSION['first_name'] . "' );</script>";

?>

<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (isset($_SESSION['first_name'])) {
} else
    header("Location: login.php");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="add_users.css">
    <script src="https://kit.fontawesome.com/7e8518f6c7.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="dashboardMainContainer">
        <?php include('essentials/side_bar.php') ?>
        <div class="dashboard_content_container">
             
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-5 ">
                            <h1 class="section header"><i class="fa fa-plus"></i> Create Order</h1>
                            <div class="addFormConstainer">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function(e) {
                                        document.getElementById('orderForm').reset();
                                    });


                                    document.addEventListener('DOMContentLoaded', function(e) {
                                        document.getElementById('orderForm').reset();

                                        fetch('database/view_products.php')
                                            .then(response => response.json())
                                            .then(data => {
                                                var productSelect = document.getElementById('product_id');
                                                data.forEach(product => {
                                                    var option = document.createElement('option');
                                                    option.value = product.product_id;
                                                    option.textContent = product.name;
                                                    productSelect.appendChild(option);
                                                });
                                            })
                                            .catch(error => console.error('Error:', error));
                                    });
                                </script>
                                <form action="database/add_action.php" method="POST" class="form" name="orderForm" id="orderForm">
                                    <div class="formDetailsContainer">
                                        <label for="product_id">Product</label>
                                        <select multiple class="formDetails" id="product_id" name="product_id[]">
                                            <option value="" disabled>Product</option>
                                        </select>
                                        <small>Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</small>
                                    </div>
                                    <div id="quantityFields">
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="action">Action</label>
                                        <select class="formDetails" id="action" name="action">
                                            <option value="" selected disabled>Action</option>
                                            <option value="order">Order</option>
                                            <option value="recycle">Recycle</option>
                                        </select>
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="serviceprovider">Supplier/Recycler</label>
                                        <select class="formDetails" id="serviceprovider" name="serviceprovider">
                                            <option value="" disabled>Supplier/Recycler</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="table" value="orders" />
                                    <button type="submit" class="formButton">Create Order</button>
                                </form>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                <script>
                                    document.getElementById('product_id').addEventListener('change', function() {
                                        var quantityFields = document.getElementById('quantityFields');
                                        quantityFields.innerHTML = '';
                                        for (var i = 0; i < this.selectedOptions.length; i++) {
                                            var div = document.createElement('div');
                                            div.className = 'formDetailsContainer';
                                            var label = document.createElement('label');
                                            label.for = 'quantity' + this.selectedOptions[i].value;
                                            label.textContent = 'Quantity for ' + this.selectedOptions[i].text;
                                            var input = document.createElement('input');
                                            input.type = 'number';
                                            input.className = 'formDetails';
                                            input.id = 'quantity' + this.selectedOptions[i].value;
                                            input.name = 'quantity[]';
                                            div.appendChild(label);
                                            div.appendChild(input);
                                            quantityFields.appendChild(div);
                                        }
                                    });

                                    $(document).ready(function() {
                                        $('#action').change(function() {
                                            var rolename = this.value === 'order' ? 'supplier' : 'recycler';
                                            $.ajax({
                                                url: 'database/view_users.php',
                                                type: 'GET',
                                                data: {
                                                    rolename: rolename
                                                },
                                                dataType: 'json',
                                                success: function(data) {
                                                    var userSelect = $('#serviceprovider');
                                                    userSelect.empty();
                                                    $.each(data, function(i, user) {
                                                        var option = $('<option>').val(user.user_id).text(user.first_name + ' ' + user.last_name);
                                                        userSelect.append(option);
                                                    });
                                                },
                                                error: function(jqXHR, textStatus, errorThrown) {
                                                    console.error('Error:', textStatus, errorThrown);
                                                }
                                            });
                                        });
                                    });
                                </script>
                                <script src="dashboard.js"></script>
                            </div>
                            <div class="responseMessage">
                                <p id="responseMessageText"></p>
                            </div>
                        </div>
                        <div class="column column-7 ">
                            <h1 class="section header"><i class="fa fa-list"></i> List of Orders</h1>
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
                <script>
                    $(document).ready(function() {
                        $('#orderForm').on('submit', function(e) {
                            e.preventDefault();

                            var formData = new FormData(this);

                            $.ajax({
                                url: 'database/create_order_action.php',
                                type: 'post',
                                data: formData,
                                dataType: 'json',
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    if (response.success) {
                                        $('#responseMessageText').text(response.message).css('color', 'green');
                                        document.getElementById('orderForm').reset();
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
                    });

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