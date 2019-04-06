<?php

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products/{id}", name="product", methods={"GET"})
     * @Template(vars={"product"})
     * @param Product $product
     */
    public function show(Product $product): void
    {

    }
}
