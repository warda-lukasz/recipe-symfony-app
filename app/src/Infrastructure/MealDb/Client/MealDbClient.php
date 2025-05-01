<?php

declare(strict_types=1);

namespace App\Infrastructure\MealDb\Client;

use App\Exception\MealDbApiErrorException;
use App\Infrastructure\MealDb\Query\MealDbQueryInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MealDbClient implements MealDbClientInterface
{
    private const string BASE_URL = 'https://www.themealdb.com';
    private const string BASE_API_URL = self::BASE_URL . '/api/json/v1/1/';

    public function __construct(private HttpClientInterface $client) {}

    public static function getIngrendientImageUrl(string $ingredientName): string
    {
        $thumbnailName = str_replace(' ', '_', strtolower($ingredientName));

        return self::BASE_URL . "/images/ingredients/{$thumbnailName}-medium.png";
    }

    public function execute(MealDbQueryInterface $query): array
    {
        $response = $this->client->request('GET', self::BASE_API_URL . $query->getEndpoint());
        $responseData = $this->getData($response);

        return $query->parseResponse($responseData);
    }

    private function getData(ResponseInterface $response): array
    {

        if ($response->getStatusCode() !== 200) {
            throw new MealDbApiErrorException('Error fetching data from MealDB API');
        }

        return $response->toArray();
    }
}
