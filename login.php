<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body class="container">
    <div>
        <div class="Header">
            <h1>
                <hr>Inventory Management System
                <hr>
            </h1>
        </div>
        <div class="Body">
            <form method="POST" name="userform" id="userform" class = "form">
                <div class="loginContainer">
                    <label for="email">email</label>
                    <input placeholder="email" name="email" type="text" />
                </div>
                <div class="loginContainer">
                    <label for="password">Password</label>
                    <input placeholder="Enter the identifier you received at sign up" name="password" type="password">
                </div>
                <div class="loginButton">
                    <button type="submit" name="loginSubmit" id="login">Login</button>
                </div>

            </form>
            <div class="loginButton">
                <button><a href="register.php">Don't have an account? Register</a>
                </button>
            </div>

        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#login').click(function(e) {
                e.preventDefault();
                var email = $('input[name=email]').val();
                var password = $('input[name=password]').val();
                $.ajax({
                    url: 'database/login_action.php',
                    type: 'POST',
                    data: {
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            window.location.href = 'add_users.php';
                        } else {
                            alert(data.message);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>