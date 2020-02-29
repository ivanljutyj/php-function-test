<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ubench;

class TestController extends Controller
{
    public function postFunctions(Request $request)
   {
       $functions = $request->get('functions');
       $iterations = $request->get('iterations');

       return $this->runTests($functions, $iterations);
   }

   private function runTests(array $functions, int $iterations): JsonResponse
   {
       $result = [];
       $bench = new Ubench();
       foreach ($functions as $function) {
           ob_start();
           $bench->start();
           for ($i = 0; $i < $iterations; $i++) {
               eval($function['code']);
           }
           $bench->end();
           ob_end_clean();
           $result[] = [
               'time' => $bench->getTime(),
               'memory' => $bench->getMemoryUsage(),
               'memory_peak' => $bench->getMemoryPeak()
           ];
       }

       return response()->json($result);
   }
}
