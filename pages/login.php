<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href=""
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../app/scss/style.css" />

    <title>Login | Ternakkuy</title>
  </head>
  <body>
    <header class="header">
      <div class="overlay has-fade"></div>

      <nav class="container container--pall flex flex-jc-sb flex-ai-c">
        <a href="../index.html" class="header__logo">
          <img src="../image/Ternakkuy.png" alt="Ternakkuy" /> 
        </a>

        
    </header>


    <section class="login">
      <div class="body">
        <div class="center">
          <h1>Sign In</h1>
          <form action="conn.php" method="post">

            <?php
             // Check for an alert message and display it
            session_start();
            if (isset($_SESSION['login_error'])) {
              echo '<div class="alert alert-danger">' . $_SESSION['login_error'] . '</div>';
              unset($_SESSION['login_error']); // Clear the alert after displaying it
              }
            ?>

            <div class="txt_field">
              <input type="text" name="username" id="username" required>
              <span></span>
              <label>Username</label>
            </div>
            <div class="txt_field">
              <input type="password" name="password" id="password" required>
              <span></span>
              <label>Password</label>
            </div>
            <div class="pass">
              <a href="sandi.php">Lupa sandi?</a>
            </div>
            <input type="submit" value="Login">
            <div class="signup_link">
              Belum mendaftar? <a href="register.html">Daftar disini</a>
            </div>
          </form>
        </div>
      </div>
    </section>

    

    <script src="../app/js/script.js"></script>
  </body>
</html>
