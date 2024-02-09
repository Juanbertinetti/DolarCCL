<?php

namespace App\Http\Controllers;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\BigQuery\Dataset;
use Google\Cloud\BigQuery\Table;
use Google\Cloud\BigQuery\QueryResults;
use Throwable;
class BigQueryController extends Controller
{
    private string $credentialPath;
    private string $projectId;
    private BigQueryClient $client;
    private Dataset $dataset;
    private Table $table;
    private string $datasetName;
    private string $tableName;

    public function __construct(string $credentialPath, string $projectId, string $dataset, string $table)
    {
        $this->credentialPath = $credentialPath;
        $this->projectId = $projectId;
        $this->client = new BigQueryClient([
            'proyectId' => $projectId,
            'keyFilePath' => $credentialPath,
        ]);
        $this->dataset = $this->client->dataset($dataset);
        $this->table = $this->dataset->table($table);
        $this->datasetName = $dataset;
        $this->tableName = $table;
    }
    public function obtenerRegistrosTable() : QueryResults
    {
        $query = $this->client->query(
            'SELECT * FROM `' . $this->datasetName . '.' . $this->tableName . '` ORDER BY fecha_act DESC LIMIT 100'
        );

        return $this->client->runQuery($query);
    }

    public function insertarFilaTable($array) : array
    {
        try {
            $response = $this->table->insertRows($array);
            return [
                'success' => true,
                'data' => $response,
            ];
        } catch (Throwable $th) {
            return [
                'success' => false,
                'data' => $th->getMessage(),
            ];
        }
    }
}
