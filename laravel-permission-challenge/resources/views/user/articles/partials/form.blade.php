<div class="modal-header">
    <h5 class="modal-title" id="{{ isset($article) ? 'articleEditModalLabel' : 'articleCreateModalLabel' }}">
        {{ isset($article) ? 'Edit Article' : 'Create New Article' }}
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="{{ isset($article) ? 'editForm' : 'createForm' }}"
      method="POST"
      action="{{ isset($article) ? route('articles.update', $article->id) : route('articles.store') }}">
    @csrf
    @if(isset($article))
        @method('PUT')
    @endif
    <div class="modal-body">
        <div class="mb-3">
            <label for="title" class="form-label">Article Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $article->title ?? '' }}" required>
            <div class="text-danger mt-1" id="title-error"></div> {{-- For AJAX validation errors --}}
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Article Content</label>
            <textarea class="form-control" id="content" name="content" rows="8" required>{{ $article->content ?? '' }}</textarea>
            <div class="text-danger mt-1" id="content-error"></div> {{-- For AJAX validation errors --}}
        </div>

        {{-- If you want to allow changing the author (user) during edit/create by admin,
             you would add a select2 here, populated by the initEmployeeSelect2.
             Make sure to pass $users if you need it.
        --}}
        {{--
        <div class="mb-3">
            <label for="user_id" class="form-label">Author</label>
            <select class="form-control select2-ajax" name="user_id" id="user_id" style="width: 100%;">
                @if(isset($article) && $article->user)
                    <option value="{{ $article->user->id }}" selected>{{ $article->user->name }}</option>
                @endif
            </select>
            <div class="text-danger mt-1" id="user_id-error"></div>
        </div>
        --}}

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" data-loading-text="{{ isset($article) ? 'Updating...' : 'Creating...' }}">
            {{ isset($article) ? 'Update Article' : 'Save Article' }}
        </button>
    </div>
</form>