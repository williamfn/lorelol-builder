<?php namespace App\Http\Controllers;

use App\Services\DataFetchService;

class DataFetchController extends Controller
{
    private $dataFetchService;

    public function __construct(DataFetchService $dataFetchService)
    {
        $this->dataFetchService = $dataFetchService;
    }

    public function populateAllChampionsNewVersion($region)
    {
        $this->dataFetchService->populateAllChampionsNewVersion($region);
    }

    public function readSpecialEvents($region)
    {
        $this->dataFetchService->readSpecialEvents($region);
    }
}
