<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Document\Blog;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ODM\MongoDB\Query\Builder;

class BlogApiController extends AbstractController
{
    /**
     * @Route("/blog", name="api_blog_get")
     */
    public function getBlog(DocumentManager $dm)
    {
        $result = $dm->getRepository(Blog::class)->findAll();

        $jsonResult = $this->toJson($result);

        return JsonResponse::create($jsonResult);
    }

    /**
     * @Route("/blog", name="api_blog_addItem")
     */
    public function addBlog(Request $request, DocumentManager $dm)
    {
        $data = json_decode($request->getContent(), true);
        $date = date('Y/m/d H:i:s');
        $data['date'] = $date;
        $blogId = uniqid();
 
        $blog = new Blog();
        $blog->setDetails($blogId, $data['title'], $data['description'], $date, $data['author'], $data['comments']);

        $dm->persist($blog);
        $dm->flush();
        
        $data['blogId'] = $blogId;
        return JsonResponse::create($data);
    }

    /**
     * @Route("/blog/{blogId}/comments", name="api_blog_addComments")
     */
    public function addComments(Request $request, $blogId, DocumentManager $dm)
    {
        $data = json_decode($request->getContent(), true);
        $date = date('Y/m/d H:i:s');
        $data['date'] = $date;
        
        $serializer = SerializerBuilder::create()->build();

        $result = $dm->createQueryBuilder(Blog::class)
            ->field('blogId')->equals($blogId);

        $blog = $this->toJson($result);
        array_push($blog->query[0]->comments, $data);

        $result
            ->updateOne()
            ->field('comments')->set($blog->query[0]->comments)
            ->getQuery()
            ->execute();
        
        $dm->flush();

        return JsonResponse::create($blog->query[0]);
    }

    public function toJson($result){
        $serializer = $this->container->get('serializer')
            ->normalize($result, 'json');

        return json_decode(json_encode($serializer));

    }


}
