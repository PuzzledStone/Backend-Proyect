<?php
    require_once '../database.php';
    
    include('simple_html_dom.php');

    $link = "https://www.allrecipes.com/recipes/77/drinks/";

    $filenames = [];
    $menu_item_names = [];
    $menu_item_descriptions = [];
    $image_urls = [];

    $menu_items = 10;

    $items = file_get_html($link);

    //save meals info and filenames for the images
    foreach ($items->find('.card--no-image') as $item){
        
        $title = $item->find('.card__title-text');
        
        $details = file_get_html($item->href);
        $description = $details->find('.article-subheading');
        $image = $details->find('.primary-image__image');

        if(count($image) > 0){
            $image_urls[] = $image[0]->src;
        }else{
            $replace_img = $item->find('.universal-image__image');
            if(count($replace_img) > 0){
                $image_urls[] = $replace_img[0]->{'data-src'};
            }
        }
       
        if(count($description) > 0){
            if($menu_items == 0) break;

            $menu_item_names[] = trim($title[0]->plaintext);
            $menu_item_descriptions[] = $description[0]->plaintext;
            
            $filename = strtolower(trim($title[0]->plaintext));
            $filename = str_replace(' ', '-', $filename);
            $filenames[] = $filename;

            $menu_items--;
        }

    }

   

    foreach($filenames as $index=>$item){
        echo "******************";
        echo "<br>";
        echo $item;
        echo "<br>";
        echo $menu_item_names[$index];
        echo "<br>";
        echo $menu_item_descriptions[$index];
        echo "<br>";
        echo $image_urls[$index];
        echo "<br>";
        
        //$menu_items--;
        //if($menu_items == 0) break;
    }

    //get and download images
    foreach ($filenames as $index=>$image){
        file_put_contents("./images/".$image.".jpg", file_get_contents($image_urls[$index]));
    }

    for($i=0; $i<10; $i++){
        // Reference: https://medoo.in/api/insert
        $database->insert("tb_dishes",[
            "id_categoria"=>null,
            "nombre"=>$menu_item_names[$i],
            "imagen"=> $filenames[$i] . ".jpg",
            "nombre_categoria"=>null,
            "destacado"=>null,
            "descripcion"=>$menu_item_descriptions[$i],
            "personas"=>rand(1,3),
            "precio"=>rand(1 * 10, 70 * 10) / 10,
        ]);
    }
    
    // the administrator will need to edit some names so that they can be placed correctly in the spaces: 14 characters maximum
    // The info wont apear in the web page if they are not complete, admin will have to complete the info in the edit.php 
?>