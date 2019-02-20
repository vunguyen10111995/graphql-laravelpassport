<?php

namespace App\GraphQL\Mutation;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use GraphQL;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Rebing\GraphQL\Support\SelectFields;

class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'LoginMutation',
        'description' => 'A mutation'
    ];

    public function type()
    {
        return Type::listOf(Type::string());
    }

    public function args()
    {
        return [
            'username' => ['name' => 'username', 'type' => Type::nonNull(Type::string())],
            'password' => ['name' => 'password', 'type' => Type::nonNull(Type::string())],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $credentials = [
            'client_id' => env('PASSPORT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_CLIENT_SECRET'),
            'grant_type' => 'password',
            'username' => $args['username'],
            'password' => $args['password']
        ];

        $token = $this->makeRequest($credentials);

        return $token;
    }

    public function makeRequest(array $credentials)
    {
        $request = Request::create('oauth/token', 'POST', $credentials,[], [], [
            'HTTP_Accept' => 'application/json'
        ]);
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);
        if ($response->getStatusCode() != 200) {
            throw new AuthenticationException($decodedResponse['message']);
        }
        return $decodedResponse;
    }
}
