<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {

        $locale = $request->getLocale();

        $sortField = $request->query->get('sort', 'created_at');
        $sortDirection = $request->query->get('direction', 'desc');

        $entityManager = $doctrine->getManager();
        $postRepository = $entityManager->getRepository(Post::class);

        $posts = $postRepository->findBy([
            'isDeleted' => false,
            'is_agree' => true,
        ], [
            $sortField => $sortDirection,
        ]);
        $pagination = $paginator->paginate(
            $posts,
            $request->query->getInt('page', 1), // Отримайте номер поточної сторінки з параметру "page"
            25 // Кількість записів на сторінці
        );


        if($locale == "ukr"){
            return $this->render('home/index_ukr.html.twig', [
                'pagination' => $pagination,
                'sortField' => $sortField,
                'sortDirection' => $sortDirection,
            ]);
        }

        return $this->render('home/index.html.twig', [
            'pagination' => $pagination,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
        ]);

    }



}