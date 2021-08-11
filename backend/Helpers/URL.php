<?php


namespace App\Helpers;


use App\Application;

class URL
{
    private array $routeMap = [
        'index' => '/',
        '/'     => '/',
        ''      => '/',
    ];

    public function segment(string $url)
    {
        if ($url === '/') {
            return $url;
        }
        $hasQueryParams = $this->readQueryParams($url);
        if (!$hasQueryParams) {
            $segments = explode('/', $url);
            $segments = array_values(array_filter($segments));
            $requestedRoute = end($segments);
            if (in_array($requestedRoute, $this->routeMap)) {
                return $this->routeMap[$this->removeFileExtensions($requestedRoute)];
            }
            return $this->removeFileExtensions($requestedRoute);
        }

        // TODO: query params handling
        return '';
    }

    private function removeFileExtensions(string $path): bool|string
    {
        $elements = explode('.', $path);
        if (end($elements)) {
            return reset($elements);
        }
        return $path;
    }

    private function readQueryParams(string $url): bool
    {
        $parsed = parse_url($url);
        if (isset($parsed['query'])) {
            return true;
        }
        if (isset($parsed['path'])) {
            $path = explode('/', $parsed['path']);
            if (ctype_digit(end($path))) {
                $_GET['id'] = end($path);
            }
            return true;
        }

        return false;
    }
}