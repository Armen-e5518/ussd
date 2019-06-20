<?php

namespace api\components;

use yii\filters\auth\HttpBearerAuth;

class VHttpBearerAuth extends HttpBearerAuth
{

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        /* @var  $request */
        /* @var  $user */
        $authHeader = $request->getHeaders()->get('VAuthorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $identity = $user->loginByAccessToken($matches[1], get_class($this));
            if ($identity === null) {
                $this->handleFailure($response);
            }
            return $identity;
        }

        return null;
    }
}