<?php
namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commande ;
use App\Entity\CommandeItem;

class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout')]
    public function index(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        
        // Fetch the cart for the logged-in user
        $cart = $this->getCart($em, $user);

        // Calculate cart total
        $cartTotal = 0;
        foreach ($cart->getItems() as $item) {
            $cartTotal += $item->getProduct()->getPrix() * $item->getQuantity();
        }

        return $this->render('checkout/index.html.twig', [
            'cart' => $cart,
            'cartTotal' => $cartTotal,
        ]);
    }

    #[Route('/checkout/process', name: 'checkout_process', methods: ['POST'])]
public function processCheckout(Request $request, EntityManagerInterface $em): Response
{
    $user = $this->getUser();
    $cart = $this->getCart($em, $user);

    // Fetch the cart for the user
    $cart = $em->getRepository(Cart::class)->findOneBy(['user' => $user]);

    if (!$cart || $cart->getItems()->isEmpty()) {
        $this->addFlash('error', 'Your cart is empty.');
        return $this->redirectToRoute('app_cart');
    }

    // Create the Commande
    $commande = new Commande();
    $commande->setUser($user);

    $total = 0;

    foreach ($cart->getItems() as $cartItem) {
        $commandeItem = new CommandeItem();
        $commandeItem->setProduct($cartItem->getProduct());
        $commandeItem->setQuantity($cartItem->getQuantity());
        $commandeItem->setPrice($cartItem->getProduct()->getPrix());
        $commandeItem->setCommande($commande);

        $total += $cartItem->getProduct()->getPrix() * $cartItem->getQuantity();
        $commande->getItems()->add($commandeItem);
    }

    $commande->setTotal($total);

    $em->persist($commande);

    // Optionally, clear the cart after checkout
    foreach ($cart->getItems() as $cartItem) {
        $em->remove($cartItem);
    }
    $em->remove($cart);

    $em->flush();

    $this->addFlash('success', 'Your order has been placed successfully.');
    return $this->redirectToRoute('app_profile');
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
