<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
}

$pedido_exitoso = false;

if(isset($_POST['order'])){

   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
   $address = filter_var($_POST['flat'] .', '. $_POST['city'], FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   // Validar número de 9 dígitos que comience con 9
   if(!preg_match('/^9\d{8}$/', $number)){
      $message[] = 'El número debe tener exactamente 9 dígitos y comenzar con 9.';
   } else {
      $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $check_cart->execute([$user_id]);

      if($check_cart->rowCount() > 0){
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = '¡Pedido realizado con éxito!';
         $pedido_exitoso = true;
      } else {
         $message[] = 'Tu carrito está vacío';
      }
   }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Proceso de Compra</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

   <style>
      .qr-container {
         display: none;
         text-align: center;
         margin-top: 20px;
      }
      .qr-container img {
         width: 200px;
         height: 200px;
      }
      .qr-container h4 {
         color: green;
         font-size: 24px;
         font-weight: bold;
         margin-bottom: 10px;
      }
   </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST" onsubmit="return validarNumero();">

      <h3>Tus Pedidos</h3>

      <div class="display-orders">
         <?php
         $grand_total = 0;
         $cart_items = [];
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '.$fetch_cart['quantity'].')';
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
         ?>
            <p><?= $fetch_cart['name']; ?> <span>(S/.<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?>)</span></p>
         <?php
            }
         } else {
            echo '<p class="empty">¡Tu carrito está vacío!</p>';
         }
         $total_products = implode(' - ', $cart_items);
         ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
         <div class="grand-total">Total General : <span>S/.<?= $grand_total; ?></span></div>
      </div>

      <?php
      if(isset($message)){
         foreach($message as $msg){
            echo '<div class="message" style="color:green;text-align:center;">'.$msg.'</div>';
         }
      }
      ?>

      <h3>Realiza tus pedidos</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Tu nombre :</span>
            <input type="text" name="name" placeholder="Ingresa tu Nombre" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Tu número :</span>
            <input type="text" name="number" id="numero" placeholder="Ej: 987654321" class="box" maxlength="9" required
               oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,9);">
         </div>
         <div class="inputBox">
            <span>Tu correo :</span>
            <input type="email" name="email" placeholder="Ingresa tu correo" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Método de pago :</span>
            <select name="method" class="box" id="metodoPago" onchange="generarQR()" required>
               <option value="pago contra entrega">Pago Contra Entrega</option>
               <option value="tarjeta de credito">Tarjeta de Crédito</option>
               <option value="codigo qr">Código QR</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Dirección :</span>
            <input type="text" name="flat" placeholder="Av. Mexico 1424" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Distrito :</span>
            <input type="text" name="city" placeholder="Los Olivos" class="box" maxlength="50" required>
         </div>
      </div>

      <div class="qr-container" id="qrContainer">
         <h4>Escanea este código QR para pagar:</h4>
         <img id="qrImage" src="" alt="QR de pago">
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Realizar Pedido">
   </form>
</section>

<!-- Audio generado por IA -->
<audio id="successAudio" src="assets/audio/success.mp3" preload="auto"></audio>

<?php include 'components/footer.php'; ?>

<script>
function validarNumero() {
   const numero = document.getElementById('numero').value;
   const regex = /^9\d{8}$/;
   if (!regex.test(numero)) {
      alert('El número debe tener exactamente 9 dígitos y comenzar con 9.');
      return false;
   }
   return true;
}

function generarQR() {
   const metodo = document.getElementById('metodoPago').value;
   const qr = document.getElementById('qrContainer');
   const qrImg = document.getElementById('qrImage');
   if (metodo === 'codigo qr') {
      const total = <?= $grand_total; ?>;
      const url = encodeURIComponent("Pago de S/ " + total + " a Tienda en Línea");
      qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${url}`;
      qr.style.display = 'block';
   } else {
      qr.style.display = 'none';
   }
}

// Reproducir audio si el pedido fue exitoso
document.addEventListener('DOMContentLoaded', function() {
   const pedidoExitoso = <?= $pedido_exitoso ? 'true' : 'false'; ?>;
   if (pedidoExitoso) {
      const audio = document.getElementById('successAudio');
      if (audio) {
         audio.play().catch(error => {
            console.warn("El navegador impidió la reproducción automática del audio.");
         });
      }
      alert("¡Pedido realizado con éxito! Gracias por tu compra.");
   }
});
</script>

</body>
</html>
