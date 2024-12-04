<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\LivreRepository;

class CartService
{
    private $session;
    private $livreRepository;

    public function __construct(SessionInterface $session, LivreRepository $livreRepository)
    {
        $this->session = $session;
        $this->livreRepository = $livreRepository;
    }

    // Get the cart from session
    public function getCart(): array
    {
        return $this->session->get('cart', []);
    }

    // Add item to cart
    public function addToCart(int $livreId)
    {
        $cart = $this->getCart();

        // Check if the book is already in the cart
        if (isset($cart[$livreId])) {
            // If it is, increase the quantity
            $cart[$livreId]['quantity']++;
        } else {
            // Otherwise, add it with quantity 1
            $livre = $this->livreRepository->find($livreId);
            if ($livre) {
                $cart[$livreId] = [
                    'livre' => $livre,
                    'quantity' => 1,
                ];
            }
        }

        // Save the updated cart back to the session
        $this->session->set('cart', $cart);
    }

    // Remove item from cart
    public function removeFromCart(int $livreId)
    {
        $cart = $this->getCart();
        unset($cart[$livreId]); // Remove the item
        $this->session->set('cart', $cart);
    }

    // Clear the cart
    public function clearCart()
    {
        $this->session->remove('cart');
    }
}
