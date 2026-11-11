@extends('layouts.app')

@section('content')

<h1 class="mb-8 text-2xl font-semibold underline underline-offset-8 decoration-blue-700">
    Add review for <span class="text-green-700">{{ $book->title }}</span>
</h1>
<form method="post" action="{{ route('books.reviews.store', $book) }}">

    @csrf
    <label for="review">Review</label>
    <textarea name="review" class="input mb-4" id="review"></textarea>

    <label for="rating">Rating</label>
    <select name="rating" class="input mb-4">
        <option value="">Select Rating</option>
        @for ($i=1; $i<=5; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
        @endfor
    </select>

    <button type="submit" class="btn">Submit</button>

</form>

@endsection
