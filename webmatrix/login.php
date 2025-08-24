<?php
include("header.php");
include("db.php");

session_start();

$successMsg = "";
$errorMsg = "";

// Handle Signup
if (isset($_POST['signup'])) {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($name) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            $successMsg = "✅ Account created successfully. Please log in.";
        } else {
            $errorMsg = "⚠ Email already registered.";
        }
        $stmt->close();
    } else {
        $errorMsg = "⚠ All fields are required.";
    }
}

// Handle Login
if (isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: index.php");
            exit;
        } else {
            $errorMsg = "⚠ Invalid email or password.";
        }
        $stmt->close();
    } else {
        $errorMsg = "⚠ Please enter your email and password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign In / Sign Up</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
/* Keep all your existing CSS here */
<?php include 'login.css'; ?>
</style>
</head>
<body>

<section class="breadcrumb">
  <div class="container">
    <a href="index.php">Home</a> <i class="fas fa-chevron-right"></i>
    <a href="services.php">Services</a> <i class="fas fa-chevron-right"></i>
    <span>Login</span>
  </div>
</section>

<?php if(!empty($errorMsg)): ?>
<div style="background:#f56565;color:white;padding:10px;text-align:center;margin-bottom:20px;">
    <?= $errorMsg ?>
</div>
<?php endif; ?>

<?php if(!empty($successMsg)): ?>
<div style="background:#48bb78;color:white;padding:10px;text-align:center;margin-bottom:20px;">
    <?= $successMsg ?>
</div>
<?php endif; ?>

<div class="main-content">
    <div class="auth-container" id="container">
        <!-- SIGN UP FORM -->
        <div class="form-container sign-up-container">
            <form method="POST">
                <h1>Create Account</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>
                <input type="text" name="name" placeholder="Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>

        <!-- SIGN IN FORM -->
        <div class="form-container sign-in-container">
            <form method="POST">
                <h1>Already Have an Account?</h1>
                <div class="social-container">
                    <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span>Login</span>
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <a href="#">Forgot your password?</a>
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>

        <!-- OVERLAY -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Hello !</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php';?>
<script>
document.getElementById('signUp').addEventListener('click', () => {
    document.getElementById('container').classList.add("right-panel-active");
});
document.getElementById('signIn').addEventListener('click', () => {
    document.getElementById('container').classList.remove("right-panel-active");
});
</script>

</body>
</html>

