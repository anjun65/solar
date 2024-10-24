<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Solar;
use Illuminate\Support\Carbon;

class AllChartWidget extends ChartWidget
{
    protected static ?string $heading = 'All';

    protected int | string | array $columnSpan = 2;
    
    protected function getData(): array
    {
        $timezone = 'Asia/Jakarta';

        $data = Trend::model(Solar::class)
                ->between(
                    start: now($timezone)->subHour(),
                    end: now($timezone),
                )
                ->perMinute();

        $dataCurrent = $data->average('current');
        $dataPower = $data->average('power');
        $dataTemperature = $data->average('temperature');
        $dataVoltage = $data->average('voltage');
 
        return [
            'datasets' => [
                [
                    'label' => 'Arus (A)',
                    'data' => $dataCurrent->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgba(75, 192, 192, 0.6)',
                    'fill' => 'rgba(75, 192, 192, 0.6)',
                ],
                [
                    'label' => 'Daya (W)',
                    'data' => $dataPower->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgba(255, 99, 132, 0.6)',
                    'fill' => 'rgba(255, 99, 132, 0.6)',
                ],
                [
                    'label' => 'Suhu (C)',
                    'data' => $dataTemperature->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgba(255, 206, 86, 0.6)',
                    'fill' => 'rgba(255, 206, 86, 0.6)',
                ],
                [
                    'label' => 'Tegangan (V)',
                    'data' => $dataVoltage->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => 'rgba(54, 162, 235, 0.6)',
                    'fill' => 'rgba(54, 162, 235, 0.6)',
                ],
            ],
            'labels' => $dataCurrent->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('H:i')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
