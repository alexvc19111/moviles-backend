<?php
namespace App\Http\Controllers;
use App\Services\AlumnoDashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected AlumnoDashboardService $service
    ) {}

    public function index(Request $request)
    {
        $alumnoId = $request->user()->alumno->id;
        return response()->json(
            $this->service->getDashboard($alumnoId)
        );
    }
}
