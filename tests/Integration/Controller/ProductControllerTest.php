<?php

namespace App\Tests\Integration\Controller;

use App\Entity\Product;
use App\Tests\Support\CsrfTokenManager;
use App\Tests\Support\Database;
use App\Tests\Support\HttpClient;
use App\Tests\Support\Kernel;
use App\Tests\Support\Router;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class ProductControllerTest extends TestCase
{
    use Kernel, CsrfTokenManager, HttpClient, Router, Database;

    public function test_product_is_saved_in_database_when_submitted_valid_form(): void
    {
        $name = uniqid('product_add_test_', true);
        $price = rand(1, 1000);

        $httpClient = $this->createClient();
        $repository = $this->entityManager->getRepository(Product::class);

        $httpClient->request(Request::METHOD_POST, $this->generateUrl('product_add'), [
            'product_add' => [
                'name' => $name,
                'price' => $price,
                'save' => '',
                '_token' => $this->generateCsrfToken('product_add_form')->getValue(),
            ],
        ]);

        $response = $httpClient->getResponse();
        $product = $repository->findOneByName($name);

        $this->assertEquals($price, $product->getPrice());
        $this->assertSame(302, $response->getStatusCode());
        $this->assertSame($response->getTargetUrl(), $this->generateUrl('product_show', ['id' => $product->getId()]));
    }
}
