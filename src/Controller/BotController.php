<?php

namespace App\Controller;

use App\Service\BotService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BotController extends AbstractController
{
    private $botService;

    public function __construct(BotService $botService)
    {
        $this->botService = $botService;
    }

    /**
     * @Route("/set")
     * @return JsonResponse
     */
    public function set()
    {
        $msg = $this->botService->set();

        return new JsonResponse(['msg' => $msg]);
    }

    /**
     * @Route("/unset")
     * @return JsonResponse
     */
    public function unset()
    {
        $msg = $this->botService->unset();

        return new JsonResponse(['msg' => $msg]);
    }

    /**
     * @Route("/hook")
     * @return JsonResponse
     */
    public function getHook()
    {
        $msg = $this->botService->hook();

        return new JsonResponse(['msg' => $msg]);
    }
}
