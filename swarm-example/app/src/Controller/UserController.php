<?php

namespace App\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route("/get-user", name: "getUser", methods: ["GET"])]
    public function view(EntityManagerInterface $entityManager): JsonResponse
    {
        $users = $entityManager->getRepository(Usuario::class)->findAll();
        $data = [];

        foreach ($users as $user) {
            $data[] = $user->getName() . " " . $user->getEdad();
        }

        return new JsonResponse(['usuarios' => $data], 200);
    }

    #[Route("/add-user", name: "addUser", methods: ["GET"])]
    public function addUser(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $name = $request->query->get('name') ?? 'user';
        $edad = $request->query->get('age') ?? '18';

        $user = new Usuario();
        $user->setName($name);
        $user->setEdad($edad);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['mensaje' => 'Usuario agregado'], 200);
    }
}