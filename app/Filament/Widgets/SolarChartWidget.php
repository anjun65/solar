<?php

namespace App\Filament\Widgets;

use App\Models\Solar;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class SolarChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Arus';
    protected int | string | array $columnSpan = 2;
    
    
    protected function getData(): array
    {
        $data = Trend::model(Solar::class)
                ->between(
                    start: now()->startOfDay(),
                    end: now()->endOfDay(),
                )
                ->perMinute()
                ->average('power');
 
        return [
            'datasets' => [
                [
                    'label' => 'Arus',
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
