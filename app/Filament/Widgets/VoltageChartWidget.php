<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Solar;
use Illuminate\Support\Carbon;

class VoltageChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Daya';
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
                ->average('temperature');
 
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