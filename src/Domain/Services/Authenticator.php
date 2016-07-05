<?php

namespace Gogordos\Domain\Services;


use Gogordos\Domain\Entities\User;
use Lcobucci\JWT\Builder;
use Ramsey\Uuid\Uuid;

class Authenticator
{
    const ISSUER = 'http://gogordos.com';
    const AUDIENCE = 'http://gogordos.com';
    const DAYS_THE_TOKEN_CAN_BE_USED = 60;
    const EXPIRES_AFTER_THESE_DAYS = 3600;

    /** @var Builder */
    private $builder;

    /**
     * CreateJWT constructor.
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param User $user
     * @return string
     */
    public function createJWTForUser(User $user)
    {
        $jwtIdJson = $this->buildJwtId($user);

        $token = $this->builder
            ->setIssuer(self::ISSUER)// Configures the issuer (iss claim)
            ->setAudience(self::AUDIENCE)// Configures the audience (aud claim)
            ->setId($jwtIdJson, true)// Configures the id (jti claim), replicating as a header item
            ->setIssuedAt(time())// Configures the time that the token was issue (iat claim)
            ->setNotBefore(time() + self::DAYS_THE_TOKEN_CAN_BE_USED)// Configures the time that the token can be used (nbf claim)
            ->setExpiration(time() + self::EXPIRES_AFTER_THESE_DAYS)// Configures the expiration time of the token (nbf claim)
            //->set('uid', $user->id()->value()) // Configures a new claim, called "uid"
            ->getToken(); // Retrieves the generated token

        $token->getHeaders(); // Retrieves the token headers
        $token->getClaims(); // Retrieves the token claims

        return (string)$token;
    }

    /**
     * JWT id or jti claim:
     * Unique identifier for the token. This value must be unique for each issued token, even if there are
     * many issuers. The jti claim can be used for one-time tokens, which cannot be replayed.
     * @param User $user
     * @return string
     */
    private function buildJwtId(User $user)
    {
        $jtiClaim = [
            'id' => $user->id()->value(),
            'is_admin' => 'false'
        ];
        $jwtIdJson = json_encode($jtiClaim);
        return $jwtIdJson;
    }

}
