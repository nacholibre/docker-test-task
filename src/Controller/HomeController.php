<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;

use App\Service\FeedParserService;
use App\Entity\FeedPost;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(FeedParserService $feedParserService)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('App:FeedPost');

        $fetched = $feedParserService->parseFeedsIfNeeded();

        $maxResults = 10;
        $posts = $repo->findBy([], ['dateCreated' => 'DESC'], $maxResults);

        return $this->render('home/index.html.twig', [
            'fetched' => $fetched,
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/json", name="json")
     */
    public function jsonOutput(FeedParserService $feedParserService) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('App:FeedPost');
        $posts = $repo->findBy([], ['dateCreated' => 'DESC']);

        $data = [];

        foreach($posts as $post) {
            $data[] = [
                'title' => $post->getTitle(),
                'author' => $post->getAuthorName(),
                'subTitle' => $post->getHeadline(),
                'article' => $post->getBody(),
                'publishedAt' => $post->getDateCreated()->format('Y-m-d H:i:s'),
            ];
        }

        return $this->json($data);
    }
}
