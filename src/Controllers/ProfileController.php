<?php
namespace Controllers;

use Services\ProfileService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProfileController{

    private $profileService;

    public function __construct(ProfileService $profileService) {
        $this->profileService = $profileService;
    }

    public function getProfiles(Request $request, Response $response): Response {
        $profiles = $this->profileService->getProfiles();
        $response->getBody()->write(json_encode($profiles));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createProfile(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
    
        if (!isset($data['name'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Name Must be set']));
        }
        $itemId = $this->profileService->createProfile($data['name'], 
                                                       $data['initialData'] ?? 1,
                                                       $data['checkBackPack'] ?? 1,
                                                       $data['checkMaterials'] ?? 1,
                                                       $data['itinerary'] ?? 1,
                                                       $data['finalData'] ?? 1,
                                                       $data['kilometers'] ?? 1);

        $data = ['message' => 'Item created', 'id' => $itemId];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateProfile(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $data = $request->getParsedBody(); 

        // Validazione dei dati
        if (!isset($data['name'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Name must be set']));
        }

        try {
            $this->profileService->updateProfile($id, $data['name'], 
                                                 $data['initialData'] ?? 1,
                                                 $data['checkBackPack'] ?? 1,
                                                 $data['checkMaterials'] ?? 1,
                                                 $data['itinerary'] ?? 1,
                                                 $data['finalData'] ?? 1,
                                                 $data['kilometers'] ?? 1);
    
            $response->getBody()->write(json_encode(['message' => 'Item updated successfully']));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            return $response
                ->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => $e->getMessage()]));
        }
    }

    public function deleteProfile(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
    
        try {
            $this->profileService->deleteProfile($id);
    
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