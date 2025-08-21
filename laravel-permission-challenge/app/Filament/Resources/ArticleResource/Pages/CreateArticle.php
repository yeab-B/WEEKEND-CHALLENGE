<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use \Illuminate\Support\Facades\Auth;

class CreateArticle extends CreateRecord {
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate( array $data ): array {
        $data[ 'user_id' ] = Auth::user()?->id;
        return $data;
    }
}
