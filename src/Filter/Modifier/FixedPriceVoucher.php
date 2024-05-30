<?php

namespace App\Filter\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

class FixedPriceVoucher implements PriceModifierInterface
{

    public function modify(Promotion $promotion, PromotionEnquiryInterface $enquiry): int
    {
        $voucherCode = $enquiry->getVoucherCode();
        $promotionVoucherCode = $promotion->getCriteria()['code'];

        if (!($voucherCode === $promotionVoucherCode)) {
            return $enquiry->getPrice() * $enquiry->getQuantity();
        }

        return $promotion->getAdjustment() * $enquiry->getQuantity();
    }
}
