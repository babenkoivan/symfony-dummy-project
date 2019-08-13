<?php
declare(strict_types=1);

namespace App\Tests\Unit\Controller;

use App\Controller\HealthController;
use Doctrine\DBAL\Connection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

final class HealthControllerTest extends TestCase
{
    public function test_status_is_up_when_database_connection_is_established(): void
    {
        $connectionMock = $this->createConnectionMock(true);
        $controller = new HealthController($connectionMock);
        $response = $controller->status();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertContains('Up', $response->getContent());
    }

    public function test_status_is_down_when_cant_connect_to_database(): void
    {
        $connectionMock = $this->createConnectionMock(false);
        $controller = new HealthController($connectionMock);
        $response = $controller->status();

        $this->assertSame(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $this->assertContains('Down', $response->getContent());
    }

    /**
     * @param bool $reachable
     * @return MockObject
     */
    private function createConnectionMock(bool $reachable): MockObject
    {
        $connectionMock = $this->createMock(Connection::class);

        $connectionMock
            ->expects($this->once())
            ->method('connect')
            ->willReturn($reachable);

        return $connectionMock;
    }
}
