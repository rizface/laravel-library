<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, HasUuids;
   
    private $categoryIds = null;
    protected $table = 'books';
    protected $fillable = [
        'title',
        'qty',
        'author',
        'publisher',
        'isbn',
        'release_date'
    ];

    public static function IsISBNExists($isbn) {
        return self::where("isbn", $isbn)->count() > 0;
    }

    public function categories() {
        return $this->belongsToMany(Category::class, "book_categories", "book_id", "category_id");
    }

    public function IsStillBorrowed() {
        return BookLog::where("book_id", $this->id)->where("is_returned", false)->count() > 0;
    }

    public function NumAvailable() {
        return $this->qty - BookLog::where("book_id", $this->id)->where("is_returned", false)->count();
    }

    public static function IsExists($id) {
        return self::where("id", $id)->count() > 0;
    }

    public function IsBookCategory($id) {
        if ($this->categoryIds == null) {
            $this->categoryIds = BookCategories::where("book_id", $this->id)->pluck("category_id")->toArray();
        }

        return in_array($id, $this->categoryIds);
    }
}
