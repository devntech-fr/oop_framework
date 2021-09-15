<?php
namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing;

class FWKernel
{
    private UrlMatcherInterface $matcher;
    private ?Routing\RouteCollection $routeCollection;
    private ?Routing\Route $currentRoute = null;

    public function __construct(UrlMatcherInterface $matcher)
    {
        $this->matcher = $matcher;
        $this->routeCollection = include __DIR__.'/routes.php';
    }

    /**
     * @return mixed|Routing\RouteCollection
     */
    public function getRouteCollection(): ?Routing\RouteCollection
    {
        return $this->routeCollection;
    }

    public function handle(Request $request): Response
    {
        try {
            $routeMatch = $this->matcher->match($request->getPathInfo());
            // returns ['_route_name' => '/route-name']

            // add route match array result to request attributes
            $request->attributes->add($routeMatch);
            // get current route by route collection with match key to access route name
            if (null === $this->currentRoute || $routeMatch['_route'] !== $this->currentRoute) {
                $this->currentRoute = $this->getRouteCollection()->get($routeMatch['_route']);
            }
            // get controller function or callback
            $routeEmbedController = $this->currentRoute->getDefaults()['_controller'];
            include __DIR__."/Controller/controller.php";
            // get response from controller return
            $response = call_user_func($routeEmbedController, $request);
            // check if response is valid
            if (!$response instanceof Response) {
                return new Response("Server response is not instanceof Response", Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return $response;
        } catch (Routing\Exception\ResourceNotFoundException $exception) {
            return new Response(
                'Not Found',
                Response::HTTP_NOT_FOUND
            );
        } catch (\Exception $exception) {
            return new Response("An error occured", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
