<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'checkout')]
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {
        $cart = $session->get('cart', []);
        $cartData = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            if ($product) {
                $cartData[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
                $total += $product->getPrice() * $quantity;
            }
        }

        return $this->render('checkout/index.html.twig', [
            'items' => $cartData,
            'total' => $total
        ]);
    }

    #[Route('/checkout/success', name: 'checkout_success')]
    public function success(
        SessionInterface $session,
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $cart = $session->get('cart', []);
        
        if (empty($cart)) {
            return $this->redirectToRoute('cart_index');
        }

        // Create new order
        $order = new Order();
        $order->setUser($this->getUser());
        $order->setStatus(Order::STATUS_PENDING);
        $order->setCreatedAt(new \DateTimeImmutable());

        $total = 0;

        // Add items to order
        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            if ($product) {
                $orderItem = new OrderItem();
                $orderItem->setProduct($product);
                $orderItem->setQuantity($quantity);
                $orderItem->setPrice($product->getPrice());
                $orderItem->setOrder($order);
                
                $total += $product->getPrice() * $quantity;
                
                $entityManager->persist($orderItem);
                $order->addOrderItem($orderItem);
            }
        }

        $order->setTotal($total);
        
        // Save everything
        $entityManager->persist($order);
        $entityManager->flush();

        // Clear the cart
        $session->remove('cart');

        return $this->render('checkout/success.html.twig', [
            'order' => $order,
        ]);
    }
} 