<?php
namespace Controllers;

use Services\StepService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class StepController{

    private $stepService;

    public function __construct(StepService $stepService) {
        $this->stepService = $stepService;
    }

    public function getStepsByItineraryId(Request $request, Response $response, array $args): Response {
        $itineraryId = $args['itineraryId'];
        $steps = $this->stepService->getStepsByItineraryId($itineraryId);
        $response->getBody()->write(json_encode($steps));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function createStepByItineraryId(Request $request, Response $response, array $args) : Response {
        $itineraryId = $args['itineraryId'];
        $data = $request->getParsedBody();

        if (!isset($data['step']) || !isset($data['address'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Invalid input']));
        }

        $stepId = $this->stepService->createStepByItineraryId($itineraryId, $data['step'], $data['address'], $data['notes']);
        $data = ['message' => 'Step created', 'id' => $stepId];
        $response->getBody()->write(json_encode($data));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function updateStep(Request $request, Response $response, array $args) : Response {
        $id = $args['id'];
        $data = $request->getParsedBody();

        if (!isset($data['step']) || !isset($data['address'])) {
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Invalid input']));
        }

        try {
            $this->stepService->updateStep($id, $data['step'], $data['address'], $data['notes']);
            $response->getBody()->write(json_encode(['message' => 'Item updated successfully']));
            return $response->withHeader('Content-Type', 'application/json');

        } catch (Exception $e) {
            return $response
                ->withStatus(500)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => $e->getMessage()]));
        }
    }

    public function deleteStep(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
    
        try {
            $this->stepService->deleteStep($id);
    
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