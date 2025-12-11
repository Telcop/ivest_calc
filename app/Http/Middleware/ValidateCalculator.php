<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use League\CommonMark\Extension\CommonMark\Renderer\Block\ThematicBreakRenderer;
use Symfony\Component\HttpFoundation\Response;

class ValidateCalculator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Проверка стоимость пая должна быть положительным числом
        $cost_arr = $request->input('document.list_quotes.*.quotes');
        foreach ($cost_arr as $key => $cost) {
            if ($cost <= 0)
                $errors["document.list_quotes." . $key . ".quotes"] = "The document.list_quotes." . $key . ".quotes field must be greater than 0.";
        }

        // Проверка не должно быть двух одинаковых типов ПИФов в запросе
        $code_arr = array_count_values($request->input('document.list_quotes.*.prod_code'));
        $key = array_flip($request->input('document.list_quotes.*.prod_code'));
        foreach ($code_arr as $code => $val) {
            if ($val > 1) {
                $errors["document.list_quotes.". $key[$code] .".prod_code"] = "The request should not contain entries with the same code '" . $code . "'.";
            }
        }        

        if (!empty($errors)) {
            return response(["message" => $errors[array_key_first($errors)], "errors" => $errors], 422);
        }

        return $next($request);
    }
}
