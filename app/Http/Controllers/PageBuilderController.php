<?php namespace App\Http\Controllers;

use App\Services\PageBuilderService;
use App;

class PageBuilderController extends Controller
{
    private $pageBuilderService;

    public function __construct(PageBuilderService $pageBuilderService)
    {
        $this->pageBuilderService = $pageBuilderService;
    }

    public function template($champId, $region)
    {
        App::setLocale($region);
        return $this->pageBuilderService->showTemplate($champId, $region);
    }

    public function createChampionPages($region)
    {
        App::setLocale($region);
        $this->pageBuilderService->createChampionPages($region);
    }

    public function createHomePages($region)
    {
        App::setLocale($region);
        $this->pageBuilderService->createHomePages($region);
    }
}
