<?php

namespace CsLogs\Controllers;

use CsLogs\Models\Item;
use CsLogs\Utils\Redis;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class MainController
{
    private LoggerInterface $logger;
    private const CACHE_KEY = 'item:AK-47';

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function home(Request $req, Response $resp, array $args): Response
    {
        $view = new PhpRenderer("../view");
        $view->setLayout("layout.php");

        $this->logger->info('Route home entered');

        try {
            $items = $this->getCachedItems();

            if (empty($items)) {
                $this->logger->info('Cache miss, loading items from source', [
                    'filter' => 'AK-47',
                ]);
                $items = Item::selectAll("AK-47");
                $this->storeItemsInCache($items);
            } else {
                $this->logger->info('Cache hit for homepage items', [
                    'cache_key' => self::CACHE_KEY,
                    'count' => count($items),
                ]);
            }

            $data = [
                'title' => "Homepage",
                'items' => $items,
            ];

            return $view->render($resp, 'home.php', $data);
        } catch (\Throwable $e) {
            $this->logger->error('Failed to render homepage', [
                'message' => $e->getMessage(),
                'exception_class' => $e::class,
            ]);
            $resp->getBody()->write('Internal Server Error');
            return $resp->withStatus(500);
        }
    }

    public function itemDetails(Request $req, Response $resp, array $args): Response
    {
        $view = new PhpRenderer("../view");
        $view->setLayout("layout.php");

        $itemId = isset($args["id"]) ? (int) $args["id"] : 0;
        $this->logger->info('Route itemDetails entered', ['itemId' => $itemId]);

        if ($itemId <= 0) {
            $this->logger->warning('Invalid item id provided', ['itemId' => $itemId]);
            $resp->getBody()->write('Invalid item id');
            return $resp->withStatus(400);
        }

        try {
            $selectedItem = Item::getById($itemId);
            if ($selectedItem === null) {
                $this->logger->warning('Item not found', ['itemId' => $itemId]);
                $resp->getBody()->write('Item not found');
                return $resp->withStatus(404);
            }

            $data = [
                'title' => "Item Details",
                'item' => $selectedItem,
            ];

            return $view->render($resp, 'itemDetails.php', $data);
        } catch (\Throwable $e) {
            $this->logger->error('Failed to render item details', [
                'itemId' => $itemId,
                'message' => $e->getMessage(),
                'exception_class' => $e::class,
            ]);
            $resp->getBody()->write('Internal Server Error');
            return $resp->withStatus(500);
        }
    }

    public function api(Request $req, Response $resp, array $args): Response
    {
        $this->logger->info('Route api entered');
        $resp->getBody()->write("Slim API is working !!");
        return $resp
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    private function getCachedItems(): array
    {
        try {
            $redis = Redis::get($this->logger);
            $cachedItems = $redis->get(self::CACHE_KEY);
            if (!is_string($cachedItems) || $cachedItems === '') {
                return [];
            }

            $decoded = json_decode($cachedItems, true);
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                $this->logger->warning('Invalid cache payload for items', [
                    'cache_key' => self::CACHE_KEY,
                    'json_error' => json_last_error_msg(),
                ]);
                return [];
            }

            return $decoded;
        } catch (\Throwable $e) {
            $this->logger->error('Redis cache read failed, falling back to source', [
                'cache_key' => self::CACHE_KEY,
                'message' => $e->getMessage(),
                'exception_class' => $e::class,
            ]);
            return [];
        }
    }

    private function storeItemsInCache(array $items): void
    {
        try {
            $redis = Redis::get($this->logger);
            $redis->set(self::CACHE_KEY, json_encode($items), 'EX', 60 * 5);
            $this->logger->debug('Items cached', [
                'cache_key' => self::CACHE_KEY,
                'count' => count($items),
            ]);
        } catch (\Throwable $e) {
            $this->logger->error('Redis cache write failed', [
                'cache_key' => self::CACHE_KEY,
                'message' => $e->getMessage(),
                'exception_class' => $e::class,
            ]);
        }
    }
}
