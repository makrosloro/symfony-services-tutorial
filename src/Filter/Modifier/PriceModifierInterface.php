<?php

namespace App\Filter\Modifier;

use App\DTO\LowestPriceEnquiry;
use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

interface PriceModifierInterface
{
    public function modify(Promotion $promotion, PromotionEnquiryInterface $enquiry): int;
}
