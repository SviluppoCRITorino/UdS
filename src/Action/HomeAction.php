<?php

namespace App\Action;

use \PDO;
	
use App\Models\DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class HomeAction
{
    public function __invoke(Request $request, Response $response): Response
    {
	 $sql = "SELECT * FROM customers";

	 try {
	   $db = new Db();
	   $conn = $db->connect();
	   $stmt = $conn->query($sql);
	   $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
	   $db = null;
  
	   $response->getBody()->write(json_encode($customers));
	   return $response
	     ->withHeader('content-type', 'application/json')
	     ->withStatus(200);
	 } catch (PDOException $e) {
	   $error = array(
	     "message" => $e->getMessage()
	   );

	   $response->getBody()->write(json_encode($error));
	   return $response
	     ->withHeader('content-type', 'application/json')
	     ->withStatus(500);
	 }
    }
}

