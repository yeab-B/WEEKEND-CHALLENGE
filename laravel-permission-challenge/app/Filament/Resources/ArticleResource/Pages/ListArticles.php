<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\TrashedFilter;

class ListArticles extends ListRecords
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getTableFilters(): array
    {
        return [
            TrashedFilter::make(),
        ];
    }

    protected function getTableActions(): array
    {
        $actions = parent::getTableActions();

        // Add restore button only when viewing trashed records
        $actions[] = Actions\Action::make('restore')
            ->label('Restore')
            ->icon('heroicon-o-refresh')
            ->action(function ($record) {
                $record->restore();
                $this->notify('success', 'Article restored successfully.');
            })
            ->requiresConfirmation()
            ->color('success')
            ->visible(fn ($record) => $record->trashed()); // show only on trashed records

        return $actions;
    }
}
