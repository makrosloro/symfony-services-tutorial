<?php

namespace unit;

use App\DTO\LowestPriceEnquiry;
use App\Entity\Promotion;
use App\Filter\Modifier\DateRangeMultiplier;
use App\Filter\Modifier\EvenItemsMultiplier;
use App\Filter\Modifier\FixedPriceVoucher;
use App\Tests\ServiceTestCase;

class PriceModifiersTest extends ServiceTestCase
{
    /** @test  */
    public function date_range_multiplier_returns_a_correctly_modified_price(): void
    {
        //-- Given
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setPrice(100);
        $enquiry->setRequestDate('2022-11-27');

        $promotion = new Promotion();
        $promotion->setName('Black Friday half price sale');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria(['from' => '2022-11-25', 'to' => '2022-11-28']);
        $promotion->setType('date_range_multiplier');

        $dateRangeMultiplier = new DateRangeMultiplier();

        //-- When
        $modifiedPrice = $dateRangeMultiplier->modify($promotion, $enquiry);

        //-- Then
        $this->assertEquals(250, $modifiedPrice);
    }

    /** @test  */
    public function fixed_price_voucher_returns_a_correctly_modified_price(): void
    {
        //-- Given
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setPrice(150);
        $enquiry->setVoucherCode('OU812');


        $promotion = new Promotion();
        $promotion->setName('Voucher OU812');
        $promotion->setAdjustment(100);
        $promotion->setCriteria(['code' => 'OU812']);
        $promotion->setType('fixed_price_voucher');

        $fixedPriceVoucher = new FixedPriceVoucher();

        //-- When
        $modifiedPrice = $fixedPriceVoucher->modify($promotion, $enquiry);

        //-- Then
        $this->assertEquals(500, $modifiedPrice);
    }

    /** @test */
    public function even_items_multiplier_returns_a_correctly_modified_price(): void
    {
        //-- Given
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setPrice(100);

        $promotion = new Promotion();
        $promotion->setName('Buy one get one free');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria(['minimun_quantity' => 2]);
        $promotion->setType('even_items_multiplier');

        $evenItemsMultiplier = new EvenItemsMultiplier();

        //-- When
        $modifiedPrice = $evenItemsMultiplier->modify($promotion, $enquiry);

        //-- Then
        $this->assertEquals(300, $modifiedPrice);
    }

    /** @test */
    public function even_items_multiplier_correctly_calculates_alternatives(): void
    {
        //-- Given
        $enquiry = new LowestPriceEnquiry();
        $enquiry->setQuantity(5);
        $enquiry->setPrice(100);

        $promotion = new Promotion();
        $promotion->setName('Buy one get one half price');
        $promotion->setAdjustment(0.5);
        $promotion->setCriteria(['minimun_quantity' => 2]);
        $promotion->setType('even_items_multiplier');

        $evenItemsMultiplier = new EvenItemsMultiplier();

        //-- When
        $modifiedPrice = $evenItemsMultiplier->modify($promotion, $enquiry);

        //-- Then
        $this->assertEquals(300, $modifiedPrice);
    }
}
