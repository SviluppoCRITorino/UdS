<?php
namespace Controllers;

use Services\BackPackService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BackPackController {
    private $backPackService;

    public function __construct(BackPackService $backPackService) {
        $this->backPackService = $backPackService;
    }

    public function getAllBackPackItems(Request $request, Response $response): Response {
        $items = $this->backPackService->getBackPackItems();
        $response->getBody()->write(json_encode($items));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createBackPackItem(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
    
        if (!isset($data['item']) || !isset($data['number'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Invalid input']));
        }
    
        $itemId = $this->backPackService->createBackPackItem($data['item'], $data['number']);
        $data = ['message' => 'Item created', 'id' => $itemId];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateBackPackItem(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $data = $request->getParsedBody();
    
        // Validazione dei dati
        if (!isset($data['item']) || !isset($data['number'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Invalid input']));
        }

        try {
            $this->backPackService->updateBackPackItem($id, $data['item'], $data['number']);
    
            $response->getBody()->write(json_encode(['message' => 'Item updated successfully']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            return $response
                ->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => $e->getMessage()]));
        }
    }

    public function deleteBackPackItem(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
    
        try {
            $this->backPackService->deleteBackPackItem($id);
    
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
