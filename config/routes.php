<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use App\Controller\Component\GestionController;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    // Register scoped middleware for in scopes.
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true
    ]));

    /**
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered via `Application::routes()` with `registerMiddleware()`
     */
    $routes->applyMiddleware('csrf');

    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *
     * ```
     * $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
     * $routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
     * ```
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * Router::scope('/api', function (RouteBuilder $routes) {
 *     // No $routes->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */

Router::scope('/users', function ($routes){
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true
    ]));
    $routes->applyMiddleware('csrf');

    //El uso de usuarios solo está con el objetivo de que pueda postear.
    $routes->connect(GestionController::$ListingMethod . '/', ['controller' => 'Users', 'action' => GestionController::$ListingMethod]);
    $routes->connect(GestionController::$ViewMethod . '/:id', ['controller' => 'Users', 'action' => GestionController::$ViewMethod]);
    $routes->connect(GestionController::$AddMethod . '/', ['controller' => 'Users', 'action' => GestionController::$AddMethod]);
    $routes->connect(GestionController::$EditMethod . '/:id', ['controller' => 'Users', 'action' => GestionController::$EditMethod]);
    $routes->connect(GestionController::$DeleteMethod . '/:id', ['controller' => 'Users', 'action' => GestionController::$DeleteMethod]);
});

Router::scope('/categories', function ($routes){
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true
    ]));
    $routes->applyMiddleware('csrf');

    // Las categorías no deberían poder borrarse ni editarse en un principio, para evitar tener problemas con los comentarios
    $routes->connect(GestionController::$ListingMethod . '/', ['controller' => 'Categories', 'action' => GestionController::$ListingMethod]);
    $routes->connect(GestionController::$ViewMethod . '/:id', ['controller' => 'Categories', 'action' => GestionController::$ViewMethod]);
    $routes->connect(GestionController::$AddMethod .'/', ['controller' => 'Categories', 'action' => GestionController::$AddMethod]);
});

Router::scope('/posts', function ($routes){
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true
    ]));
    $routes->applyMiddleware('csrf');

    $routes->connect(GestionController::$ListingMethod . '/', ['controller' => 'Posts', 'action' => GestionController::$ListingMethod]);
    $routes->connect(GestionController::$AddMethod . '/', ['controller' => 'Posts', 'action' => GestionController::$AddMethod]);
    $routes->connect(GestionController::$EditMethod . '/:id', ['controller' => 'Posts', 'action' => GestionController::$EditMethod]);
    $routes->connect(GestionController::$DeleteMethod . '/:id', ['controller' => 'Posts', 'action' => GestionController::$DeleteMethod]);
    $routes->connect('/yourindex/:userId', ['controller' => 'Posts', 'action' => 'yourindex']);
    $routes->connect('/comments/:id', ['controller' => 'Comments', 'action' => 'index']);
});

Router::scope('/comments', function ($routes){
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true
    ]));
    $routes->applyMiddleware('csrf');

    //La creación de comentarios se gestiona en la misma "view" del post.
    $routes->connect(GestionController::$DeleteMethod . '/:id', ['controller' => 'Comments', 'action' => GestionController::$DeleteMethod]);
});
