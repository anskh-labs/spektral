<?php

declare(strict_types=1);

use Faster\Db\Database;
use Faster\Component\Escaper\Escaper;
use Faster\Helper\Url;
use Faster\Helper\Config;
use Faster\Helper\Container;
use Faster\Helper\Db;
use Faster\Helper\Router;
use Faster\Helper\Service;
use Faster\Helper\View;
use Faster\Html\Form;
use Faster\Http\Auth\UserPrincipalInterface;
use Faster\Http\Session\SessionInterface;
use Faster\Model\FormModel;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Set of function helper 
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 */

if (!function_exists('config')) {
    /**
     * config
     *
     * @param  mixed $offset
     * @param  mixed $defaultValue
     * @return mixed
     */
    function config(mixed $offset, mixed $defaultValue = null): mixed
    {
        return Config::get($offset, $defaultValue);
    }
}

if (!function_exists('make')) {
    /**
     * make
     *
     * @param  string $id
     * @param  array|null $params
     * @param  bool $shared
     * @return mixed
     */
    function make(string $id, array|null $params = null, bool $shared = false): mixed
    {
        return Container::get($id, $params, $shared);
    }
}
if (!function_exists('site_url')) {
    /**
     * site_url
     *
     * @param  string $path
     * @return string
     */
    function site_url(string $path = ''): string
    {
        return Url::getSiteUrl($path);
    }
}
if (!function_exists('base_url')) {
    /**
     * base_url
     *
     * @param  string $path
     * @return string
     */
    function base_url(string $path = ''): string
    {
        return Url::getHostUrl($path);
    }
}
if (!function_exists('base_path')) {
    /**
     * base_path
     *
     * @param  string $path
     * @return string
     */
    function base_path(string $path = ''): string
    {
        return Url::getBasePath($path);
    }
}
if (!function_exists('current_url')) {
    /**
     * current_url
     *
     * @return string
     */
    function current_url(): string
    {
        return Url::getCurrentUrl();
    }
}
if (!function_exists('current_path')) {
    /**
     * current_path
     *
     * @param  string $query
     * @return string
     */
    function current_path(string $query = ''): string
    {
        return Url::getCurrentPath($query);
    }
}
if (!function_exists('route')) {
    /**
     * route
     *
     * @param  string $name
     * @param  string $param
     * @return string
     */
    function route(string $name, string $param = ''): string
    {
        if (Router::exists($name)) {
            $route = Router::get($name);
            $url = $route[1];
            if ($pos = strpos($url, '[')) {
                $url = substr($url, 0, $pos);
            }
            if ($pos = strpos($url, '{')) {
                $url = substr($url, 0, $pos);
            }

            return Url::getBasePath($url . $param);
        } else {
            throw new \Exception("Route '$name' is not exist.");
        }
    }
}
if (!function_exists('is_route')) {
    /**
     * is_route
     *
     * @param  array|string $name
     * @return bool
     */
    function is_route(array|string $name): bool
    {
        $routes = is_string($name) ? [$name] : $name;
        $currentRoute = Service::routeName();
        if(!$currentRoute){
            $currentRoute = Router::getName();
        }

        return in_array($currentRoute, $routes);
    }
}

