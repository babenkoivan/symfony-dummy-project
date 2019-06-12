<?php

namespace App\Tests\Unit\Controller;

use App\Controller\ProductController;
use App\Entity\Product;
use App\Tests\Support\Kernel;
use App\Tests\Support\CsrfTokenManager;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

final class ProductControllerTest extends TestCase
{
    use Kernel, CsrfTokenManager;

    /**
     * @return array
     */
    public function validProductAddFormValues(): array
    {
        return [
            ['test 1', 0.10],
            ['test 2', 100],
        ];
    }

    /**
     * @return array
     */
    public function invalidProductAddFormValues(): array
    {
        return [
            ['test', 0],
            ['tes', 100],
            ['', -100],
        ];
    }

    /**
     * @dataProvider invalidProductAddFormValues
     * @param string $name
     * @param float $price
     */
    public function test_product_is_not_persisted_when_submitted_invalid_form(string $name, float $price): void
    {
        $request = $this->makeProductAddRequest($name, $price);
        $entityManagerMock = $this->createMock(EntityManager::class);

        $entityManagerMock
            ->expects($this->never())
            ->method('persist');

        $entityManagerMock
            ->expects($this->never())
            ->method('flush');

        $controller = new ProductController($entityManagerMock);
        $controller->setContainer(static::$container);
        $result = $controller->add($request);

        $this->assertArrayHasKey('formView', $result);
        $this->assertInstanceOf(FormView::class, $result['formView']);
    }

    /**
     * @dataProvider validProductAddFormValues
     * @param string $name
     * @param float $price
     */
    public function test_product_is_persisted_when_submitted_valid_form(string $name, float $price): void
    {
        $request = $this->makeProductAddRequest($name, $price);
        $entityManagerMock = $this->createMock(EntityManager::class);

        $product = (new Product())
            ->setName($name)
            ->setPrice($price);

        $entityManagerMock
            ->expects($this->once())
            ->method('persist')
            ->with($product)
            ->willReturnCallback(function ($product) {
                $productReflection = new ReflectionClass($product);
                $idPropertyReflection = $productReflection->getProperty('id');
                $idPropertyReflection->setAccessible(true);
                $idPropertyReflection->setValue($product, rand());
            });

        $entityManagerMock
            ->expects($this->once())
            ->method('flush');

        $controller = new ProductController($entityManagerMock);
        $controller->setContainer(static::$container);
        $result = $controller->add($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    /**
     * @param string $name
     * @param float $price
     * @return Request
     */
    private function makeProductAddRequest(string $name, float $price): Request
    {
        $request = new Request([], [
            'product_add' => [
                'name' => $name,
                'price' => $price,
                'save' => '',
                '_token' => $this->generateCsrfToken('product_add_form')->getValue(),
            ],
        ]);

        $request->setMethod(Request::METHOD_POST);

        return $request;
    }
}
