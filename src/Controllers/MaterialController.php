<?php
namespace Controllers;

use Slim\Psr7\Factory\StreamFactory;

use Services\MaterialService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MaterialController {
    private $materialService;

    public function __construct(MaterialService $materialService) {
        $this->materialService = $materialService;
    }

    public function getMaterials(Request $request, Response $response): Response {
        $items = $this->materialService->getMaterials();
        $response->getBody()->write(json_encode($items));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createMaterial(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
    
        if (!isset($data['name']) || !isset($data['description'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Invalid input']));
        }
    
        $itemId = $this->materialService->createMaterial($data['name'], $data['description']);
        $data = ['message' => 'Item created', 'id' => $itemId];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateMaterial(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $data = $request->getParsedBody(); // 

        // Validazione dei dati
        if (!isset($data['name']) || !isset($data['description'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Invalid input']));
        }

        try {
            $this->materialService->updateMaterial($id, $data['name'], $data['description']);
    
            $response->getBody()->write(json_encode(['message' => 'Item updated successfully']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            return $response
                ->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => $e->getMessage()]));
        }
    }

    public function deleteMaterial(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
    
        try {
            $this->materialService->deleteMaterial($id);
    
            $response->getBody()->write(json_encode(['message' => 'Item deleted successfully']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        } catch (\Exception $e) {
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500)
                ->withBody((new StreamFactory())->createStream(json_encode(['error' => $e->getMessage()])));
        }
    }
}
