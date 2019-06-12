<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductAddType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/products/{id}", name="product_show", methods={"GET"}, requirements={"id"="\d+"})
     * @Template(vars={"product"})
     * @param Product $product
     */
    public function show(Product $product): void
    {

    }

    /**
     * @Route("/products/add", name="product_add", methods={"GET","POST"})
     * @Template()
     * @param Request $request
     * @return array|Response
     */
    public function add(Request $request)
    {
        $form = $this->createForm(ProductAddType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return ['formView' => $form->createView()];
    }
}
