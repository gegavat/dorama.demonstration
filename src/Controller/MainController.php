<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\SliderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @var array
     * Список возвращаемых продуктов
     */
    protected $products = [];

    /**
     * @Route("/", name="main")
     */
    public function index(CategoryRepository $categoryRepository, ProductRepository $productRepository, SliderRepository $sliderRepository): Response
    {
        $categoryVisible = $categoryRepository->findByStatus(Category::STATUS_MAIN);
        $categoryHidden = $categoryRepository->findByStatus(Category::STATUS_ADDITIONAL);

        return $this->render('main/index.html.twig', [
            'categoryVisible' => $categoryVisible,
            'categoryHidden' => $categoryHidden,
//            'products' => $productRepository->findAll(),
            'slider' => $sliderRepository->findAll(),
            'sliderImagePath' => $this->getParameter('app.path.slider_images')
        ]);
    }

    /**
     * @Route("/get-product-data", name="get-product-data", methods={"GET"})
     */
    public function getProductData(Request $request, ProductRepository $productRepository): Response
    {
        $categoryId = $request->query->get('category_id');
        return new JsonResponse( $productRepository->getProductDataByCategory($categoryId, $this->getParameter('app.path.product_images')) );
    }

    /**
     * @Route("/get-product-modal", name="get-product-modal", methods={"GET"})
     */
    public function getProductModal(Request $request, ProductRepository $productRepository): Response
    {
        $productId = $request->query->get('id');
        return $this->render('main/product_modal.html.twig', [
            'imagePath' => $this->getParameter('app.path.product_images'),
            'product' => $productRepository->findOneById($productId),
        ]);
    }
}
