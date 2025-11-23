<?php

namespace App\Filament\Resources\FinancialRecordResource\Pages;

use App\Filament\Resources\FinancialRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFinancialRecords extends ManageRecords
{
    protected static string $resource = FinancialRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
