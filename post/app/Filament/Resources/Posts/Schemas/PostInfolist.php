<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;

class PostInfolist {
    public static function configure( Schema $schema ): Schema {
        return $schema
        ->components( [
            \Filament\Infolists\Components\TextEntry::make( 'title' )->label( 'Title' ),
            \Filament\Infolists\Components\TextEntry::make( 'description' )->label( 'Description' ),
            \Filament\Infolists\Components\TextEntry::make( 'detail' )->label( 'Detail' ),
            \Filament\Infolists\Components\TextEntry::make( 'created_at' )->label( 'Created At' )->dateTime( 'Y-m-d H:i' ),
            \Filament\Infolists\Components\TextEntry::make( 'updated_at' )->label( 'Updated At' )->dateTime( 'Y-m-d H:i' ),
        ] );
    }
}
