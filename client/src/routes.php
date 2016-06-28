<?php
// Routes

$app->get('/', function ($request, $response, $args) {

    // Render index view
    return $this->renderer->render($response, 'index.phtml', [
        'settings' => $this->settings,
    ]);
});

$app->get('/client_credentials', function ($request, $response, $args) {

    // send http request to get token
    // curl -v "http://sso.jt.martyndev/oauth/token" -d "grant_type=client_credentials&client_id=japantravel&client_secret=qwertyuiop1234567890"

    // Render index view
    return $this->renderer->render($response, 'client_credentials.phtml', [
        'settings' => $this->settings,
    ]);
});
