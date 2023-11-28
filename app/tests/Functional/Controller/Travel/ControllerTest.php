<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Travel;

use App\Tests\Functional\Admin\KernelTest;
use App\Controller\Travel\Controller;

/**
 * @see Controller
 */
class ControllerTest extends KernelTest
{
    public function testThree(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['price' => '10000', 'birthday' => $this->getDate('-1 year')]
        );

        self::assertEquals('2000', $response->content['result']);
        self::assertEquals(date('d.m.Y'), $response->content['travel_date']);
    }

    public function testSix(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['price' => '10000', 'birthday' => $this->getDate('-5 year')]
        );

        self::assertEquals('7000', $response->content['result']);
        self::assertEquals(date('d.m.Y'), $response->content['travel_date']);
    }

    public function testSixMAxPrice(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['price' => '20000', 'birthday' => $this->getDate('-5 year')]
        );

        self::assertEquals('15500', $response->content['result']);
        self::assertEquals(date('d.m.Y'), $response->content['travel_date']);
    }



    public function testTwelve(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['price' => '10000', 'birthday' => $this->getDate('-8 year')]
        );

        self::assertEquals('9000', $response->content['result']);
        self::assertEquals(date('d.m.Y'), $response->content['travel_date']);
    }

    public function testMore(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['price' => '10000', 'birthday' => $this->getDate('-15 year')]
        );


        self::assertEquals('10000', $response->content['result']);
        self::assertEquals(date('d.m.Y'), $response->content['travel_date']);
    }

    public function testDate() {
        $dateTravel = $this->getDate('+5 day');
        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['price' => '10000', 'birthday' => $this->getDate('-15 year'),'travel_date' => $dateTravel]
        );

        self::assertEquals('10000', $response->content['result']);
        self::assertEquals($dateTravel, $response->content['travel_date']);
    }

}