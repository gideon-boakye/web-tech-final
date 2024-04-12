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
                        <div class="column column-5">


                            <h1 class="section header"><i class="fa fa-plus"></i> Add User</h1>
                            <div class="addFormContainer">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function(e) {
                                        document.getElementById('userForm').reset();
                                    });
                                </script>
                                <form action="database/add_action.php" method="POST" class="form" name="userForm" id="userForm">
                                    <div class="formDetailsContainer">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="formDetails" id="first_name" placeholder="first name" name="first_name" />
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="formDetails" id="last_name" placeholder="last name" name="last_name">
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="email">Email</label>
                                        <input type="text" class="formDetails" id="email" placeholder="email" name="email">
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="location">Location</label>
                                        <input type="text" class="formDetails" id="location" placeholder="location" name="location">
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="formDetails" id="phone" placeholder="phone" name="phone" pattern="[0-9]{10}">
                                    </div>
                                    <div class="formDetailsContainer">
                                        <label for="usertype">User Type</label>
                                        <select class="formDetails" id="usertype" placeholder="User Type" name="usertype">
                                            <option value=2 selected>Supplier</option>
                                        </select>
                                    </div>

                                    <input type="hidden" name="table" value="users" />
                                    <button type="submit" class="addUserButton" id="submit"><i class="fa fa-plus"></i> Add User</button>
                                </form>

                                <div class="responseMessage">
                                    <p id="responseMessageText"></p>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="column column-7 ">
                        <h1 class="section header"><i class="fa fa-list"></i> List of Suppliers</h1>
                        <div class="list_content">
                            <div class="users">
                                <table id="user_list">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="editUserModal" class="editUserModal" style="display: none;">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Edit User</h2>
                        <form action="database/edit_user_action.php" method="POST" class="form" name="editUserForm" id="editUserForm">
                            <div class="formDetailsContainer">
                                <label for="edit_first_name">First Name</label>
                                <input type="text" class="formDetails" id="edit_first_name" placeholder="first name" name="edit_first_name" />
                            </div>
                            <div class="formDetailsContainer">
                                <label for="edit_last_name">Last Name</label>
                                <input type="text" class="formDetails" id="edit_last_name" placeholder="last name" name="edit_last_name">
                            </div>
                            <div class="formDetailsContainer">
                                <label for="edit_email">Email</label>
                                <input type="text" class="formDetails" id="edit_email" placeholder="email" name="edit_email">
                            </div>
                            <div class="formDetailsContainer">
                                <label for="edit_location">Location</label>
                                <input type="text" class="formDetails" id="edit_location" placeholder="location" name="edit_location">
                            </div>
                            <div class="formDetailsContainer">
                                <label for="edit_phone">Phone Number</label>
                                <input type="text" class="formDetails" id="edit_phone" placeholder="phone" name="edit_phone" pattern="[0-9]{10}">
                            </div>

                            <input type="hidden" name="edit_user_id" id="edit_user_id" />
                            <button type="submit" class="editUserButton" id="edit_submit"><i class="fa fa-edit"></i> Update User</button>
                        </form>
                    </div>
                </div>
                <script>
                    $(document).on('click', '.edit-user', function(e) {
                        e.preventDefault();
                        var userId = $(this).attr('href');
                        $.ajax({
                            url: 'database/fetch_user_details.php',
                            type: 'post',
                            data: {
                                user_id: userId
                            },
                            dataType: 'json',
                            success: function(response) {
                                $('#edit_user_id').val(response.user_id);
                                $('#edit_first_name').val(response.first_name);
                                $('#edit_last_name').val(response.last_name);
                                $('#edit_email').val(response.email);
                                $('#edit_location').val(response.location);
                                $('#edit_phone').val(response.phone);
                                $('#editUserModal').css('display', 'block');
                            },
                            error: function() {
                                alert('Error fetching user details');
                            }
                        });
                    });

                    $('.close').click(function() {
                        $('#editUserModal').css('display', 'none');
                    });

                    $(window).click(function(e) {
                        if (e.target == document.getElementById('editUserModal')) {
                            $('#editUserModal').css('display', 'none');
                        }
                    });

                    document.getElementById('editUserForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        var formData = new FormData(this);
                        
                        var request = new XMLHttpRequest();
                        request.open('POST', 'database/edit_user_action.php', true);
                        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                        request.onload = function() {
                            if (request.status >= 200 && request.status < 400) {
                                var response = JSON.parse(request.responseText);
                                var messageP = document.getElementById('responseMessageText');
                                messageP.className = response.success ? 'responseMessage__success' : 'responseMessage__error';
                                messageP.textContent = response.message;
                                document.getElementById('editUserForm').reset();
                                populateTable();
                                $('#editUserModal').css('display', 'none');
                            } else {
                                console.error('Server reached, but it returned an error');
                            }
                        };
                        request.onerror = function() {
                            console.error('There was a connection error of some sort');
                        };
                        request.send(formData);
                    });
                </script>

            </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="dashboard.js"></script>
    <script>
         
        var count = 0;
        $(document).ready(populateTable);

        document.getElementById('userForm').addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            var request = new XMLHttpRequest();

            request.open('POST', 'database/add_action.php', true);
            request.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); // Set the request header if you need to handle Ajax specifically in your PHP

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var response = JSON.parse(request.responseText);
                    var messageP = document.getElementById('responseMessageText');

                    messageP.className = response.success ? 'responseMessage__success' : 'responseMessage__error';
                    messageP.style.color = response.success ? 'green' : 'red';
                    messageP.textContent = response.message;
                    document.getElementById('userForm').reset();
                    populateTable();

                } else {
                    console.error('Server reached, but it returned an error');
                }
            };

            request.onerror = function() {
                console.error('There was a connection error of some sort');
            };

            request.send(formData);
        });

        function populateTable() {
            $.ajax({
                url: 'database/view_users.php',
                type: 'GET',
                data: {
                    rolename: 'supplier'
                },
                dataType: 'json',
                success: function(data) {
                    var table = $('#user_list tbody');
                    table.empty();
                    if (data.length > 0) {
                        $.each(data, function(index, user) {
                            count++;
                            var row = '<tr>';
                            row += '<td>' + count + '</td>';
                            row += '<td>' + user.first_name + '</td>';
                            row += '<td>' + user.last_name + '</td>';
                            row += '<td>' + user.email + '</td>';
                            row += '<td>' +
                                ' <a class = "edit-user" href="' + user.user_id + '"><i class="fa-regular fa-pen-to-square" style="color: #000000;"></i></a>' +
                                ' <a class = "edit-user" href="' + user.user_id + '"><i class="fa-solid fa-trash" style="color: #000000;"></i></a></td>';
                            row += '</tr>';
                            $('#user_list tbody').append(row);
                        });
                    } else {
                        $('#user_list tbody').html('<tr><td colspan="6">No results found.</td></tr>');
                    }
                },

                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        $(document).on('click', '.delete-user', function(e) {
            e.preventDefault();

            var userId = $(this).attr('href');

            $.ajax({
                url: 'database/delete_user_action.php',
                type: 'post',
                data: {
                    user_id: userId
                },
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    populateTable();
                },
                error: function() {
                    alert('Error deleting user');
                }
            });
        });
    </script>
</body>

</html>