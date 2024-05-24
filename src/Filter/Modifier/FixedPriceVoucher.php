<?php

namespace App\Filter\Modifier;

use App\DTO\PromotionEnquiryInterface;
use App\Entity\Promotion;

class FixedPriceVoucher implements PriceModifierInterface
{

    public function modify(int $price, int $quantity, Promotion $promotion, PromotionEnquiryInterface $enquiry): int
    {
        $voucherCode = $enquiry->getVoucherCode();
        $promotionVoucherCode = $promotion->getCriteria()['code'];

        if (!($voucherCode === $promotionVoucherCode)) {
            return $price * $quantity;
        }

        return $promotion->getAdjustment() * $quantity;
    }
}
