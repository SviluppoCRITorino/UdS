<?php
namespace Controllers;

use Services\ComitatoService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ComitatoController{

    private $comitatoService;

    public function __construct(ComitatoService $comitatoService) {
        $this->comitatoService = $comitatoService;
    }

    public function getComitati(Request $request, Response $response): Response {
        $comitati = $this->comitatoService->getComitati();
        $response->getBody()->write(json_encode($comitati));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getComitatiByProfile(Request $request, Response $response, array $args): Response {
        $profileId = $args['profileId'];
        $steps = $this->comitatoService->getComitatiByProfile($profileId);
        $response->getBody()->write(json_encode($steps));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createComitato(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
    
        if (!isset($data['name']) || !isset($data['profileId'])) {
            $response->getBody()->write(json_encode(['error' => 'Invalid input']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    
        $comitatoId = $this->comitatoService->createComitato($data['profileId'], $data['name'], $data['descrizione'] ?? "");
        $data = ['message' => 'Comitato created', 'id' => $comitatoId];
    
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateComitato(Request $request, Response $response, array $args) : Response {
        $id = $args['id'];
        $data = $request->getParsedBody();

        if (!isset($data['name']) || !isset($data['profileId'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Invalid Input']));
        }

        try {
            $this->comitatoService->updateComitato($id, $data['profileId'], $data['name'], $data['description'] ?? "");
            $response->getBody()->write(json_encode(['message' => 'Item updated successfully']));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (Exception $e) {
            return $response
                ->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => $e->getMessage()]));
        }
    }

    public function deleteComitato(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
    
        try {
            $this->comitatoService->deleteComitato($id);
    
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