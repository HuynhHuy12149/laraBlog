@foreach (categories() as $category)
    <li><a href="{{ route('category_posts', $category->slug) }}">{{ Str::ucfirst($category->subcategory_name) }}<span
                class="ml-auto">({{ $category->posts->count() }})</span></a>
    </li>
@endforeach
