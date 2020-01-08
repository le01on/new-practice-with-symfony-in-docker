<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class PostsController extends AbstractController
{
    /**
     * @Route("/posts", name="posts")
     */
    public function index()
    {

        $connection = $this->getDoctrine()->getConnection();
        $connection->connect();
        var_dump($connection->isConnected());
        $a =123;
        var_dump($a);

       return new Response("heloo!");

       /* return $this->render('post/index.html.twig', [
            'controller_name' => 'PostsController',
        ]);*/
    }
}