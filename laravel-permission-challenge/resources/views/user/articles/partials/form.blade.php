<div class="modal-header">
    <h5 class="modal-title" id="{{ isset($article) ? 'articleEditModalLabel' : 'articleCreateModalLabel' }}">
        {{ isset($article) ? 'Edit Article' : 'Create New Article' }}
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="{{ isset($article) ? 'editForm' : 'createForm' }}" method="POST"
    action="{{ isset($article) ? route('articles.update', $article->id) : route('articles.store') }}">
    @csrf
    @if (isset($article))
        @method('PUT')
    @endif
    <div class="modal-body">
        <div class="mb-3">
            <label for="title" class="form-label">Article Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $article->title ?? '' }}"
                required>
            <div class="text-danger mt-1" id="title-error"></div> {{-- For AJAX validation errors --}}
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Article Content</label>
            <textarea class="form-control" id="content" name="content" rows="8" required>{{ $article->content ?? '' }}</textarea>
            <div class="text-danger mt-1" id="content-error"></div> {{-- For AJAX validation errors --}}
        </div>
           <div class="mb-3">
            <label for="lang_id" class="form-label">Language</label>
            <select class="form-control" id="lang_id" name="lang_id" required>
                <option value="">Select Language</option>
                @foreach ($languages as $language)
                <option value="{{ $language->id }}"
                    {{ (isset($article) && $article->lang_id == $language->id) ? 'selected' : '' }}>
                    {{ $language->name }} ({{ $language->code }})
                </option>
                @endforeach
            </select>
            <div class="text-danger mt-1" id="lang_id-error"></div>
        </div>
        
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"
            data-loading-text="{{ isset($article) ? 'Updating...' : 'Creating...' }}">
            {{ isset($article) ? 'Update Article' : 'Save Article' }}
        </button>
    </div>
</form>
