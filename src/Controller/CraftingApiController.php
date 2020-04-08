<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Document\Crafting;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializerBuilder;

class CraftingApiController extends AbstractController
{

    /**
     * @Route("/api/crafting/{itemId?}", name="api_crafting_get")
     */
    public function getCraftingItems(DocumentManager $dm, $itemId)
    {
        global $response;
        $serializer = SerializerBuilder::create()->build();

        if ($itemId)
            $result = $dm->createQueryBuilder(Crafting::class)
                ->field('itemId')->equals((int)$itemId);
        else
            $result = $dm->getRepository(Crafting::class)->findAll();
        
        $jsonResult = $this->toJson($result);

        return JsonResponse::create($jsonResult);

    }


    /**
     * @Route("/api/crafting", name="api_crafting_addItem")
     */
    public function addCraftingItem(Request $request, DocumentManager $dm)
    { 
        
        $data = json_decode($request->getContent(), true);       

        $crafting = new Crafting();
        $crafting->setDetails($data['itemId'], $data['name'], $data['number'], $data['need'], $data['image']);

        $dm->persist($crafting);
        $dm->flush();

        return JsonResponse::create($data);

    }


    public function toJson($result){       
        $serializer = $this->container->get('serializer')
            ->normalize($result, 'json');
        
        return json_decode(json_encode($serializer)); 

    }

}
