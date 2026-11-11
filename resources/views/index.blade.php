@extends('layouts/app')

@section('pagetitle', "All Books")

@section('content')


<div class="">

    <form method="get" action="{{ route('books.index') }}" class="flex mb-5 gap-2">
        <input type="text" name="title" placeholder="Search by title" value="{{ request('title') }}" class="input" />

        <input type="hidden" name="filter" value="{{ request('filter') }}"/>
        <button class="btn">Search</button>
        <a href="{{ route('books.index') }}" class="btn">Clear</a>
    </form>

    <div class="filter-container">
        @php
            $filters = [
                '' => 'Latest',
                'popular_last_month' => 'Popular Last Month',
                'popular_last_6months' => 'Popular Last 6 Months',
                'highest_rated_last_month' => 'Highest Rated Last Month',
                'highest_rated_last_6months' => 'Highest Rated Last 6 Months'
            ];
        @endphp


        @foreach ($filters as $key => $label)
        <a href="{{ route('books.index', [...request()->query(), 'filter' => $key])  }}"
            class="{{ request('filter') === $key || request('filter') === null && $key === '' ? 'filter-item-active' : 'filter-item' }}">{{ $label }}</a>
        @endforeach



    </div>

    <ul>
    @foreach ( $books as $book)
        <li class="mb-4">
            <div class="book-item">
                <div
                class="flex flex-wrap items-center justify-between">
                <div class="w-full flex-grow sm:w-auto">
                    <a href="{{ route('books.show', ['book' => $book->id]) }}" class="book-title">{{ $book->title }}</a>
                    <span class="book-author">by {{ $book->author }}</span>
                </div>
                <div>
                    <div class="book-rating">
                    <x-star-rating :rating="$book->reviews_avg_ratings" />
                    </div>
                    <div class="book-review-count">
                    out of {{ $book->reviews_count .' '. Str::plural('review', $book->reviews_count) }}
                    </div>
                </div>
                </div>
            </div>
        </li>
    @endforeach

    @empty(!$books)
     {{$books->appends(request()->query())->links();}}
    @endempty

    @empty($books)
        <li class="mb-4">
            <div class="empty-book-item">
                <p class="empty-text">No books found</p>
                <a href="#" class="reset-link">Reset criteria</a>
            </div>
        </li>
    @endempty


    </ul>

</div>

@endsection
