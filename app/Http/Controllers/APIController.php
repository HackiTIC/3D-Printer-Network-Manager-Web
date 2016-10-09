<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Printer;
use Laralum;

class APIController extends Controller
{
    private static $key = '1029384756';

    public function printer($printer, $key)
    {
        if ($key != self::$key) {
            return ['error' => 'Bad API key'];
        }

        $printer = Printer::findOrFail($printer);
        return [
            'tool0_temp' => $printer->tool0_temp,
            'bed_temp' => $printer->bed_temp,
            'percentage' => $printer->percentage,
            'elapsed_time' => $printer->elapsed_time,
            'estimated_time' => $printer->estimated_time,
            'progress' => $printer->progress,
            'state' => $printer->state,
            'updated_at' => $printer->updated_at,
            'consecutive_errors' => $printer->consecutive_errors,
        ];
    }

    public function file($name, $key)
    {
        if ($key != self::$key) {
            return ['error' => 'Bad API key'];
        }
        return response()->file(storage_path() . '/app/' . $name);
        //return Laralum::downloadFile($name.'.');
    }

    public function register($host, $name, $key)
    {
        if ($key != self::$key) {
            return ['error' => 'Bad API key'];
        }

        if(Printer::where('host', $host)->first()){
            return false;
        }

        $printer = new Printer;
        $printer->host = $host;
        $printer->name = $name;
        $printer->save();

        return true;
    }
}
