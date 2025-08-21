<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleResource extends Resource {
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form( Form $form ): Form {
        return $form
        ->schema( [
            Forms\Components\TextInput::make( 'title' )
            ->required()
            ->maxLength( 255 ),
            Forms\Components\Textarea::make( 'content' )
            ->required(),
            Forms\Components\Toggle::make( 'approved' )
            ->label( 'Approved' )
            ->default( false ),

        ] );
    }

    public static function table( Table $table ): Table {
        return $table
        ->columns( [
            Tables\Columns\TextColumn::make( 'id' )->sortable(),
            Tables\Columns\TextColumn::make( 'user.name' )->label( 'User' ),
            Tables\Columns\TextColumn::make( 'title' )->searchable(),
            Tables\Columns\IconColumn::make( 'approved' )->boolean(),
            Tables\Columns\TextColumn::make( 'created_at' )->dateTime(),
            Tables\Columns\TextColumn::make( 'updated_at' )->dateTime(),
            Tables\Columns\TextColumn::make( 'deleted_at' )->dateTime()->nullable( )->label( 'Deleted At' )
        ] )
        ->filters( [
            Tables\Filters\TernaryFilter::make( 'approved' ),

        ] )
        ->actions( [
            Tables\Actions\EditAction::make(),
        ] )
        ->bulkActions( [
            Tables\Actions\BulkActionGroup::make( [
                Tables\Actions\DeleteBulkAction::make(),
            ] ),
        ] );
    }

    public static function getRelations(): array {
        return [
            //
        ];
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListArticles::route( '/' ),
            'create' => Pages\CreateArticle::route( '/create' ),
            'edit' => Pages\EditArticle::route( '/{record}/edit' ),
        ];
    }
   
}
