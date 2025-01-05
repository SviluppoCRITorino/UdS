<?php
namespace Controllers;

use Slim\Psr7\Factory\StreamFactory;

use Services\MissionService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MissionController {
    private $missionService;

    public function __construct(MissionService $missionService) {
        $this->missionService = $missionService;
    }

    public function loadExistingMission(Request $request, Response $response): Response {
        // Recupera i parametri dalla query string (GET)
        $params = $request->getQueryParams();
    
        // Verifica che tutti i parametri richiesti siano presenti
        if (!isset($params['name'], $params['surname'], $params['idComitato'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Missing required parameters']));
        }
    
        // Recupera i parametri
        $name = $params['name'];
        $surname = $params['surname'];
        $idComitato = $params['idComitato'];
    
        try {
            // Passa i parametri al servizio
            $missions = $this->missionService->loadExistingMission($name, $surname, $idComitato);
    
            // Gestisci i casi di errore o successo
            if (count($missions) > 1) {
                return $response
                    ->withStatus(400)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode(['error' => 'Multiple missions found']));
            }
            
            $response->getBody()->write(json_encode($missions));
            return $response->withHeader('Content-Type', 'application/json');
           
        } catch (Exception $e) {
            // Gestione di errori generali
            return $response
                ->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => $e->getMessage()]));
        }
    }

    public function createMission(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
    
        if (!isset($data['idPercorso']) || !isset($data['name']) || !isset($data['surname']) || !isset($data['telephone']) || !isset($data['idComitato'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Invalid input']));
        }
    
        $itemId = $this->missionService->createMission($data['name'], $data['surname'], $data['telephone'], $data['idComitato'], $data['idPercorso']);
        $data = ['message' => 'Item created', 'id' => $itemId];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateMission(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $data = $request->getParsedBody();
    
        if (!isset($id)) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Invalid input']));
        }
    
        $itemId = $this->missionService->updateMission($id, $data['note'], $data['checkZaino'], $data['checkMateriali']);
        $data = ['message' => 'Mission updated successfully', 'id' => $itemId];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function endMission(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $data = $request->getParsedBody();
    
        if (!isset($id) || !isset($data['totalKm'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Invalid input']));
        }
    
        $itemId = $this->missionService->endMission($id, $data['note'], $data['totalKm']);
        $data = ['message' => 'Mission Closed successfully', 'id' => $itemId];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }
}