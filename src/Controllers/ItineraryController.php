<?php
namespace Controllers;

use Slim\Psr7\Factory\StreamFactory;

use Services\ItineraryService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ItineraryController {
    private $itineraryService;

    public function __construct(ItineraryService $itineraryService) {
        $this->itineraryService = $itineraryService;
    }

    public function getItineraries(Request $request, Response $response): Response {
        $items = $this->itineraryService->getItineraries();
        $response->getBody()->write(json_encode($items));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createItinerary(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
    
        if (!isset($data['name']) || !isset($data['description'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Invalid input']));
        }
    
        $itemId = $this->itineraryService->createItinerary($data['name'], $data['description']);
        $data = ['message' => 'Item created', 'id' => $itemId];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateItinerary(Request $request, Response $response, array $args): Response {
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
            $this->itineraryService->updateItinerary($id, $data['name'], $data['description']);
    
            $response->getBody()->write(json_encode(['message' => 'Item updated successfully']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            return $response
                ->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => $e->getMessage()]));
        }
    }

    public function deleteItinerary(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
    
        try {
            $this->itineraryService->deleteItinerary($id);
    
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
