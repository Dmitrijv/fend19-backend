<?php

    header("Content-Type: application/json; charset=UTF-8");

    class Product {
        
        private $id;
        private $name;
        private $description;
        private $price;
        private $numberInStock;
        private $image;

        public function __construct($id, $name, $description){
            $this -> id = $id;
            $this -> name = $name;
            $this -> description = $description;
            $this -> price = rand(100, 1000)."kr";
            $this -> numberInStock = rand(0, 100);
        }
        
        public function setImage($imageUrl){
            $this -> image = $imageUrl;
        }

        public function toArray(){
            return array(
                "id" => $this -> id,
                "name" => $this -> name,
                "description" => $this -> description,
                "price" => $this -> price,
                "numberInStock" => $this -> numberInStock,
                "image" => $this -> image,
            );
        }
    }

    $apiItems = [];
    array_push($apiItems, new Product(1, "Brun ägg", "Ekologiska ägg kommer från höns som har tillgång till utevistelse och stall med strö sittpinnar."));
    array_push($apiItems, new Product(2, "Söta jordgubbar", "Generöst söta och med mycket bärsmak."));
    array_push($apiItems, new Product(3, "Sparris", "Krispig, grön, välsmakande och alldeles, alldeles ljuvlig!"));
    array_push($apiItems, new Product(4, "Smoothie", "Den här smoothien svänger du ihop på under en kvart!"));
    array_push($apiItems, new Product(5, "Rå baljväxter", "Linser, bönor, ärtor med mera – baljväxter har länge ansetts vara fattigmanskost."));
    array_push($apiItems, new Product(6, "Tårta", "Tårta är perfekt när du har något att fira!"));
    array_push($apiItems, new Product(7, "Pesto", "Få saker smakar så gott som hemgjord pesto!"));
    array_push($apiItems, new Product(8, "Hasselnötter", "En av våra mest funktionella nötsorter och kan användas på många olika sätt"));
    array_push($apiItems, new Product(9, "Citron", "Denna populära frukt, som vi använder oss av bl.a. som krydda i matlagning och ingår i desserter."));
    array_push($apiItems, new Product(10, "Bröd", "Älskar du bröd? Bröd kan vara både mättande, näringsrikt och klimatsmart."));

    // get 10 random images from picsum API
    $imageAPIurl= "https://picsum.photos/v2/list?page=2&limit=10";
    $imageAPIjson = file_get_contents($imageAPIurl);
    $randomImages = json_decode($imageAPIjson, true);

    // if no limit parameter was sent use 1 as default value
    $requestLimit = isset($_GET['limit']) ? $_GET['limit'] : 1;
    // make sure response is always between 1 and 10 items
    $requestLimit = ($requestLimit > 10 || $requestLimit < 0) ? 1 : $requestLimit;

    $response = [];
    for ($i = 0; $i < $requestLimit; $i++) {
        shuffle($apiItems);
        $randomItem = array_pop($apiItems);
        shuffle($randomImages);
        $randomItem->setImage($randomImages[$i]['download_url']);
        array_push($response, $randomItem->toArray());
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

?>