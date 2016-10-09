<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Laralum;
use Auth;
use Charts;
use App\Printer;
use App\Warning;
use App\Order;
use App\Queue;

/**
 * AdministrationController
 *
 * Created for: HackUPC fall 2016
 */
class AdministrationController extends Controller
{

    public $colors;
    public $states;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->colors = ['#757575', '#4caf50', '#3949ab', '#009688', '#f44336', '#ffc107'];
        $this->states = ['OFF', 'Ready', 'Printing', 'Ended', 'Error', 'Maintenance'];
    }

    /**
     * Main administration function
     */
    public function index()
    {
        if (!Auth::user()->hasPermission('administration.access')) {
            abort(403, 'Not authoritzed');
        }

        return view('administration/index', [
            'colors' => $this->colors,
            'states' => $this->states,
        ]);
    }

    /**
     * Main printer information
     *
     * @param int $id
     */
    public function printer($id)
    {
        if (!Auth::user()->hasPermission('administration.access')) {
            abort(403, 'Not authoritzed');
        }

        $printer = Printer::findOrFail($id);

        $percentage = Charts::realtime(route('nAPI::printer', ['id' => $printer->id, 'api' => '1029384756']),1500,'gauge', 'justgage')
                            ->setValues([$printer->progress, 0, 100])
                            ->setResponsive(false)
                            ->setHeight(223)
                            ->setTitle('')
                            ->setElementLabel('%')
                            ->setValueName('progress')
                            ->setWidth(0);
        $bed_temp = Charts::realtime(route('nAPI::printer', ['id' => $printer->id, 'api' => '1029384756']), 1500,'gauge', 'canvas-gauges')
                            ->setValues([$printer->bed_temp, 0, 100])
                            ->setResponsive(false)
                            ->setHeight(225)
                            ->setTitle('')
                            ->setValueName('bed_temp')
                            ->setElementLabel('ºC')
                            ->setGaugeStyle('center')
                            ->setWidth(0);
        $tool0_temp = Charts::realtime(route('nAPI::printer', ['id' => $printer->id, 'api' => '1029384756']), 1500,'gauge', 'canvas-gauges')
                            ->setValues([$printer->tool0_temp, 0, 430])
                            ->setResponsive(false)
                            ->setHeight(225)
                            ->setTitle('')
                            ->setValueName('tool0_temp')
                            ->setElementLabel('ºC')
                            ->setGaugeStyle('center')
                            ->setWidth(0);
        $warnings = Charts::database($printer->warnings, 'line', 'morris')
                            ->setResponsive(false)
                            ->setWidth(0)
                            ->setHeight(225)
                            ->setElementLabel('Total Warnings')
                            ->setTitle('')
                            ->lastByDay(5);
        $queue = Queue::whereStateAndPrinter_id(2, $printer->id)->orderBy('id', 'desc')->first();
        $order = $queue ? $queue->order : null;
        return view('administration/printer', [
            'order' => $order,
            'warnings' => $warnings,
            'percentage' => $percentage,
            'tool0_temp' => $tool0_temp,
            'bed_temp' => $bed_temp,
            'colors' => $this->colors,
            'states' => $this->states,
            'printer' => $printer
        ]);
    }

    public function addWarning($id, Request $request)
    {
        if (!Auth::user()->hasPermission('administration.access')) {
            abort(403, 'Not authoritzed');
        }

        $printer = Printer::findOrFail($id);

        if (!$request->input('value')) {
            $printer->consecutive_errors = $printer->consecutive_errors + 1;

            $warning = new Warning;
            $warning->printer_id = $printer->id;
            $warning->wtype_id = $request->input('wtype');
            $warning->save();

            if ($printer->consecutive_errors >= 3) {
                $printer->state = 5;
            } else {
                $printer->elapsed_time = 0;
                $printer->state = 4;
            }
        } else {
            $printer->elapsed_time = 0;
            $printer->state = 1;
        }

        $printer->save();

        return redirect()->route('printer_info', ['id' => $id])->with('msg', "The warning has been added");
    }

    public function enablePrinter($id)
    {
        if (!Auth::user()->hasPermission('administration.access')) {
            abort(403, 'Not authoritzed');
        }

        $printer = Printer::findOrFail($id);
        $printer->state = 1;
        $printer->save();

        return redirect()->route('printer_info', ['id' => $id])->with('msg', "The status has been changed");
    }

    public function disablePrinter($id)
    {
        if (!Auth::user()->hasPermission('administration.access')) {
            abort(403, 'Not authoritzed');
        }

        $printer = Printer::findOrFail($id);
        $printer->state = 4;
        $printer->save();

        return redirect()->route('printer_info', ['id' => $id])->with('msg', "The status has been changed");
    }
}
