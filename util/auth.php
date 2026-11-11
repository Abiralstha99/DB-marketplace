<?php
// Author: Raiyat Haque
// login and logout functions for Campus Marketplace
// session variables set at login: $_SESSION['uid'], $_SESSION['name'], $_SESSION['role']

session_start();


// shows login form
// action is performed in login.php
// $email refills the email box after a failed login
function showLoginForm($email = "") {
    $email = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
?>
    <div class="auth-card">
    <h1>Log In</h1>
    <p class="auth-subtitle">Use your Gettysburg email to buy and sell on campus.</p>

    <form name='fmLogin' method='POST' action='login.php'>

    <div class="mb-3">
    <label class="form-label" for='email'>Email</label>
    <input class="form-control" type='email' name='email' id='email' placeholder='you@gettysburg.edu' value='<?= $email ?>' autocomplete='username' required />
    </div>

    <div class="mb-3">
    <label class="form-label" for='password'>Password</label>
    <input class="form-control" type='password' name='password' id='password' autocomplete='current-password' required />
    </div>

    <button class="auth-button" type='submit'>Log In</button>

    </form>
    </div>
<?php
}


// checks the email and password
// returns "" if login worked and saves the user in $_SESSION
// returns an error message if it did not
function loginUser($db, $email, $password) {

    $query = "SELECT user_id, password_hash, first_name, role, account_status
              FROM   users
              WHERE  email=?";

    $sql = $db->prepare($query);
    $sql->execute([$email]);

    $user = $sql->fetch();   // FALSE if no user has this email

    if ($user == FALSE) {
        return "Wrong email or password";
    }

    // passwords are stored hashed, so we compare with password_verify
    if (password_verify($password, $user['password_hash']) == FALSE) {
        return "Wrong email or password";
    }

    // the tables have no CHECK constraints, so PHP checks the account status
    if ($user['account_status'] == 'banned') {
        return "This account is banned";
    }

    if ($user['account_status'] == 'suspended') {
        return "This account is suspended";
    }

    // save the login time
    $query = "UPDATE users SET last_login_at=NOW() WHERE user_id=?";
    $sql = $db->prepare($query);
    $sql->execute([$user['user_id']]);

    $_SESSION['uid']  = $user['user_id'];
    $_SESSION['name'] = $user['first_name'];
    $_SESSION['role'] = $user['role'];

    return "";
}


// logs the user out
function logoutUser() {
    session_unset();
    session_destroy();
}


// put this at the top of a page that needs a logged in user
// sends the user to the login page if not logged in
function requireLogin() {
    if (!isset($_SESSION['uid'])) {
        header("Location: login.php");
        exit();
    }
}
