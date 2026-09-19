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

        <!-- Demo accounts (sample credentials) -->
        <div class="sample" role="note">
            <div class="sample-head">
                <div class="avatar" aria-hidden="true">
                    <svg viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Profile picture">
                        <defs>
                            <linearGradient id="avg" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0" stop-color="#a11540"/>
                                <stop offset="1" stop-color="#5c081f"/>
                            </linearGradient>
                        </defs>
                        <circle cx="48" cy="48" r="48" fill="url(#avg)"/>
                        <circle cx="48" cy="38" r="16" fill="#f5c518"/>
                        <path d="M20 82c0-15 12.5-24 28-24s28 9 28 24z" fill="#f5c518"/>
                    </svg>
                </div>
                <div class="who">
                    <span class="name">Peter Parker</span>
                    <span class="role">Demo account · try either role</span>
                </div>
            </div>

            <button type="button" class="sample-row" onclick="fillLogin('21-123123','123','student')">
                <span class="rolebadge student"><ion-icon name="school-outline"></ion-icon> Student</span>
                <span class="cred"><b>Code</b> 21-123123 &nbsp;·&nbsp; <b>Pass</b> 123</span>
                <span class="use">Use</span>
            </button>
            <button type="button" class="sample-row" onclick="fillLogin('123123','123123','staff')">
                <span class="rolebadge staff"><ion-icon name="shield-checkmark-outline"></ion-icon> Staff</span>
                <span class="cred"><b>Code</b> 123123 &nbsp;·&nbsp; <b>Pass</b> 123123</span>
                <span class="use">Use</span>
            </button>
            <p class="sample-note">Click <b>Use</b> to auto-fill and select the role, then press Sign in.</p>
        </div>

        <div class="signin">
            <ion-icon class="icon" name="lock-open-outline"></ion-icon>
            <input type="submit" name="signin" value="Sign in">
        </div>
    </form>
    </div>

    <script>
        function fillLogin(code, pass, role) {
            document.getElementById('student').checked = (role === 'student');
            document.getElementById('admin').checked = (role === 'staff');
            document.getElementById('uname').value = code;
            document.getElementById('pass').value = pass;
            document.getElementById('pass').focus();
        }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
