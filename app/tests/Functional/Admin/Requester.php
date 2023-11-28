<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;


use App\Exceptions\UnexpectedValueException;
use App\Tests\Functional\Dto;
use PHPUnit\Framework\Assert;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestAssertionsTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Generator\CompiledUrlGenerator;

class Requester extends Assert
{
    use WebTestAssertionsTrait;

    public function __construct(
        private readonly KernelBrowser $client,
        private readonly RouterInterface $router
    ) {
    }

    /**
     * @param class-string      $routeClass
     * @param string|false|null $token      false: *default bearer token*,
     *                                      string: "Bearer: <token>",
     *                                      null: *anonymous*
     *
     * @throws \JsonException
     */
    public function post(
        string $routeClass,
        array $routeParams = [],
        array $content = [],
        array $files = [],
        null | string | false $token = false,
        int $expectCode = Response::HTTP_OK
    ): Dto\Response {
        $path = $this->getPath($routeClass, $routeParams);
        $content = json_encode($content, \JSON_THROW_ON_ERROR);

        $this->client->request('POST', $path, [], $files, $this->headers($token), $content);
        $response = $this->response();
        $this->assertResponseStatusCode($response, $expectCode);

        return $response;
    }

    public function postJSON(
        string $routeName,
        array $routeParams = [],
        array $content = [],
        array $files = [],
        int $expectCode = Response::HTTP_OK
    ): Dto\Response {
        $path = $this->getPath($routeName, $routeParams);
        $content = json_encode($content, \JSON_THROW_ON_ERROR);

        $this->client->request('POST', $path, [], $files, ['CONTENT_TYPE' => 'application/json'], $content);
        $response = $this->response();
        $this->assertResponseStatusCode($response, $expectCode);

        return $response;
    }

    /**
     * @param string|false|null $token false: *default bearer token*,
     *                                 string: "Bearer: <token>",
     *                                 null: *anonymous*
     *
     * @return array<string, string>
     */
    private function headers(null | string | false $token = false, bool $json = true): array
    {
        $headers = [];

        if ($json) {
            $headers['CONTENT_TYPE'] = 'application/json';
            $headers['HTTP_ACCEPT'] = 'application/json';
        }


        return $headers;
    }

    /**
     * @param class-string $className
     */
    private function getPath(string $className, array $params = []): string
    {
        if (!class_exists($className) || !is_subclass_of($className, AbstractController::class)) {
            throw new UnexpectedValueException(AbstractController::class, $className);
        }

        return $this->router->generate($className, $params);
    }

    private function response(): Dto\Response
    {
        $response = $this->client->getResponse();
        $data = [
            'code' => $response->getStatusCode(),
            'type' => $response->headers->get('content_type'),
            'headers' => $response->headers,
        ];

        $content = $response->getContent();
        if (\in_array($data['type'], ['application/json', 'application/vnd.api+json'])) {
            $content = json_decode((string) $content, true, 512, \JSON_THROW_ON_ERROR);
        }


        $data['content'] = \is_array($content) && \array_key_exists('data', $content) && \is_array($content['data'])
            ? $content['data']
            : $content;

        $this->client->reload();

        return new Dto\Response($data);
    }

    private function assertResponseStatusCode(Dto\Response $response, int $expectCode = Response::HTTP_OK): void
    {
        if ($response->code !== $expectCode) {
            dd($response->content);
        }
        self::assertTrue($expectCode === $response->code, "expected code {$expectCode} !== {$response->code}");
    }

}