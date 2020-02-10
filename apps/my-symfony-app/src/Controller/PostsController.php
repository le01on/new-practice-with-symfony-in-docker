<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
class PostsController extends AbstractController
{
    /**
     * @var PostRepository $postRepository ;
     */
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/posts", name="blog_posts")
     */
    public function posts()
    {
        $posts = $this->postRepository->findAll();

        return $this->render('posts/index.html.twig', [
            'posts' => $posts
        ]);
    }
    /**
     * @Route("/posts/new", name="new_blog_post")
     **/
    public function addPost(Request $request, Slugify $slugify){

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug($this->uniqueSlug($slugify->slugify($post->getTitle())));
            $post->setCreateAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute("blog_posts");
        }
        return $this->render('posts/new.html.twig', [
            'form' => $form->CreateView(),
        ]);
    }

    /**
     * @Route("/posts/search", name="blog_search")
     */
    public function search(Request $request)
    {
        $query = $request->query->get('q');
        $posts = $this->postRepository->searchByQuery($query);

        return $this->render('posts/query_post.html.twig', [
            'posts' => $posts
        ]);
    }



    /**
     * @Route("/posts/{slug}/edit", name="blog_post_edit")
     */
    public function edit(Post $post, Request $request)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('one_post', [
                'slug' => $post->getSlug()
            ]);
        }

        return $this->render('posts/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/posts/{slug}/delete", name="blog_post_delete")
     */
    public function delete(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('blog_posts');
    }

    /**
     * @Route("/posts/{slug}", name="one_post")
     */
    public function post(Post $post)
    {
        return $this->render('posts/one_post.html.twig', [
            'post' => $post
        ]);
    }
        protected function uniqueSlug($slug)
        {
            //$newSlug = $slugify->slugify($post->getTitle());
            $criteria = ['slug' => $slug];
            $isSlugExist = $this->postRepository->findBy($criteria);
            $idLastPost = $this->postRepository->findLast();
            if($isSlugExist && $isSlugExist[0]->getSlug() == $slug)
            {
                $slug = $slug .'-'. $idLastPost[0]->getId();
                return $slug;
            }else{
                return $slug;
            }
        }


}