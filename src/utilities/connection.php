<?php
    try {
      $connection = new mysqli($_ENV["DB_HOST"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
      $connection -> select_db("pengiriman_barang");

      if ($connection -> connect_error) {
        throw new ErrorException("Connection to database failed");
      }
    } catch (Exception $e) {
      throw new ErrorException("Connection to database failed");
    }
?>
