<?php

namespace App\Support;

use Illuminate\Database\Schema\Blueprint;

class DbTableHelper
{
    public static function morphUserColumn(Blueprint $table): void
    {
        static::morphColumn($table, 'user');
    }

    public static function morphNullableItemColumn(Blueprint $table): void
    {
        static::morphColumn($table, 'item', true);
    }

    public static function morphImage(Blueprint $table, string $name): void
    {
        $table->unsignedBigInteger("{$name}_id")->default(0);
        $table->string("{$name}_type")->default('photo');
        $table->index("{$name}_id");
        $table->index(["{$name}_id", "{$name}_type"]);

        static::imageColumns($table, "{$name}_path", "{$name}_server_id");
    }

    /**
     * @param Blueprint $table
     * @param string $name
     * @param bool $nullable
     * @param string|null $indexName
     */
    public static function morphColumn(
        Blueprint $table,
        string    $name,
        bool      $nullable = false,
        ?string   $indexName = null
    ): void
    {
        $table->unsignedBigInteger("${name}_id")
            ->nullable($nullable);
        $table->string("${name}_type")
            ->nullable($nullable);
        $table->index("${name}_id");
        $table->index(["${name}_id", "${name}_type"], $indexName);
    }

    public static function imageColumns(
        Blueprint $table,
        string    $imagePathColumn = 'image_path',
        string    $serverIdColumn = 'server_id'
    ): void
    {
        $table->text($imagePathColumn)->nullable();
        $table->unsignedInteger($serverIdColumn)->default(0);
    }
}
