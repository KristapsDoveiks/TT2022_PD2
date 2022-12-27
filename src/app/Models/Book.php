<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
	
	protected $fillable = ['name', 'author_id', 'description', 'price', 'year'];
	
	public function up()
 {
 Schema::create('books', function (Blueprint $table) {
 $table->id();
 $table->foreignId('author_id');
 $table->string('name', 256);
 $table->text('description')->nullable();
 $table->decimal('price', 8, 2)->nullable();
 $table->integer('year');
 $table->string('image', 256)->nullable();
 $table->boolean('display');
 $table->timestamp('created_at')->useCurrent();
 $table->timestamp('updated_at')->useCurrent();
 });
 }

public function jsonSerialize(): mixed
{
 return [
 'id' => intval($this->id),
 'name' => $this->name,
 'description' => $this->description,
 'author' => $this->author->name,
 'genre' => ($this->genre ? $this->genre->name : ''),
 'price' => number_format($this->price, 2),
 'year' => intval($this->year),
 'image' => asset('images/' . $this->image),
 ];
}


}
