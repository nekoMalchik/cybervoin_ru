<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/mm", name="main_menu")
     */
    public function showMenu(): Response
    {
        $posts = $this->getDoctrine()->getManager()->getRepository(Post::class)->findAll();

        return $this->render('main_menu/index.html.twig', [
            'controller_name' => 'MainMenuController',
            'posts' => $posts,
        ]);
    }


    /**
     * @Route("/", name="home_page")
     */
    public function index(): Response
    {
        return $this->redirectToRoute("main_menu");
    }

    /**
     * @Route("/member/{id}", name="member_profile")
     */
    public function userProfile($id): Response
    {
        $member = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy(['id' => $id]);
        if($member === null)
            return $this->createNotFoundException('Not found user #%s', $id);

        return $this->render('main_menu/userProfile.html.twig', [
            'member' => $member,
        ]);
    }


    /**
     * @Route("/members", name="members_list")
     */
    public function userList(): Response
    {
        $members = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('main_menu/user_list.html.twig', [
            'members' => $members,
        ]);
    }
}
