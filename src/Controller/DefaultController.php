<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
  public function index(Request $request): Response
  {
    return $this->redirectToRoute('login');
  }

  public function showmenu_admin(Request $request): Response
  {
    return $this->render('menu_admin.html.twig');
  }

  public function showPanelAdmin(Request $request): Response
  {
    return $this->render('panel_admin.html.twig');
  }
}
