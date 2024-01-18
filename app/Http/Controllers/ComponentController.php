<?php

namespace App\Http\Controllers;

use App\Actions\FetchComponentCode;
use App\Actions\MakeComponentTitle;
use Illuminate\View\View;

class ComponentController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function __invoke(string $componentName): View
    {
        return view('table', [
            'title' => MakeComponentTitle::handle($componentName),
            'component' => $componentName.'-table',
            'source_code' => FetchComponentCode::handle($componentName),
        ]);
    }
}
