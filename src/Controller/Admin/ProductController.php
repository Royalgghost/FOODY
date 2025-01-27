<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/product')]
class ProductController extends AbstractController
{
    #[Route('/{id}/delete', name: 'admin_product_delete', methods: ['POST'])]
    public function delete(Product $product, EntityManagerInterface $entityManager): Response
    {
        // Remove related order items
        foreach ($product->getOrderItems() as $orderItem) {
            $entityManager->remove($orderItem);
        }

        // Remove related cart items
        foreach ($product->getCartItems() as $cartItem) {
            $entityManager->remove($cartItem);
        }

        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash('success', 'Product and related items deleted successfully!');
        return $this->redirectToRoute('admin_product_index');
    }
} 