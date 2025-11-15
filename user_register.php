<?php
include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}

// Aseguramos que $message sea un array
$message = [];

// Función para validar contraseña segura
function contraseñaSegura($pass) {
   return preg_match('/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/', $pass);
}

if (isset($_POST['submit'])) {
   $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
   $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
   $pass_raw = $_POST['pass'];
   $cpass_raw = $_POST['cpass'];

   $pass = sha1($pass_raw);
   $cpass = sha1($cpass_raw);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);

   if ($select_user->rowCount() > 0) {
      $message[] = '¡El correo electrónico ya existe!';
   } elseif ($pass != $cpass) {
      $message[] = '¡Confirmar contraseña no coincidente!';
   } elseif (!contraseñaSegura($pass_raw)) {
      $message[] = '¡La contraseña debe tener al menos 8 caracteres, una mayúscula y un número!';
   } else {
      $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES(?, ?, ?)");
      $insert_user->execute([$name, $email, $cpass]);
      $message[] = '¡Registrado exitosamente, por favor inicia sesión ahora!';
   }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registrate</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

   <style>
      .message {
         padding: 10px;
         margin-bottom: 10px;
         border-radius: 5px;
         text-align: center;
         border: 1px solid;
      }
      .message.error {
         background-color: #f2dede;
         color: #a94442;
         border-color: #ebccd1;
      }
      .message.success {
         background-color: #dff0d8;
         color: #3c763d;
         border-color: #d6e9c6;
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
   <form action="" method="post" id="registroForm">
      <h3>Registrate</h3>

      <?php
      if (!empty($message) && is_array($message)) {
         foreach ($message as $msg) {
            $class = (strpos($msg, 'Registrado exitosamente') !== false) ? 'success' : 'error';
            echo '<p class="message ' . $class . '">' . htmlspecialchars($msg) . '</p>';
         }
      }
      ?>

      <input type="text" name="name" required placeholder="Ingrese su nombre de usuario" maxlength="20" class="box">
      <input type="email" name="email" required placeholder="Introduce tu correo" maxlength="50" class="box" oninput="this.value = this.value.replace(/\s/g, '')">

      <div class="password-wrapper">
         <input type="password" name="pass" required placeholder="Ingrese su contraseña" maxlength="20" class="box" id="password" oninput="this.value = this.value.replace(/\s/g, '')">
         <i class="fas fa-eye toggle-password" toggle="#password"></i>
      </div>

      <div class="password-wrapper">
         <input type="password" name="cpass" required placeholder="Confirma tu contraseña" maxlength="20" class="box" id="confirm-password" oninput="this.value = this.value.replace(/\s/g, '')">
         <i class="fas fa-eye toggle-password" toggle="#confirm-password"></i>
      </div>

      <input type="submit" value="Regístrate ahora" class="btn" name="submit">
      <p>¿Ya tienes una cuenta?</p>
      <a href="user_login.php" class="option-btn">Inicia Sesión</a>
   </form>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

<script>
   // Validación de contraseña desde el lado cliente
   document.getElementById('registroForm').addEventListener('submit', function(e) {
      const pass = document.querySelector('input[name="pass"]').value;
      const regex = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/;

      if (!regex.test(pass)) {
         alert("La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.");
         e.preventDefault();
      }
   });

   // Mostrar/Ocultar contraseña
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
