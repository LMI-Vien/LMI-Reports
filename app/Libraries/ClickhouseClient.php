<?php
namespace App\Libraries;

use ClickHouseDB\Client;

use ClickHouseDB\Exception\QueryException;

class ClickhouseClient
{
    public $client;

    public function __construct()
    {
        $this->client = new Client([
            'host' => '127.0.0.1',
            'port' => 8123,
            'username' => 'default',
            'password' => 'LMI@123',
            'settings' => [
                'max_execution_time' => 1200,
            ],
            'timeout' => 1200,
            'connect_timeout' => 20,
        ]);

        $this->client->database('sfa_db');

        $this->client->setTimeout(1200);
        $this->client->setConnectTimeOut(20);
        $this->client->settings()->set('max_execution_time', 1200);
    }

    public function query(string $sql, array $bindings = []): array
    {
        try {
            $stmt = $this->client->select($sql, $bindings);
            return $stmt->rows();
        } catch (QueryException $e) {
            log_message('critical', 'ClickHouse QueryException: ' . $e->getMessage());
            throw $e;
        } catch (\Throwable $e) {
            log_message('critical', 'ClickHouse General Exception: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getClient()
    {
        return $this->client;
    }
}
