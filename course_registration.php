<html>

<head>
    <title>Course Registration - CourseRegistrar9000</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <?php
    // TEMPORARY LOGIN
    $value = '1';
    setcookie("student_id", $value);
    setcookie("student_id", $value, time()+360000);  
    setcookie("student_id", $value, time()+360000, "/~student_id/", "example.com", 1);
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
    
    $student_id = $_COOKIE["student_id"];
    $ALL_CALLS_LOADED = false;
    $classes_available_loaded = false;
    $classes_enrolled_loaded = false;
    $classes_available = [];
    $classes_enrolled = [];
    $sql_available_classes = '';
    $sql_enrolled_classes = '';

    while (!$classes_available_loaded) {
        $sql_available_classes = $conn->query("SELECT course_title FROM tbl_course WHERE student_count < 20;");
        $classes_available_loaded = true;
    }
    while ($row = mysqli_fetch_array($sql_available_classes)) {
        array_push($classes_available, $row[0]);
    }
    while (!$classes_enrolled_loaded) {
        $sql_enrolled_classes = $conn->query("SELECT course_id FROM tbl_student_course_registered WHERE student_id = '{$student_id}'");
        $classes_enrolled_loaded = true;
    }
    while ($row = mysqli_fetch_array($sql_enrolled_classes)) {
        $course_title = $conn->query("SELECT course_title FROM tbl_course WHERE course_id = {$row[0]}");
        while ($row = mysqli_fetch_array($course_title)) {
            array_push($classes_enrolled, $row[0]);
        }
    }
    
    // entroll in a class
    if(isset($_POST['registration_submit'])) {
       $chosenClass = $_POST['class_chosen'];
       if (in_array($chosenClass, $classes_enrolled)) {
           echo "ALREADY ENROLLED, SELECT ANOTHER CLASS";
       } else {
        //    check in case its bombarded by students and changes vacancy since page load
           $class_still_available = true;
           $sql_check_class_availability = "SELECT student_count FROM tbl_course WHERE course_title = {$chosenClass}";
           $student_count = $sql_check_class_availability[0];
           if ($student_count > 20) {
            $updated_student_count = intval($student_count) + 1;
            // updating student count
            $sql_update_class_student_count = "UPDATE `tbl_course` SET `student_count` = {$updated_student_count} WHERE `tbl_course`.`course_title` = '{$chosenClass}';";
            if ($conn->query($sql_update_class_student_count) !== TRUE) {
                echo "Error: " . $sql_update_class_student_count . "<br>" . $conn->error;
                }
            // retrieve class_id
            $class_id = 0;
            $sql_retrieve_class_id = $conn->query("SELECT course_id FROM tbl_course WHERE course_title = '{$chosenClass}';");
            while ($row = mysqli_fetch_array($sql_retrieve_class_id)) {
                $class_id = $row[0];
            }
            // inserting student record into tbl_student_course_registered
            $sql_insert_student = "INSERT INTO tbl_student_course_registered (student_id, course_id) VALUES ('{$student_id}', '{$class_id}')";
            if ($conn->query($sql_insert_student) === TRUE) {
                echo "Registered for class {$chosenClass}!";
                } else {
                echo "Error: " . $sql_insert_student . "<br>" . $conn->error;
                }
           } else {
               echo "UNFORTUNATELY THE CLASS FILLED UP WHILE YOU WERE LOOKING";
           }
       }
    }

    // de enroll from a class
    if(isset($_POST['disenroll_submit'])) {
        $class_chosen_to_delete = $_POST['class_chosen_to_delete'];
        //retrieve class count
        $sql_check_class_availability = "SELECT student_count FROM tbl_course WHERE course_title = {$class_chosen_to_delete}";
        $student_count = $sql_check_class_availability[0];
        $updated_student_count = intval($student_count) - 1;
        // updating student count
        $sql_update_class_student_count = "UPDATE `tbl_course` SET `student_count` = {$updated_student_count} WHERE `tbl_course`.`course_title` = '{$class_chosen_to_delete}';";
        if ($conn->query($sql_update_class_student_count) !== TRUE) {
            echo "Error: " . $sql_update_class_student_count . "<br>" . $conn->error;
        }
        // retrieve class_id
        $class_id = 0;
        $sql_retrieve_class_id = $conn->query("SELECT course_id FROM tbl_course WHERE course_title = '{$class_chosen_to_delete}';");
        while ($row = mysqli_fetch_array($sql_retrieve_class_id)) {
            $class_id = $row[0];
        }
        // inserting student record into tbl_student_course_registered
        $sql_delete_student = "DELETE FROM tbl_student_course_registered WHERE student_id = {$student_id} AND course_id = {$class_id};";
        if ($conn->query($sql_delete_student) === TRUE) {
            echo "Disenrolled for class {$class_chosen_to_delete}!";
        } else {
        echo "Error: " . $sql_delete_student . "<br>" . $conn->error;
        }
    }
    ?>
    <div class="container">
        <h1>Classes you are currently enrolled for!</h1>
        <?php foreach($classes_enrolled as $class): ?>
        <tr>
            <td>
                <li><?=$class?></li>
            </td>
        </tr>
        <?php endforeach; ?>
    </div>
    <br>
    <br>
    <form method="post">
        <div class="container">
            <h3>Disenroll from a class you are in:</h3>
            <select id="class_chosen_to_delete" name="class_chosen_to_delete">
                <?php
                foreach($classes_enrolled as $class){
                    echo "<option value='$class'>$class</option>";
                }
                ?>
            </select><br>
            <button name="disenroll_submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <br>
    <br>
    <form method="post">
        <div class="container">
            <h3>All University Classes with vacancy:</h3>
            <select id="class_chosen" name="class_chosen">
                <?php
                foreach($classes_available as $class){
                    echo "<option value='$class'>$class</option>";
                }
                ?>
            </select><br>
            <button name="registration_submit" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</body>

</html>