<?php

namespace App\Filter\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;
use App\Filter\Modifier\PriceModifierInterface;

class EvenItemsMultiplier implements PriceModifierInterface
{

    public function modify(Promotion $promotion, PromotionEnquiryInterface $enquiry): int
    {
        if ($enquiry->getQuantity() < 2) {

            return $enquiry->getPrice() * $enquiry->getQuantity();
        }

        $oddCount = $enquiry->getQuantity() % 2;
        $evenCount = $enquiry->getQuantity() - $oddCount;

        return (($evenCount * $enquiry->getPrice()) * $promotion->getAdjustment()) + ($oddCount * $enquiry->getPrice());
    }
}
