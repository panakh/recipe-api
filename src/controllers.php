<?php

use Gousto\Recipe;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->get('/', function () use ($app) {

    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;

$app->post('/recipes', function(Request $request) use ($app) {

    $recipe = Recipe::fromArray(json_decode($request->getContent(), true));
    $app['repository.recipe']->save($recipe);
    return new JsonResponse($request->getContent());
});

$app->get('/recipes/{id}', function(int $id) use($app) {
    $recipe = $app['repository.recipe']->getById($id);
    return new JsonResponse($recipe->getData());
});

$app->patch('/recipes/{id}', function(int $id, Request $request) use($app) {
    $recipe = $app['repository.recipe']->getById($id);

    $content = json_decode($request->getContent(), true);

    if (isset($content['rating'])) {
        $recipe->setRating((int) $content['rating']);
    }

    $app['repository.recipe']->save($recipe);

    return new JsonResponse($recipe->getData());
});

$app->get('/recipes', function(Request $request) use ($app) {
    $data = [];

    if ($request->query->has('cuisine')) {
        $recipes = $app['repository.recipe']->getByCuisine($request->query->get('cuisine'));

        $pageNumber = 1;
        $pageSize = 5;

        if ($request->query->has('page')) {

            $page = $request->query->get('page');
            if (isset($page['number'])) {
                $pageNumber = (int) $page['number'];
            }

            if (isset($page['size'])) {
                $pageSize = (int) $page['size'];
            }
        }

        foreach ($recipes as $recipe) {
            $data[] = $recipe->getData();
        }

        $data = array_slice($data, ($pageNumber - 1) * $pageSize, $pageSize);
    }

    return new JsonResponse($data);
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
