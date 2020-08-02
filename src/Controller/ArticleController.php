<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", methods="GET", name="articles_index")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repository->findAll();

        return $this->render('article/index.html.twig', compact('articles'));
    }

    /**
     * @Route("/articles/create", methods="GET", name="articles_create")
     */
    public function create()
    {
        return $this->render('article/create.html.twig');
    }

    /**
     * @Route("/articles", methods="POST", name="articles_store")
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $title = $request->get('title');
        $body = $request->get('body');

        $manager = $this->getDoctrine()->getManager();

        $entity = new Article();
        $entity->setTitle($title);
        $entity->setBody($body);

        $manager->persist($entity);
        $manager->flush();

        return $this->redirectToRoute('articles_index');
    }

    /**
     * @Route("/articles/{id}", methods="GET", name="articles_show")
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);

        $article = $repository->find($id);

        return $this->render('article/show.html.twig', compact('article'));
    }

    /**
     * @Route("/articles/{id}/edit", methods="GET", name="articles_edit")
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);

        $article = $repository->find($id);

        return $this->render('article/edit.html.twig', compact('article'));
    }

    /**
     * @Route("/articles/{id}", methods="PUT", name="articles_update")
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $title = $request->get('title');
        $body = $request->get('body');

        $manager = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Article::class);

        $entity = $repository->find($id);
        $entity->setTitle($title);
        $entity->setBody($body);

        $manager->flush();

        return $this->redirectToRoute('articles_index');
    }

    /**
     * @Route("/articles/{id}", methods="DELETE", name="articles_delete")
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $repository = $this->getDoctrine()->getRepository(Article::class);

        $manager = $this->getDoctrine()->getManager();

        $entity = $repository->find($id);
        $manager->remove($entity);

        $manager->flush();

        return $this->redirectToRoute('articles_index');
    }
}
