<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Livre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(EntityManagerInterface $em): Response
    {
        // Fetch the current user's cart or create a new one if not exists
        $cart = $this->getCart($em);

        // Calculate the cart total
        $cartTotal = 0;
        foreach ($cart->getItems() as $item) {
            $cartTotal += $item->getProduct()->getPrix() * $item->getQuantity();
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getItems(), // Pass the cart items to the view
            'cartTotal' => $cartTotal,
        ]);
    }



    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function addToCart(Livre $product, EntityManagerInterface $em): Response
    {
        $cart = $this->getCart($em);
        if (!$this->getUser()) {
           // $this->addFlash('error', 'You must be logged in to add items to the cart.');
            return $this->redirectToRoute('app_login'); // Redirect to the login page
        }

        // Check if the product already exists in the cart
        foreach ($cart->getItems() as $item) {
            if ($item->getProduct() === $product) {
                $item->setQuantity($item->getQuantity() + 1);
                $em->flush();

                $this->addFlash('success', 'Product quantity updated in the cart.');
                return $this->redirectToRoute('app_cart');
            }
        }

        // Create a new CartItem if the product is not already in the cart
        $cartItem = new CartItem();
        $cartItem->setProduct($product);
        $cartItem->setQuantity(1);
        $cartItem->setCart($cart);

        $em->persist($cartItem);
        $em->flush();

        $this->addFlash('success', 'Product added to the cart.');
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function removeFromCart(CartItem $item, EntityManagerInterface $em): Response
    {
        // Ensure the item belongs to the logged-in user
        $user = $this->getUser();
        $cart = $item->getCart(); // Assuming CartItem has a 'cart' property
        
        if ($cart->getUser() !== $user) {
            // If the cart item does not belong to the logged-in user, deny the request
            $this->addFlash('error', 'This item does not belong to your cart.');
            return $this->redirectToRoute('app_cart');
        }

        // Remove the cart item
        $em->remove($item);
        $em->flush();

        // Add a flash message to inform the user that the item was removed
        $this->addFlash('success', 'Product removed from the cart.');

        // Redirect to the cart page
        return $this->redirectToRoute('app_cart');
    }


// src/Controller/CartController.php
    #[Route('/cart/update/{productId}', name: 'cart_update', methods: ['POST'])]
    public function updateCartItem(int $productId, Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);
        $quantity = $data['quantity'] ?? 1;

        // Fetch the cart item to update
        $cart = $this->getCart($em);  // Get the current cart
        $cartItem = $em->getRepository(CartItem::class)->findOneBy(['cart' => $cart, 'product' => $productId]);

        if ($cartItem) {
            $cartItem->setQuantity($quantity);
            $em->flush();
            
            // Return a JSON response to indicate success
            return $this->json(['success' => true]);
        }

        // If cart item not found, return failure response
        return $this->json(['success' => false]);
    }






    private function getCart(EntityManagerInterface $em): Cart
    {
        $user = $this->getUser(); // Get the currently logged-in user
        if (!$user) {
            return $this->redirectToRoute('app_login'); // Redirect to login if no user is logged in
        }

        // Check if the user already has a cart
        $cart = $em->getRepository(Cart::class)->findOneBy(['user' => $user]);

        if (!$cart) {
            // Create a new cart if none exists
            $cart = new Cart();
            $cart->setUser($user);
            $em->persist($cart);
            $em->flush();
        }

        return $cart;
    }
}
