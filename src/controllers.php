<?php

use Gousto\Recipe;
use Infrastructure\TransformerFactory;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->view(function ($controllerResult, Request $request) use ($app) {

    $acceptHeader = $request->headers->get('Accept', 'application/vnd.mobile+json');
    $priorities   = array('application/vnd.desktop+json', 'application/vnd.mobile+json');
    $mediaType = $app['negotiator']->getBest($acceptHeader, $priorities);
    $bestFormat = $mediaType->getValue();
    $resource = null;

    if (empty($controllerResult)) {
        return $app->json([]);
    }

    if (is_array($controllerResult)) {
        //collection
        $transformer = (new TransformerFactory())->createTransformer($bestFormat, get_class($controllerResult[0]));
        $resource = new Collection($controllerResult, $transformer, 'recipes');
    }

    if (is_object($controllerResult)) {
        //single resource
        $transformer = (new TransformerFactory())->createTransformer($bestFormat, get_class($controllerResult));
        $resource = new Item($controllerResult, $transformer, 'recipes');
    }

    $manager = new Manager();
    $manager->setSerializer(new JsonApiSerializer());

    return $app->json($manager->createData($resource)->toArray());
});

$app->post('/recipes', function(Request $request) use ($app) {

    $recipe = Recipe::fromRepresentation(json_decode($request->getContent(), true));
    $app['repository.recipe']->save($recipe);
    return new JsonResponse($request->getContent());
});

$app->get('/recipes/{id}', function(int $id) use($app) {

    $recipe = $app['repository.recipe']->getById($id);

    return $recipe;
});

$app->patch('/recipes/{id}', function(int $id, Request $request) use($app) {
    $recipe = $app['repository.recipe']->getById($id);

    $content = json_decode($request->getContent(), true);
    $recipe->update($content);
    $app['repository.recipe']->save($recipe);

    return $recipe;
});

$app->get('/recipes', function(Request $request) use ($app) {

    $data = [];
    $recipes = [];

    if ($request->query->has('cuisine')) {
        $recipes = $app['repository.recipe']->getByCuisine($request->query->get('cuisine'));
    }

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
        $data[] = $recipe;
    }

    $data = array_slice($data, ($pageNumber - 1) * $pageSize, $pageSize);

    return $data;
});

$app->error(function (\Exception $e, Request $request, $code) use ($app) {

    if ($app['debug']) {
        return;
    }

    return new JsonResponse([
        'code'=> $code,
        'message' => $e->getMessage()
    ], $code);

});
