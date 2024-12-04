<?php
// src/Security/LoginSuccessHandler.php
// src/Security/LoginSuccessHandler.php
namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Response;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?Response
    {
        // Get the user's roles
        $roles = $token->getRoleNames();

        // Check if the user has the ROLE_ADMIN role
        if (in_array('ROLE_ADMIN', $roles)) {
            return new RedirectResponse($this->router->generate('admin')); // Redirect to /admin for admins
        }

        // Otherwise, redirect to the homepage for normal users
        return new RedirectResponse($this->router->generate('app_home')); // Redirect to /
    }
}
