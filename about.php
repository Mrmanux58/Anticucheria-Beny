<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nosotros</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/Anticuchos.webp" alt="">
      </div>

      <div class="content">
         <h3>Historia del Restaurante</h3>

         <p>La anticucheria Beny se fundo en el año 1964 la señora Beny era famosa 
            no solo por su receta secreta de anticuchos sino que tambien era una persona humilde 
            y llena de hospitalidad poniendo su amor en cada plato de anticucho. 
            Cada noche, largas filas se formaban frente al local. Los clientes siempre 
            venian por sus ricos anticuchos. Durantes años ella fue el corazon del negocio. 
            Ella empezó vendiendo en una esquina con una pequeña parrilla y con el tiempo se 
            fue haciendo mas conocida. La señora Beny falleció. Su partida dejo un vacio enorme 
            no solo porque habia sido una emprendedora incansable, si no porque era querida por todos. 
            La anticucheria permanecio cerrada por semanas. 
            Sin embargo, sus hijos, que habian crecido entre el aroma de los anticuchos y las historias 
            de su madre, decidieron continuar con su legado. Aunque nunca habian estado al frende del negocio, 
            sabian lo que significaba para la comunidad y para la memoria de su madre. 
            Reabrieron la anticucheria con un pequeño homenaje a Beny, manteniendo intacta la receta 
            secreta y la parrilla que ella habia usado durante decadas.
         </p>
         <a href="contact.php" class="btn">Contactanos</a>
      </div>

   </div>

</section>

<section class="reviews">
   
   <h1 class="heading">Reseñas de clientes.</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <img src="images/persona-1.jpg" alt="">
         <h3> <a href="" target="_blank">Monica Pérez</a></h3>
         <p>"Fui a probar los anticuchos y no me decepcionaron. La carne estaba tierna y bien sazonada, y el acompañamiento de papas y maíz le da un toque especial. El ambiente es acogedor, ideal para disfrutar con amigos. Solo le daría 4 estrellas porque el servicio fue un poco lento, pero vale la pena la espera."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
      </div>

      <div class="swiper-slide slide">
         <img src="images/persona-2.jpg" alt="">
         <h3><a href="" target="_blank">María Fernández</a></h3>
         <p>"¡Increíble experiencia en esta anticuchería! Los anticuchos son simplemente deliciosos, con un sabor ahumado que te transporta a las calles de Lima. La atención fue excelente, el personal muy amable y siempre dispuesto a recomendarte lo mejor del menú. No te puedes perder la salsa de ají, ¡es el complemento perfecto! Definitivamente volveré."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
      </div>

      <div class="swiper-slide slide">
         <img src="images/persona-3.jpg" alt="">
         <h3><a href="" target="_blank">Jorge Ramírez</a></h3>
         <p>"Esta anticuchería tiene el mejor anticucho que he probado en años. La mezcla de especias es perfecta y la textura de la carne es sublime. Además, el lugar es muy limpio y bien decorado. Me encantó la atención personalizada, te hacen sentir como en casa. ¡Recomiendo probar el anticucho de corazón!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
      </div>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>