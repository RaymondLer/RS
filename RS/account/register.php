<?php
include'../_config.php';
$page->title = 'Registration';
$page->header();
?>

$username = $password = $confirm = $email = $phone = $gender = '';
$err = [];
$pdo = $page->pdo();

if($page->is

<form id='register' action='register.php' method="post">
    <div class="form">
        <h1>Register</h1>
        <fieldset>
            <div>
                <label for="username">Username:</label>
                <input for="">
            </div>

            <div>
                <label for="password">Password:</label>
                <input for="">
            </div>

            <div>
                <label for="confirm">Confirm Password:</label>
                <input for="">
            </div>
            
             <div>
                <label for="email">Email Address:</label>
                <input for="">
            </div>

            <div>
                <label for="phone">Phone:</label>
                <input for="">
            </div>
            
            <div>
                <label for="gender">Gender</label>
                <input for="checkbox" name="gender" value="Male">
                <input for="checkbox" name="gender" value="Female">
            </div>
            </div>
            
        </fieldset>
    </div>
</form>







<?php
$page->footer();
?>