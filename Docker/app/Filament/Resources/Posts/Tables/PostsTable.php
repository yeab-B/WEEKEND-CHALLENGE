<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class PostsTable {
    public static function configure( Table $table ): Table {
        return $table
        ->columns( [
            \Filament\Tables\Columns\TextColumn::make( 'title' )->label( 'Title' )->searchable(),
            \Filament\Tables\Columns\TextColumn::make( 'description' )->label( 'Description' )->limit( 50 ),
            \Filament\Tables\Columns\TextColumn::make( 'detail' )->label( 'Detail' )->limit( 50 ),
            \Filament\Tables\Columns\TextColumn::make( 'created_at' )->label( 'Created At' )->dateTime( 'Y-m-d H:i' ),
            \Filament\Tables\Columns\TextColumn::make( 'updated_at' )->label( 'Updated At' )->dateTime( 'Y-m-d H:i' ),
        ] )
        ->filters( [
            //
        ] )
        ->recordActions( [
            ViewAction::make(),
            EditAction::make(),
        ] )
        ->toolbarActions( [
            BulkActionGroup::make( [
                DeleteBulkAction::make(),
            ] ),
        ] );
    }
}
