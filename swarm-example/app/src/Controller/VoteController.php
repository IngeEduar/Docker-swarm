<?php

namespace App\Controller;

use App\Entity\Vote;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoteController extends AbstractController
{
    #[Route('/votar', name: 'app_vote', methods: ["POST"])]
    public function votar(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $vRequest = (object) json_decode($request->getContent());
        $vote = new Vote();
        $vote->setUsername($vRequest->username);
        $vote->setVote($vRequest->vote);

        $entityManager->persist($vote);
        $entityManager->flush();

        return new JsonResponse(["mensaje" => "Su voto se ha realizado"], Response::HTTP_OK);
    }

    #[Route('/ver-votos', name: 'view_vote', methods: ["GET"])]
    public function verVotos(EntityManagerInterface $entityManager): JsonResponse
    {
        $repo = $entityManager->getRepository(Vote::class);
        $votos = $repo->findAll();

        $data = [];

        foreach ($votos as $voto) {
            $data[] = $voto->getUsername() . " ha votado: " . $voto->isVote() ? "Verdadero" : "Falso";
        }

        return $this->json([
            "cantVotos" => count($votos),
            "Votos" => $data
        ]);
    }
}
