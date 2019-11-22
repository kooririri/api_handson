<?php
   require './env.php';
   require './controllers/article_controller.php';
   header("Content-Type: application/json; charset=UTF-8");
   // クライアントからのリクエストデータ(json)をデコードして、phpのオブジェクトに格納
   $request_json = file_get_contents('php://input');
   $request_data = json_decode($request_json, TRUE);
   $request_uri = $_SERVER['REQUEST_URI'];
   $request_method = $_SERVER['REQUEST_METHOD'];
   // mysqlのコネクション
   $conn = new mysqli(DB_SERVER_NAME, USERNAME, PASSWORD, DB_NAME);
   // Check connection
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   if (preg_match('/^\/articles$/', $request_uri)) {
       switch ($request_method) {
           case 'GET':
               echo get_articles($conn);
               break;
           case 'POST':
               echo create_article($conn,$request_data);
               break;
       }
   }