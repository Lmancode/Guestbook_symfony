<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\AddPostsFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    #[Route('/my_post', name: 'my_post')]
    public function index(Security $security, ManagerRegistry $doctrine, Request $request): Response
    {
        $locale = $request->getLocale();

        if($user = $security->getUser()){
        $entityManager = $doctrine->getManager();

        $posts = $entityManager->getRepository(Post::class)->findBy(['user' => $user, "isDeleted" => false]);  //отримуємо всі пости користувача
        }

        if($locale == "ukr") {
            return $this->render('post/my_posts_ukr.html.twig', [
                'posts' => $posts,
            ]);
        }
        return $this->render('post/my_posts.html.twig', [
            'posts' => $posts,
        ]);

    }

    #[Route('/create', name: 'create_post')]
    public function create(Request $request, ManagerRegistry $doctrine, Security $security, #[Autowire('%photo_dir%')]  string $photoDir): Response
    {
        $locale = $request->getLocale();

        $entityManager = $doctrine->getManager();
        $post = new Post();
        $user = $security->getUser();

        if ($user) {
            $userIp = $request->getClientIp();
            $userAgent = $request->headers->get('User-Agent');
        }

        $post->setUserIp($userIp);
        $post->setUserAgent($userAgent);
        $post->setUser($user);
        $post->setCreatedAt(new \DateTime());
        $post->setIsAgree(0);

        $form = $this->createForm(AddPostsFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($image = $form['image']->getData()){
                $fileName = uniqid().'.'.$image->guessExtension();
                $image->move($photoDir, $fileName);
                $post->setImage($fileName);
            }

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        if($locale == "ukr") {
            return $this->render('post/create_post_ukr.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return $this->render('post/create_post.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/post/{id}', name: 'post_show')]
    public function show(Post $post, Request $request): Response
    {
        $locale = $request->getLocale();

        if($locale == "ukr") {
            return $this->render('post/show_ukr.html.twig', [
                "post" => $post,
            ]);
        }

        return $this->render('post/show.html.twig', [
               "post" => $post,
        ]);
    }


    #[Route('/post/edit/{id}', name: 'edit_post')]
    public function edit(Request $request, ManagerRegistry $doctrine, Post $post, Security $security, #[Autowire('%photo_dir%')]  string $photoDir, int $id): Response
    {
        $locale = $request->getLocale();

        $entityManager = $doctrine->getManager();
        $post = $entityManager->getRepository(Post::class)->find($id);

        if (!$post) {
            throw $this->createNotFoundException('Пост не знайдено');
        }

        // перевірка, чи користувач, який редагує пост, має права на редагування
        $user = $security->getUser();
        if ($user !== $post->getUser()) {
           // throw $this->createAccessDeniedException('Ви не маєте прав для редагування цього поста');
            return $this->redirectToRoute('app_home');
        }

        if ($user) {
            $userIp = $request->getClientIp();
            $userAgent = $request->headers->get('User-Agent');
        }

        $post->setUserIp($userIp);
        $post->setUserAgent($userAgent);
        $post->setCreatedAt(new \DateTime());

        $form = $this->createForm(AddPostsFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form['image']->getData()) {
                $fileName = uniqid() . '.' . $image->guessExtension();
                $image->move($photoDir, $fileName);
                $post->setImage($fileName);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        if($locale == "ukr") {
            return $this->render('post/edit_post_ukr.html.twig', [
                'form' => $form->createView(),
                'post' => $post,
            ]);
        }

        return $this->render('post/edit_post.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
        ]);
    }


    #[Route('/post/delete/{id}', name: 'delete_post')]
    public function delete(Post $post, Request $request, Security $security, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $post = $entityManager->getRepository(Post::class)->find($id);

        if (!$post) {
            throw $this->createNotFoundException('Пост не знайдено');
        }

        $user = $security->getUser();
        if ($user !== $post->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $post->setIsDeleted(true);
        $entityManager->flush();

        return $this->redirectToRoute('my_post');
    }



}
