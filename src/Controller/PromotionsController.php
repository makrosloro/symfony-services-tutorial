<?php

namespace App\Controller;


use App\DTO\LowestPriceEnquiry;
use App\Filter\PromotionsFilterInterface;
use App\Service\Serializer\DTOSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PromotionsController extends AbstractController
{

    #[Route('/products/{id}/lowest-price', name: 'lowest-price', methods: 'POST')]
    public function lowestPrice(
        Request                   $request,
        int                       $id,
        DTOSerializer             $serializer,
        PromotionsFilterInterface $promotionsFilter
    ): Response
    {
        if ($request->headers->has('force_fail')) {
            return new JsonResponse(
                ['error' => 'Promotions Engine failure message'],
                $request->headers->get('force_fail')
            );
        }


        $lowestPriceEnquiry = $serializer->deserialize(
            $request->getContent(),
            LowestPriceEnquiry::class,
            'json'
        );

        $modifiedEnquiry = $promotionsFilter->apply($lowestPriceEnquiry);

        $responseContent = $serializer->serialize($modifiedEnquiry, 'json');

        return new Response($responseContent, Response::HTTP_OK);
    }

    #[Route('/products/{id}/promotions', name: 'promotions', methods: 'GET')]
    public function promotions()
    {

    }

}
