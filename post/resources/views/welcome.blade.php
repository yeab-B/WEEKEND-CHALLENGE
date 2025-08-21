<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Admin Posts') }}</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body class="bg-light min-vh-100 d-flex flex-column align-items-center justify-content-center p-4">
    @php
        $posts = \App\Models\Post::all();
    @endphp
    <div class="container py-5">
        <div class="d-flex justify-content-end mb-4">
            <form method="GET" action="" class="d-inline">
                <select name="lang" class="form-select form-select-sm w-auto d-inline" onchange="this.form.submit()">
                    <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                    <option value="am" {{ app()->getLocale() == 'am' ? 'selected' : '' }}>አማርኛ</option>
                </select>
            </form>
        </div>
        <h1 class="display-4 fw-bold mb-5 text-center">{{ __('Admin Posts') }}</h1>
        <div class="row g-4 justify-content-center">
            @forelse($posts as $post)
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h2 class="card-title h5 mb-3">{{ $post->getTranslation('title', app()->getLocale()) }}</h2>
                            <p class="card-text mb-2">{{ $post->getTranslation('description', app()->getLocale()) }}</p>
                            <div class="mb-2 text-muted small">{{ $post->getTranslation('detail', app()->getLocale()) }}</div>
                        </div>
                        <div class="card-footer bg-white border-0 text-end small text-secondary">
                            <span class="me-3">{{ __('Created') }}:
                                {{ $post->created_at->format('Y-m-d H:i') }}</span>
                            <span>{{ __('Updated') }}: {{ $post->updated_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-secondary">{{ __('No posts found.') }}</div>
            @endforelse
        </div>
    </div>
</body>

</html>
