<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filma extends Model
{
    use HasFactory;
	public function up()
 {
 Schema::create('filmas', function (Blueprint $table) {
 $table->id();
 $table->foreignId('author_id');
 $table->string('name', 256);
 $table->text('description')->nullable();
 $table->decimal('stars', 8, 2)->nullable();
 $table->integer('year');
 $table->timestamp('created_at')->useCurrent();
 $table->timestamp('updated_at')->useCurrent();
 });
 }
}
