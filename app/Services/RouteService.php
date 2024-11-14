<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Routing\Route;
use Illuminate\Support\Str;

class RouteService
{
    private $name;

    private $path;

    private $method;

    private $domain;

    private $exceptVendor;

    private $onlyVendor;

    private $exceptPath;

    public function __construct(
        $method = '',
        $exceptPath = '',
        $name = '',
        $path = '',
        $domain = '',
        $exceptVendor = false,
        $onlyVendor = false
    ) {
        $this->name = $name;
        $this->path = $path;
        $this->method = $method;
        $this->domain = $domain;
        $this->exceptVendor = $exceptVendor;
        $this->onlyVendor = $onlyVendor;
        $this->exceptPath = $exceptPath;
    }

    public function getMethodRoutes($allRoutes): array
    {
        return collect($allRoutes)->map(function ($route) {
            return $this->getRouteInformation($route);
        })->filter()->all();
    }

    protected function getRouteInformation(Route $route): ?array
    {
        return $this->filterRoute([
            'domain' => $route->domain(),
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => ltrim($route->getActionName(), '\\'),
            'vendor' => $this->isVendorRoute($route),
        ]);
    }

    /**
     * Filter the route by URI and / or name.
     *
     * @return array|null
     */
    protected function filterRoute(array $route)
    {
        if (($this->name && ! Str::contains((string) $route['name'], $this->name)) ||
            ($this->path && ! Str::contains($route['uri'], $this->path)) ||
            ($this->method && ! Str::contains($route['method'], strtoupper($this->method))) ||
            ($this->domain && ! Str::contains((string) $route['domain'], $this->domain)) ||
            ($this->exceptVendor && $route['vendor']) ||
            ($this->onlyVendor && ! $route['vendor'])) {
            return;
        }

        if ($this->exceptPath) {
            foreach (explode(',', $this->exceptPath) as $path) {
                if (str_contains($route['uri'], $path)) {
                    return;
                }
            }
        }

        return $route;
    }

    protected function isVendorRoute(Route $route): bool
    {
        if ($route->action['uses'] instanceof \Closure) {

            $path = (new \ReflectionFunction($route->action['uses']))->getFileName();

        } elseif (is_string($route->action['uses']) && str_contains($route->action['uses'], 'SerializableClosure')) {

            return false;

        } elseif (is_string($route->action['uses'])) {

            if ($this->isFrameworkController($route)) {
                return false;
            }

            $path = (new \ReflectionClass($route->getControllerClass()))->getFileName();

        } else {

            return false;

        }

        return str_starts_with($path, base_path('vendor'));
    }

    protected function isFrameworkController(Route $route): bool
    {
        return in_array($route->getControllerClass(), [
            '\Illuminate\Routing\RedirectController',
            '\Illuminate\Routing\ViewController',
        ], true);
    }
}
