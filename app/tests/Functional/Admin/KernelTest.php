<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;



use App\Exceptions\UnexpectedValueException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;

class KernelTest extends WebTestCase
{
    protected ?RouterInterface $router;
    protected ?KernelBrowser $client = null;


    public function requester(): Requester
    {
        if (null === $this->client || null === $this->router) {
            throw new UnexpectedValueException('KernelBrowser, RouterInterface', null);
        }

        return new Requester($this->client, $this->router);
    }

    final protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->router = static::$kernel->getContainer()->get('router');
    }

    public function getDate(string $modify = null) :string
    {
        $birthday = new \DateTime();
        if($modify) {
            $birthday->modify($modify);
        }
       return $birthday->format('d.m.Y');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->client = null;
        $this->router = null;
    }
}