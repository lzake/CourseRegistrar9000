<html>

<head>
    <title>User Registration - CourseRegistrar9000</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CourseRegistrar9000</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_registration.php">User Registration</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="login.php">User Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="course_registration.php">Course Registration</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <br>
    <?php
    include 'db_connection.php';
    $conn = OpenCon();
    if (isset($_POST['button_submit'])) {
        $InputEmail = '';
        $InputPhone = '';
        $InputPassword1 = '';
        $InputPassword2 = '';
        $PasswordMatch = False;
        $Password = '';
        if (!empty($_POST['InputEmail'])) {
            $InputEmail = $_POST['InputEmail'];
        }
        if (!empty($_POST['InputPhone'])) {
            $InputPhone = $_POST['InputPhone'];
        }
        if (!empty($_POST['InputPassword1']) && !empty($_POST['InputPassword2'])) {
            $InputPassword1 = $_POST['InputPassword1'];
            $InputPassword2 = $_POST['InputPassword2'];
            if ($InputPassword1 === $InputPassword2) {
                $InputPassword1 = $_POST['InputPassword1'];
                $Password = "{$InputPassword1}fakeSalting";
                $PasswordMatch = True;
            }
        }
        if ($PasswordMatch === True) {
            $sql = "INSERT INTO tbl_student (student_email, student_hashed_password, student_phone) VALUES ('{$InputEmail}', '{$Password}', '{$InputPhone}')";
            echo $sql;
            if ($conn->query($sql) === TRUE) {
                echo "Student Account Created!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "PASSWORDS DONT MATCH";
        }
    }
    ?>
    <br>
    <form method="post">
        <div class="container">
            <h3>This page will be used to register a new account using your provided school
                email address.</h3>
            <div class="row">
                <div class="mb-3">
                    <label for="InputEmail" class="form-label">School Email address</label>
                    <input type="email" class="form-control" id="InputEmail" name="InputEmail" aria-describedby="emailHelp">
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="InputPhone" class="form-label">Phone Number</label>
                    <input type="password" class="form-control" name="InputPhone" id="InputPhone">
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="InputPassword1" class="form-label">Please Enter a Password</label>
                    <input type="password" class="form-control" name="InputPassword1" id="InputPassword1">
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="InputPassword2" class="form-label">Please Enter the Password Again</label>
                    <input type="password" class="form-control" name="InputPassword2" id="InputPassword2">
                </div>
            </div>
            <div class="row">
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="Check1">
                    <label class="form-check-label" for="Check1">Stay logged in after creation!</label>
                </div>
            </div>
            <button name="button_submit" type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

</html>