if (!function_exists('attr_to_string')) {
    /**
     * attr_to_string
     *
     * @param  array|string $attributes
     * @return string
     */
    function attr_to_string($attributes): string
    {
        if (empty($attributes)) {
            return '';
        }
        if (is_array($attributes)) {
            $atts = '';
            foreach ($attributes as $key => $val) {

                if (is_object($val)) {
                    $val = (array) $val;
                }
                if (is_array($val)) {
                    $val = trim(attr_to_string($val));
                }
                if (is_numeric($key)) {
                    $key = '';
                } else {
                    $key .= '=';
                    $val = "\"$val\"";
                }
                $atts = empty($atts) ? ' ' . $key . $val : $atts . ' ' . $key  . $val;
            }

            return $atts;
        }

        if (is_string($attributes)) {
            return ' ' . $attributes;
        }

        return '';
    }
}
if (!function_exists('session')) {
    /**
     * session
     *
     * @param  string $sessionAttribute
     * @return SessionInterface
     */
    function session(string $sessionAttribute = '__session'): SessionInterface
    {
        return Service::session($sessionAttribute);
    }
}
if (!function_exists('db')) {
    /**
     * db
     *
     * @param  string|null $connection
     * @return Database
     */
    function db(string|null $connection = null): Database
    {
        $connection = $connection ?? Db::defaultConnection();
        return Db::get($connection);
    }
}
if (!function_exists('auth')) {
    /**
     * auth
     *
     * @param  string $userAttribute
     * @return UserPrincipalInterface
     */
    function auth(string $userAttribute = '__user'): UserPrincipalInterface
    {
        return Service::user($userAttribute);
    }
}
if (!function_exists('esc')) {

    /**
     * esc
     *
     * @param  array|string $data
     * @param  string $context
     * @param  string|null $encoding
     * @return array|string
     */
    function esc($data, string $context = 'html', string|null $encoding = null): array|string
    {
        $encoding = $encoding ?? 'utf-8';
        if (is_array($data)) {
            foreach ($data as &$value) {
                $value = esc($value, $context);
            }
        }

        if (is_string($data)) {
            $context = strtolower($context);

            // Provide a way to NOT escape data since
            // this could be called automatically by
            // the View library.
            if ($context === 'raw') {
                return $data;
            }

            if (!in_array($context, ['html', 'js', 'css', 'url', 'attr'], true)) {
                throw new InvalidArgumentException('Invalid escape context provided.');
            }

            $method = $context === 'attr' ? 'escapeHtmlAttr' : 'escape' . ucfirst($context);

            static $escaper;
            if (!$escaper) {
                $escaper = new Escaper($encoding);
            }

            if ($encoding && $escaper->getEncoding() !== $encoding) {
                $escaper = new Escaper($encoding);
            }

            $data = $escaper->{$method}($data);
        }

        return $data;
    }
}
if (!function_exists('render')) {
    /**
     * render
     *
     * @param  string $view
     * @param  array $params
     * @param  ResponseInterface|null $response
     * @return ResponseInterface
     */
    function render(string $view, array $params, ResponseInterface|null $response = null): ResponseInterface
    {
        $response = $response ?? make(Response::class, null, true);
        $response->getBody()->write(View::renderer()->render($view, $params));

        return $response;
    }
}
if (!function_exists('render_json')) {
    /**
     * render_json
     *
     * @param  mixed $data
     * @return ResponseInterface
     */
    function render_json($data): ResponseInterface
    {
        return make(JsonResponse::class, [$data]);
    }
}
if (!function_exists('redirect_to')) {
    /**
     * redirect_to
     *
     * @param  mixed $name
     * @param  mixed $param
     * @return ResponseInterface
     */
    function redirect_to(string $name, string $param = ''): ResponseInterface
    {
        return redirect_uri(route($name, $param));
    }
}
if (!function_exists('redirect_uri')) {
    /**
     * redirect_uri
     *
     * @param  mixed $uri
     * @return ResponseInterface
     */
    function redirect_uri(string $uri, int $status = 302): ResponseInterface
    {
        //$headers['location'] = [(string) $uri];
        //return make(Response::class, [$status, $headers]);
        return make(RedirectResponse::class, [$uri, $status]);
    }
}
if (!function_exists('form')) {

    /**
     * create_form
     *
     * @param  FormModel $model
     * @return Form
     */
    function form(FormModel $model): Form
    {
        return new Form($model);
    }
}
if (!function_exists('local_time')) {
    /**
     * local_time
     *
     * @param  int|null $time
     * @param  string $timezone
     * @return int
     */
    function local_time(int|null $time = null, string $timezone = "Asia/Jakarta"): int
    {
        static $timeOffset = null;
        if (!$timeOffset) {
            $dateTimeZone = new DateTimeZone($timezone);
            $dateTime = new DateTime("now", $dateTimeZone);
            $timeOffset = $dateTimeZone->getOffset($dateTime);
        }
        $time = $time ?? time();

        return $time + $timeOffset;
    }
}
if (!function_exists('array_encode')) {
    /**
     * array_encode
     *
     * @param  array $data
     * @return string
     */
    function array_encode(array $data): string
    {
        return base64_encode(serialize($data));
    }
}
if (!function_exists('array_decode')) {
    /**
     * array_decode
     *
     * @param  string $data
     * @return array
     */
    function array_decode(string $data): array
    {
        $decode = unserialize(base64_decode($data));
        if (is_array($decode)) {
            return $decode;
        } else {
            return [];
        }
    }
}
