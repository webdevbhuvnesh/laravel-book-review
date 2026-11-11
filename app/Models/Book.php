<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author'];

    //define one to many relationship b/w book to reviews
    public function reviews(){
        return $this->hasMany(Review::class);
    }

    //local scope query
    public function scopeTitle(Builder $query, string $title) : Builder{
        return $query->where('title', 'LIKE', '%'.$title.'%');
    }

    //popular books
    public function scopePopular(Builder $query, $fromDate = null, $toDate = null) : Builder | QueryBuilder{
        return $query->withCount([
            'reviews' => fn($q) => $this->dateTimeRangeFilter($q, $fromDate, $toDate)
        ])->orderBy('reviews_count', 'desc');
    }


    public function scopetotalReviews(Builder $query) : Builder{
        return $query->withCount('reviews');
    }

    public function scopeAverageRating(Builder $query) : Builder{
        return $query->withAvg('reviews', 'ratings');
    }

    //highest rated books
    public function scopeHighestRated(Builder $query, $fromDate = null, $toDate = null) : Builder{
        return $query->withAvg([
            'reviews' => fn($q) => $this->dateTimeRangeFilter($q, $fromDate, $toDate)
        ], 'ratings' )->orderBy('reviews_avg_ratings', 'desc');
    }

    public function scopeMinimumReviews(Builder $query, $minReviews){
        return $query->having('reviews_count', '>=', $minReviews);
    }

    //datetime range filter
    protected function dateTimeRangeFilter(Builder $query, $fromDate, $toDate){
        if($fromDate && !$toDate){
            $query->where('created_at', '>=', $fromDate);
        }elseif(!$fromDate && $toDate){
            $query->where('created_at', '<=', $toDate);
        }elseif($fromDate && $toDate){
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
    }


    public function scopePopularLastMonth(Builder $query) : Builder | QueryBuilder {
        return $query->popular(now()->subMonth(), now())->AverageRating() ;
    }


    public function scopePopularLast6Months(Builder $query) : Builder {
        return $query->popular( now()->subMonths(6), now() )->AverageRating()  ;
    }

    public function scopeHighestRatedLastMonth(Builder $query) : Builder {
        return $query->highestRated( now()->subMonth(), now() )->totalReviews() ;
    }

    public function scopeHighestRatedLast6Months(Builder $query) : Builder {
        return $query->highestRated( now()->subMonths(6), now() )->totalReviews() ;
    }

}
