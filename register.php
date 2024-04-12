<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Inventory Management System</title>
    <link rel="stylesheet" href="register.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body class="container">
    <div class="Header">
        <h1>
            <hr>Register
            <hr>
        </h1>
    </div>
    <div class="Body">
        <form action="database/add_action.php" method="POST" class="form" name="userForm" id="userForm">
            <div class="loginContainer">
                <label for="first_name">First Name</label>
                <input type="text" class="formDetails" id="first_name" placeholder="first name" name="first_name" />
            </div>
            <div class="loginContainer">
                <label for="last_name">Last Name</label>
                <input type="text" class="formDetails" id="last_name" placeholder="last name" name="last_name">
            </div>
            <div class="loginContainer">
                <label for="email">Email</label>
                <input type="text" class="formDetails" id="email" placeholder="email" name="email">
            </div>
            <div class="loginContainer">
                <label for="location">Location</label>
                <input type="text" class="formDetails" id="location" placeholder="location" name="location">
            </div>
            <div class="loginContainer">
                <label for="phone">Phone Number</label>
                <input type="text" class="formDetails" id="phone" placeholder="phone" name="phone" pattern="[0-9]{10}">
            </div>

            <input type="hidden" name="table" value="users" />
        
            <button type="submit" class="loginButton" id="submit"><i class="fa fa-plus"></i> Sign Up</button>
        </form>



        <div class="accountPrompt">
            Already have an account? <a href="login.php">Login</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#userForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: 'database/register_action.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var data = JSON.parse(response);

                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                allowOutsideClick: false

                            }).then(function() {
                                window.location.href = 'login.php';
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: data.message
                            });
                        }
                    },
                    error: function() {
                        console.error('There was a connection error of some sort');
                    }
                });
            });
        });
    </script>

</body>

</html>