<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DnsPageController extends AbstractController
{
    #[Route('/', name: 'dns_page', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('index.html.twig');
    }
}
