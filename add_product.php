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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="dashboardMainContainer">
        <?php include('essentials/side_bar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section header"><i class="fa fa-plus"></i> Add Product</h1>
                            <div class="addFormContainer">
                                <form action="database/add.php" method="POST" class="form" name="productform" id="productform">
                                    <div class="formDetailsContainer">
                                        <label for="name">Product Name</label>
                                        <input type="text" class="formDetails" id="name" placeholder="Enter product name" name="name" />
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="description">Description</label>
                                        <textarea class="formDetails descriptionInputBox" id="description" placeholder="Enter product description" name="description" value="">
                                        </textarea>
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="quantity">Quantity In Stock</label>
                                        <input type="number" class="formDetails" id="quantity" placeholder="Enter quantity in stock" name="quantity" />
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="supplier">Supplier</label>
                                        <select class="formDetails" id="supplier" name="supplier">
                                            <option value="" disabled selected>Select Supplier</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="addProductButton" id="submit"><i class="fa fa-plus"></i> Add Product</button>
                                </form>
                                <div class="responseMessage">
                                    <p id="responseMessageText"></p>
                                </div>
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
                        <div id=modal" style = "display: none;">
                            <div class="modal-content">
                                <span id = "close" class="close">&times;</span>
                                <h2>Edit Product</h2>
                                <form action="database/edit_product.php" method="POST" class="form" name="editproductform" id="editproductform">
                                    <div class="formDetailsContainer">
                                        <label for="name">Product Name</label>
                                        <input type="text" class="formDetails" id="editname" placeholder="Enter product name" name="name" />
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="description">Description</label>
                                        <textarea class="formDetails descriptionInputBox" id="editdescription" placeholder="Enter product description" name="description" value="">
                                        </textarea>
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="quantity">Quantity In Stock</label>
                                        <input type="number" class="formDetails" id="editquantity" placeholder="Enter quantity in stock" name="quantity" />
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="supplier">Supplier</label>
                                        <select class="formDetails" id="editsupplier" name="supplier">
                                            <option value="" disabled selected>Select Supplier</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="addProductButton" id="submit"><i class="fa fa-plus"></i> Edit Product</button>
                                </form>
                                <div class="responseMessage">
                                    <p id="responseMessageText"></p>
                                </div>
                            </div>
                            <script>
                                
                                document.querySelector('.addProductButton').addEventListener('click', function() {
                                    var productId = this.getAttribute('data-id');
                                    $.ajax({
                                        url: 'database/edit_product.php',
                                        type: 'POST',
                                        data: {
                                            name: document.getElementById('editname').value,
                                            description: document.getElementById('editdescription').value,
                                            quantity: document.getElementById('editquantity').value,
                                            supplier: document.getElementById('editsupplier').value,
                                            product_id: productId
                                        },
                                        success: function(response) {
                                            var responseMessage = document.getElementById('responseMessageText');
                                            responseMessage.innerText = response.message;
                                            console.log(response);
                                            console.log(response.success);
                                            if (response.success) {
                                                responseMessage.style.color = 'green';
                                                document.getElementById('editproductform').reset();
                                                populateTable();
                                            } else {
                                                responseMessage.style.color = 'red';
                                            }
                                        },
                                        error: function() {
                                            console.log('Error occurred while adding product.');
                                        }
                                    });
                                });
                                

                                $(document).ready(function() {
                                    $.ajax({
                                        url: 'database/fetch_user_group.php',
                                        type: 'GET',
                                        data: {
                                            rolename: 'supplier'
                                        },
                                        success: function(response) {
                                            if (response.status === 'success') {
                                                var supplierDropdown = document.getElementById('editsupplier');
                                                supplierDropdown.innerHTML = '<option value="" disabled selected>Select Supplier</option>';
                                                response.data.forEach(function(supplier) {
                                                    var option = document.createElement('option');
                                                    option.value = supplier.user_id;
                                                    option.text = supplier.first_name + ' ' + supplier.last_name;
                                                    supplierDropdown.appendChild(option);
                                                });
                                            }
                                        },
                                        error: function() {
                                            console.log('Error occurred while fetching suppliers.');
                                        }
                                    });
                                });
                            </script>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <script src="dashboard.js"></script>

        <script>
            $(document).ready(function() {
                $.ajax({
                    url: 'database/fetch_user_group.php',
                    type: 'GET',
                    data: {
                        rolename: 'supplier'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            var supplierDropdown = document.getElementById('supplier');
                            supplierDropdown.innerHTML = '<option value="" disabled selected>Select Supplier</option>';
                            response.data.forEach(function(supplier) {
                                var option = document.createElement('option');
                                option.value = supplier.user_id;
                                option.text = supplier.first_name + ' ' + supplier.last_name;
                                supplierDropdown.appendChild(option);
                            });
                        }
                    },
                    error: function() {
                        console.log('Error occurred while fetching suppliers.');
                    }
                });
            });

            document.getElementById('productform').addEventListener('submit', function(event) {
                event.preventDefault();
                var name = document.getElementById('name').value;
                var description = document.getElementById('description').value.trim();
                var quantity = document.getElementById('quantity').value;
                var supplier = document.getElementById('supplier').value;

                $.ajax({
                    url: 'database/add_product_action.php',
                    type: 'POST',
                    data: {
                        name: name,
                        description: description,
                        quantity: quantity,
                        supplier: supplier
                    },
                    success: function(response) {
                        var responseMessage = document.getElementById('responseMessageText');
                        responseMessage.innerText = response.message;
                        console.log(response);
                        console.log(response.success);
                        if (response.success) {
                            responseMessage.style.color = 'green';
                            document.getElementById('productform').reset();
                            populateTable();
                        } else {
                            responseMessage.style.color = 'red';
                        }
                    },
                    error: function() {
                        console.log('Error occurred while adding product.');
                    }
                });
            });

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