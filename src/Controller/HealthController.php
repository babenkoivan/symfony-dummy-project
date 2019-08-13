<?php
declare(strict_types=1);

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HealthController extends AbstractController
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @Route("/health", name="health_status", methods={"GET"})
     * @return Response
     */
    public function status(): Response
    {
        if ($this->connection->isConnected()) {
            return new Response('Up');
        } else {
            return new Response('Down: database connection error', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
