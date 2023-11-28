<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Calc;

use App\Controller\Calc\Controller;
use App\Tests\Functional\Admin\KernelTest;


/**
 * @see Controller
 */
class ControllerTest  extends KernelTest
{
    public function testAddSuccess(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['numOne' => '2', 'numTwo' => '2','operand' => '+']
        );

        self::assertEquals('4', $response->content['result']);
    }
    public function testAddFail(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['numOne' => '2', 'numTwo' => '2','operand' => '+']
        );

        self::assertNotEquals('5', $response->content['result']);
    }

    public function testSubSuccess(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['numOne' => '2', 'numTwo' => '2','operand' => '-']
        );

        self::assertEquals('0', $response->content['result']);
    }

    public function testSubFail(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['numOne' => '2', 'numTwo' => '2','operand' => '-']
        );

        self::assertNotEquals('1', $response->content['result']);
    }

    public function testMultipleSuccess(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['numOne' => '2', 'numTwo' => '2','operand' => '*']
        );

        self::assertEquals('4', $response->content['result']);
    }

    public function testMultipleFail(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['numOne' => '2', 'numTwo' => '2','operand' => '*']
        );

        self::assertNotEquals('5', $response->content['result']);
    }

    public function testDivSuccess(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['numOne' => '2', 'numTwo' => '2','operand' => '/']
        );

        self::assertEquals('1', $response->content['result']);
    }

    public function testDivFail(): void
    {

        $response = $this->requester()->post(
            routeClass: Controller::class,
            content: ['numOne' => '2', 'numTwo' => '2','operand' => '/']
        );

        self::assertNotEquals('5', $response->content['result']);
    }
}