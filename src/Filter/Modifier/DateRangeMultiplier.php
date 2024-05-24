<?php

namespace App\Filter\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

class DateRangeMultiplier implements PriceModifierInterface
{

    public function modify(Promotion $promotion, PromotionEnquiryInterface $enquiry): int
    {
        $requestDate = date_create($enquiry->getRequestDate());
        $from = date_create($promotion->getCriteria()['from']);
        $to = date_create($promotion->getCriteria()['to']);

        if (!($requestDate >= $from && $requestDate < $to)) {
            return ($enquiry->getPrice() * $enquiry->getQuantity());
        }

        return ($enquiry->getPrice() * $enquiry->getQuantity()) * $promotion->getAdjustment();
    }
}
