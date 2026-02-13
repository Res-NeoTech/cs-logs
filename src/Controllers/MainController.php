<?php

namespace CsLogs\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use CsLogs\Models\Item;


class MainController
{
    function home(Request $req, Response $resp, array $args): Response
    {
        Item::selectAll("AK-47");

        $view = new PhpRenderer("../view");
        $view->setLayout("layout.php");
        $data = [
            'title' => "Homepage",
            'items' => Item::$items
        ];

        return $view->render($resp, 'home.php', $data);
    }

    function itemDetails(Request $req, Response $resp, array $args): Response
    {
        $view = new PhpRenderer("../view");
        $view->setLayout("layout.php");

        $itemId = $args["id"];

        $selectedItem = Item::getById($itemId);

        $data = [
            'title' => "Item Details",
            'item' => $selectedItem
        ];

        return $view->render($resp, 'itemDetails.php', $data);
    }

    function api(Request $req, Response $resp, array $args): Response
    {
        $resp->getBody()->write("Slim API is working !!");
        return $resp->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
