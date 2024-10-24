<?php

namespace App\Filament\Widgets;

use App\Models\Solar;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class SolarChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Daya (W)';
    protected int | string | array $columnSpan = 2;
    
    protected function getData(): array
    {
        $timezone = 'Asia/Jakarta';

        $data = Trend::model(Solar::class)
                ->between(
                    start: now($timezone)->subHour(),
                    end: now($timezone),
                )
                ->perMinute()
                ->average('power');
 
        return [
            'datasets' => [
                [
                    'label' => 'Daya',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('H:i')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
