<?php
// Routes

$app->get('/', function ($request, $response, $args) {

    // Render index view
    return $this->renderer->render($response, 'index.phtml', [
        'settings' => $this->settings,
    ]);
});

$app->post('/client_credentials', function ($request, $response, $args) {

    $settings = $this->settings;
    $data = null;
    $error = null;

    try {
        $res = $this->get('http_client')->request('POST', $settings['urls']['token'], [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $settings['client_id'],
                'client_secret' => $settings['client_secret'],
            ],
        ]);
        $data = json_decode((string) $res->getBody(), true);
    } catch(\Exception $e) {
        $res = $e->getResponse();
        $error = $e->getMessage();
    }

    // Render credentials view
    return $this->renderer->render($response, 'client_credentials.phtml', [
        'settings' => $settings,
        'rawBody' => (string) $res->getBody(),
        'data' => $data,
        'error' => $error,
    ]);
});

$app->get('/resource', function ($request, $response, $args) {

    $settings = $this->settings;
    $accessToken = $request->getParam('access_token');
    $data = null;
    $error = null;

    try {
        $res = $this->get('http_client')->request('GET', $settings['urls']['resource'], [
            'query' => [
                'access_token' => $accessToken,
            ],
        ]);
        $data = json_decode((string) $res->getBody(), true);
    } catch(\Exception $e) {
        $res = $e->getResponse();
        $error = $e->getMessage();
    }

    // Render resource view
    return $this->renderer->render($response, 'resource.phtml', [
        'settings' => $settings,
        'rawBody' => htmlspecialchars((string) $res->getBody()),
        'json' => htmlspecialchars(json_encode($data, JSON_PRETTY_PRINT)),
        'error' => $error,
    ]);
});
