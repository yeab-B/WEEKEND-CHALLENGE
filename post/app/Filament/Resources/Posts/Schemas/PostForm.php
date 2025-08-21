<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;

class PostForm {
    public static function configure( Schema $schema ): Schema {
        return $schema
        ->components( [
            \Filament\Forms\Components\TextInput::make( 'title' )
            ->label( 'Title' )
            ->required()
            ->maxLength( 255 ),
            \Filament\Forms\Components\Textarea::make( 'description' )
            ->label( 'Description' )
            ->rows( 3 ),
            \Filament\Forms\Components\Textarea::make( 'detail' )
            ->label( 'Detail' )
            ->rows( 4 ),
        ] );
    }
}
