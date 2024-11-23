<?php

namespace Framework\Console;

/**
 * ルートを登録し、指定されたルート文字列に基づいて対応するコントローラとメソッドを解決します。
 */
class Router
{
    protected array $routes = [];

    public function register(string $uri, array|\Closure $action): void
    {
        $this->routes[] = ['uri' => $uri, 'action' => $action];
    }

    public function resolve(string $uri): ?array
    {
        foreach ($this->routes as $route) {
            // パラメータを考慮したパターンマッチング
            $pattern = "@^" . preg_replace('/\{[^\/]+\}/', '([^/]+)', $route['uri']) . "$@";
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // $matches[0] は完全マッチなので除外
                return ['action' => $route['action'], 'params' => $matches];
            }
        }
        return null;
    }
}