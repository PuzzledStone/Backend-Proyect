<?php 
  require_once './database.php';

  $link = "";
  $url_params = "";
  $lang = "";

  $outstanding = $database->select("tb_dishes","*",[
    "id_outstanding"=>1 
 ]);

  if($_GET){
    if(isset($_GET["lang"]) && $_GET["lang"] == "tr"){
          $item = $database->select("tb_dishes",[
              "[>]tb_categories"=>["id_categoria" => "id_categoria"]
          ],[
              "tb_dishes.id_informacion_platillo",
              "tb_dishes.nombre",
              "tb_dishes.descripcion",
              "tb_dishes.imagen",
              "tb_dishes.precio",
              "tb_dishes.nombre_categoria",
              "tb_dishes.personas",
              "tb_dishes.value_outstanding",
              "tb_dishes.nombre_kr",
              "tb_dishes.descripcion_kr",

          
          ],[
              "id_informacion_platillo"=>$_GET["id"]
          ]);
          $item[0]["nombre"] = $item[0]["nombre_kr"];
          $item[0]["descripcion"] = $item[0]["descripcion_kr"];

          $url_params = "id=".$item[0]["id_informacion_platillo"];
          $lang = "EN";
        
        }else{
            $item = $database->select("tb_dishes",[
                "[>]tb_categories"=>["id_categoria" => "id_categoria"]
            ],[
                "tb_dishes.id_informacion_platillo",
                "tb_dishes.nombre",
                "tb_dishes.descripcion",
                "tb_dishes.imagen",
                "tb_dishes.precio",
                "tb_dishes.nombre_categoria",
                "tb_dishes.personas",
                "tb_dishes.value_outstanding",
            
            ],[
                "id_informacion_platillo"=>$_GET["id"]
            ]);
            
            $url_params = "id=".$item[0]["id_informacion_platillo"]."&lang=tr";
            $lang = "KR";
        }
          
     
  }
    
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=AR+One+Sans:wght@400;500;700&family=Open+Sans:ital,wght@0,500;0,700;1,300&family=Raleway:ital,wght@0,500;0,700;1,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
<?php 
        include './parts/header.php';
   ?>
    <main>
    <div class="line"> </div>
    <?php 
        
   
    echo "<section class='det-container'>
        
        <img class='img-details realce' src='scraping/images/".$item[0]["imagen"]."' alt='logo'>
            <div>
             <a class='lenguage-btn' href='./details.php?".$url_params."'>".$lang."</a>
            <h1 class='title-container'>".$item[0]["nombre"]."</h1>
            <div class='second-container'>
                <p class='text-details'>".$item[0]["descripcion"]."</p>
                <p class='text-details'>".$item[0]["nombre_categoria"]."</p>
                <p class='text-details'>".$item[0]["value_outstanding"]."</p>
                <p class='text-details'> Designed for ".$item[0]["personas"]." person/s</p>
                <p class='text-details'>".$item[0]["precio"]." $    </p>
            </div>
        </div>
    </section>
    <section class='vote-item'>
        <div>
            <a href='#'><img class='left space realce' src='imgs/icons/liketwo.png'alt='log'></a>
            <a href='#'><img class='right realce'   src='imgs/icons/flagtwo.png' alt='logo'></a>
        </div>
    </section>";
    ?>

    <!-- most voted -->
   <?php 
              echo "<section class='most-voting-container'>";
              echo "<h1 class='voting-title'>The most voted</h1>";
              
              echo"<div class='voted-recipes-container'>";
              for ($i = 0; $i < 2; $i++) { 
               
                $name = $outstanding[$i]["nombre"];
                $limitedName = (strlen($name) > 30) ? substr($name, 0, 30) : $name; 
                echo "<section class='recepie'>
                <div>
                    <h1 class='featured-title'>".$limitedName."</h1>
                    <img class='featured-img' src='scraping/images/".$outstanding[$i]["imagen"]."' alt='bibimbap'>
                </div>
                <div class='red-box'>
                    <p class='featured-details-txt'style= font-size:0.75rem><b>Details</b></p>
                    <p class='featured-details-txt'>Size: ".$outstanding[$i]["personas"]." person/s</p>
                    <p class='featured-details-txt'>".$outstanding[$i]["precio"]." $</p>
                    <p class='featured-details-txt'>".$outstanding[$i]["value_outstanding"]."</p>
                    <p class='featured-details-txt'>".$outstanding[$i]["nombre_categoria"]."</p>
                    <span class='white-line'></span>
                    <a href='details.php?id=".$outstanding[$i]["id_informacion_platillo"]."'><button class='featured-more-btn'>View more</button></a>
                    <button class='featured-like-btn'> <img class='like-img' src='imgs/icons/heart.png' alt='like-btn'></button>
                </div>
            </section>";
              }
              echo"</div>";
          echo "</section>"; 
            ?>
            <button class="hardpl-btn" >
                        <a href="order.php" class= "btns-text"> Order Now</a>
                    </button>
    <?php 
        include './parts/footer.php';
    ?>
    </main>

    
</body>

</html>