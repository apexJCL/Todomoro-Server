<?php
/**
 * Created by IntelliJ IDEA.
 * User: apex
 * Date: 27/03/17
 * Time: 08:43 AM
 */

namespace common\helpers;


use Firebase\JWT\JWT;
use yii\db\Exception;

class JWTHelper
{

    /**
     * Encodes the given data and returns a JWT
     *
     * @param $data array
     * @return string
     */
    public static function encode($data)
    {
        // TODO move to config file and load from Yii
        $secret = 'test-key';
        $issuedAt = time();
        $notBefore = $issuedAt + 1;
        // Valid for one day
        $expire = $notBefore + (5);
        $issuer = \Yii::$app->request->serverName;

        $payload = [
            'iat' => $issuedAt, // When token was generated
            'iss' => $issuer, // Who created the token
            'nbf' => $notBefore, // Delay for when token begins to be valid
            'exp' => $expire, // When will token expire
            'data' => $data
        ];

        // Generate JWT
        $jwt = JWT::encode(
            $payload,
            $secret,
            'HS512'
        );
        return $jwt;
    }

    /**
     * Generates a JWT Token with the given parameters.
     *
     * If $expire is not set, token will never expire
     *
     * @param $data
     * @param $issuedAt
     * @param $notBefore
     * @param $expire
     * @return string
     */
    public static function generateToken($data, $issuedAt, $notBefore = null, $expire = null)
    {
        $secret = 'test-key';
        $issuer = \Yii::$app->request->serverName;

        $issuedAt = isset($issuedAt) ? $issuedAt : time();
        $notBefore = isset($notBefore) ? $notBefore : $issuedAt + 10;
        $expire = isset($expire) ? $expire : null;

        $payload = [
            'iat' => $issuedAt, // When token was generated
            'iss' => $issuer, // Who created the token
            'nbf' => $notBefore, // Delay for when token begins to be valid
            'exp' => $expire, // When will token expire
            'data' => $data
        ];

        // Generate JWT
        $jwt = JWT::encode(
            $payload,
            $secret,
            'HS512'
        );
        return $jwt;
    }

    /**
     * @param $token
     * @return null|object
     */
    public static function verify($token)
    {
        try {
            $payload = JWT::decode(
                $token,
                'test-key',
                ['HS512']
            );
            return $payload;
        } catch (Exception $e) {
            return null;
        }
    }

}