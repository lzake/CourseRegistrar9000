<html>

<head>
    <title>Login - CourseRegistrar9000</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <?php
// TEMPORARY LOGIN
$value = '1';
setcookie("student_id", $value);
setcookie("student_id", $value, time() + 360000);
setcookie("student_id", $value, time() + 360000, "/~student_id/", "example.com", 1);
?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CourseRegistrar9000</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
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
    <br>
    <?php
include 'db_connection.php';
$conn = OpenCon();
?>

    <form>
        <div class="container">
            <h3>Please Login with your user credentials below!.</h3>
            <div class="row">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">School Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">School Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

</html>