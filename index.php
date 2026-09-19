<?php
// Handle login BEFORE any HTML is output, so header() redirects work
// (avoids "headers already sent" warnings).
include "conn.php";
if (isset($_POST['signin'])) {
    $type = p('select');
    $id = p('uname');
    $password = p('pass');

    // only allow the two known login tables as the FROM target
    if ($type !== 'student_rgo' && $type !== 'employee_rgo') {
        header("location: index.php?MaliPassword");
        exit();
    }

    $qry = "SELECT * FROM $type WHERE code='$id' AND pass='$password'";
    $result = mysqli_query($conn, $qry);
    $row = $result ? mysqli_fetch_array($result) : null;

    if ($result && mysqli_num_rows($result) > 0) {
        switch ($type) {
            case "employee_rgo":
                if ($row['type'] == "staff") {
                    header("location: Staff/home.php?code=$id&type=employee_rgo");
                } else {
                    header("location: Admin/home.php?code=$id&type=employee_rgo");
                }
                break;
            case "student_rgo":
                header("location: Student/home.php?code=$id&type=student_rgo");
                break;
        }
    } else {
        header("location: index.php?MaliPassword");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGO Portal — Login</title>
    <link rel="stylesheet" href="template.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <img class="banner" src="img/student_portal.png" alt="Student Portal">
    <div class="head"><p>Login</p></div>

    <div class="logincontain">
    <form class="loginform" action="index.php" method="POST">
        <div class="form-head">
            <h2>Please Login</h2>
            <span class="sub">Resource Generation Office · BatState-U Lipa</span>
        </div>

        <?php if (isset($_GET['MaliPassword'])): ?>
            <div class="loginerror">Incorrect Sr-Code or password. Please try again.</div>
        <?php endif; ?>

        <div class="field">
            <label for="uname">Sr-Code</label>
            <input id="uname" type="text" name="uname" placeholder="e.g. 21-123123" required>
        </div>
        <div class="field">
            <label for="pass">Password</label>
            <input id="pass" type="password" name="pass" placeholder="Password" required>
        </div>

        <div class="selecta">
            <label for="student"><input type="radio" id="student" value="student_rgo" name="select" checked> Student</label>
            <label for="admin"><input type="radio" id="admin" value="employee_rgo" name="select"> Staff</label>
        </div>

        <p class="case">*password is case sensitive</p>

        <!-- Sample student login (demo credentials) -->
        <div class="sample" role="note">
            <div class="sample-title"><ion-icon name="school-outline"></ion-icon> Sample student login</div>
            <button type="button" class="sample-row" onclick="fillLogin('21-123123','123')">
                <span class="cred"><b>Sr-Code:</b> 21-123123 &nbsp;·&nbsp; <b>Password:</b> 123</span>
                <span class="use">Use</span>
            </button>
            <button type="button" class="sample-row" onclick="fillLogin('21-321321','12345')">
                <span class="cred"><b>Sr-Code:</b> 21-321321 &nbsp;·&nbsp; <b>Password:</b> 12345</span>
                <span class="use">Use</span>
            </button>
            <p class="sample-note">Click “Use” to auto-fill, then press Sign in.</p>
        </div>

        <div class="signin">
            <ion-icon class="icon" name="lock-open-outline"></ion-icon>
            <input type="submit" name="signin" value="Sign in">
        </div>
    </form>
    </div>

    <script>
        function fillLogin(code, pass) {
            var student = document.getElementById('student');
            if (student) student.checked = true;
            document.getElementById('uname').value = code;
            document.getElementById('pass').value = pass;
            document.getElementById('pass').focus();
        }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
