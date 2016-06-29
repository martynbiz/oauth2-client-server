<?php
// Routes

$app->get('/', function ($request, $response, $args) {

    // Render index view
    return $this->renderer->render($response, 'index.phtml', [
        'settings' => $this->settings,
    ]);
});

$app->get('/authorize', function ($request, $response, $args) {

    $settings = $this->settings;

    // Render credentials view
    return $response->withRedirect($settings['urls']['authorize'] . '?' . http_build_query([

        // Value MUST be set to "code".
        'response_type' => 'code', // required

        // The authorization server issues the registered client a client
        // identifier -- a unique string representing the registration
        // information provided by the client.
        'client_id' => '', // required

        // After completing its interaction with the resource owner, the
        // authorization server directs the resource owner's user-agent back to
        // the client.  The authorization server redirects the user-agent to the
        // client's redirection endpoint previously established with the
        // authorization server during the client registration process or when
        // making the authorization request.
        'redirect_uri' => '', // optional

        // The authorization and token endpoints allow the client to specify the
        // scope of the access request using the "scope" request parameter.  In
        // turn, the authorization server uses the "scope" response parameter to
        // inform the client of the scope of the access token issued.
        'scope' => '', // optional

        // An opaque value used by the client to maintain
        // state between the request and callback.  The authorization
        // server includes this value when redirecting the user-agent back
        // to the client.  The parameter SHOULD be used for preventing
        // cross-site request forgery as described in Section 10.12.
        'state' => 'xyz', // recommended
    ]));
});

$app->post('/client_credentials', function ($request, $response, $args) {

    $settings = $this->settings;
    $data = null;
    $error = null;

    try {

        // Make HTTP Request
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

        // Make HTTP Request
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
