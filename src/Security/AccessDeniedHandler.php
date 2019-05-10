<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        if ($accessDeniedException->getAttributes()[0] === "ROLE_SUPER_ADMIN") {
            return new RedirectResponse("/admin/");

        } else if ($accessDeniedException->getAttributes()[0] === "ROLE_ADMIN" ||
            $accessDeniedException->getAttributes()[0] === "ROLE_USER") {
            return new RedirectResponse("/");
        }
        return new Response("403", 403);
    }
}