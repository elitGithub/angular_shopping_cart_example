<?php


namespace App\Helpers;


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
        $segments = explode('/', $url);
        $requestedRoute = end($segments);
        $hasQueryParams = strpos($requestedRoute, '?');
        if (!$hasQueryParams) {
            if (in_array($requestedRoute, $this->routeMap)) {
                return $this->routeMap[$this->removeFileExtensions($requestedRoute)];
            }
            return $this->removeFileExtensions($requestedRoute);
        }

        // TODO: query params handling
        return $requestedRoute;
    }

    private function removeFileExtensions(string $path): bool|string
    {
        $elements = explode('.', $path);
        if (end($elements)) {
            return reset($elements);
        }
        return $path;
    }
}