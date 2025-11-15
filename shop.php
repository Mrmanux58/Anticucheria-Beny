<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tienda</title>
   
   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      #toggleReader {
         position: fixed;
         bottom: 20px;
         right: 20px;
         padding: 10px 15px;
         background: #333;
         color: #fff;
         border: none;
         border-radius: 5px;
         font-size: 14px;
         cursor: pointer;
         z-index: 9999;
         box-shadow: 0 2px 10px rgba(0,0,0,0.3);
      }
   </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="products">

   <h1 class="heading">Últimos Productos</h1>

   <div class="box-container">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products`"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span>S/.</span><?= $fetch_product['price']; ?></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="Añadir al Carrito" class="btn" name="add_to_cart">
   </form>
   <?php
        }
     } else {
        echo '<p class="empty">¡No se encontraron productos!</p>';
     }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<!-- Script principal -->
<script src="js/script.js"></script>

<!-- Botón flotante para activar/desactivar lectura -->
<button id="toggleReader">🔈 Activar lectura</button>

<!-- Script de lectura en voz alta -->
<script>
   let lecturaActiva = false;

   document.getElementById('toggleReader').addEventListener('click', () => {
      lecturaActiva = !lecturaActiva;
      document.getElementById('toggleReader').textContent = lecturaActiva ? '🔇 Desactivar lectura' : '🔈 Activar lectura';
   });

   document.addEventListener('mouseup', () => {
      if (!lecturaActiva) return;
      const textoSeleccionado = window.getSelection().toString().trim();
      if (textoSeleccionado.length > 0) {
         const voz = new SpeechSynthesisUtterance(textoSeleccionado);
         voz.lang = 'es-PE'; // Puedes cambiar a 'es-ES' si deseas
         speechSynthesis.cancel(); // Detiene cualquier voz anterior
         speechSynthesis.speak(voz);
      }
   });
</script>

</body>
</html>
