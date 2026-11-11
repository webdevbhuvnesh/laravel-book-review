@extends('layouts.app')

@section('content')
  <div class="mb-4">
    <h1 class="sticky top-0 mb-2 text-2xl">{{ $book->title }}</h1>

    <div class="book-info">
      <div class="book-author mb-4 text-lg font-semibold">by {{ $book->author }}</div>
      <div class="book-rating flex items-center">
        <div class="mr-2 text-sm font-medium text-slate-700">
          <x-star-rating :rating="$book->reviews_avg_ratings" />
        </div>
        <span class="book-review-count text-sm text-gray-500">
          {{ $book->reviews_count }} {{ Str::plural('review', 5) }}
        </span>
      </div>
    </div>
  </div>

  <a href="{{ route('books.index') }}" class="reset-link mr-3">Back to Books List</a>

  <a href="{{ route('books.reviews.create', $book) }}" class="reset-link">Add a Review!</a>

  <div class="mt-4">
    <h2 class="mb-4 text-xl font-semibold">Reviews</h2>
    <ul>
      @forelse ($book->reviews as $review)
        <li class="book-item mb-4">
          <div>
            <div class="mb-2 flex items-center justify-between">
              <div class="font-semibold"><x-star-rating :rating="$review->ratings" /></div>
              <div class="book-review-count">
                {{ $review->created_at->format('M j, Y') }}</div>
            </div>
            <p class="text-gray-700">{{ $review->reviews }}</p>
          </div>
        </li>
      @empty
        <li class="mb-4">
          <div class="empty-book-item">
            <p class="empty-text text-lg font-semibold">No reviews yet</p>
          </div>
        </li>
      @endforelse
    </ul>
  </div>
@endsection
