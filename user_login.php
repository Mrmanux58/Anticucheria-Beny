<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}

$message = [];

if(isset($_POST['submit'])){
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:home.php');
      exit;
   }else{
      $message[] = '¡Contraseña o correo electrónico incorrectos!';
   }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inicio de Sesión</title>
   
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- Tu archivo CSS -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      .message {
         background-color: #f2dede;
         color: #a94442;
         padding: 10px;
         margin-bottom: 10px;
         border: 1px solid #ebccd1;
         border-radius: 5px;
         text-align: center;
      }
      .password-wrapper {
         position: relative;
      }
      .password-wrapper input {
         width: 100%;
         padding-right: 40px;
      }
      .toggle-password {
         position: absolute;
         top: 50%;
         right: 10px;
         transform: translateY(-50%);
         cursor: pointer;
         color: #666;
      }
   </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="form-container">
   <form action="" method="post">
      <h3>Inicia Sesión</h3>

      <?php
      if (!empty($message)) {
         foreach($message as $msg){
            echo '<p class="message">'.htmlspecialchars($msg).'</p>';
         }
      }
      ?>

      <input type="email" name="email" required placeholder="Introduce tu correo" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      
      <div class="password-wrapper">
         <input type="password" name="pass" required placeholder="Ingrese su contraseña" maxlength="20" class="box" id="login-password" oninput="this.value = this.value.replace(/\s/g, '')">
         <i class="fas fa-eye toggle-password" toggle="#login-password"></i>
      </div>

      <input type="submit" value="Accede Ahora" class="btn" name="submit">
      <p>¿No tienes una cuenta?</p>
      <a href="user_register.php" class="option-btn">Registrarte</a>
   </form>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

<!-- Script para mostrar/ocultar contraseña -->
<script>
   document.querySelectorAll('.toggle-password').forEach(icon => {
      icon.addEventListener('click', () => {
         const target = document.querySelector(icon.getAttribute('toggle'));
         if (target.type === "password") {
            target.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
         } else {
            target.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
         }
      });
   });
</script>

</body>
</html>
