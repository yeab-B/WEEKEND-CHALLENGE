<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    @php
                        $columns = [
                            'id' => 'No',
                            'name' => 'Name',
                            'created_at' => 'Added Date',
                            'updated_at' => 'Last Update',
                        ];
                    @endphp
                    @foreach ($columns as $column => $label)
                        <th>
                            <a href="{{ route('permissions.index', array_merge(request()->query(), ['sort' => $column, 'direction' => request('direction') == 'asc' && request('sort') == $column ? 'desc' : 'asc'])) }}"
                               class="text-decoration-none text-dark">
                                {{ $label }}
                                @if (request('sort') == $column)
                                    <i class="mdi mdi-sort-{{ request('direction') == 'asc' ? 'ascending' : 'descending' }}"></i>
                                @else
                                    <i class="mdi mdi-sort"></i>
                                @endif
                            </a>
                        </th>
                    @endforeach
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $key => $permission)
                    <tr>
                        <td class="text-muted">{{ ($permissions->currentPage() - 1) * $permissions->perPage() + $key + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        {{ strtoupper(substr($permission->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div>{{ $permission->name }}</div>
                            </div>
                        </td>
                        <td>
                            <small class="text-muted">{{ $permission->created_at->format('Y-m-d H:i:s') }}</small><br>
                            <small class="text-muted">{{ $permission->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <small class="text-muted">{{ $permission->updated_at->format('Y-m-d H:i:s') }}</small><br>
                            <small class="text-muted">{{ $permission->updated_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button"
                                        class="btn btn-sm btn-outline-info permission-edit-btn"
                                        data-id="{{ $permission->id }}"
                                        data-bs-toggle="tooltip"
                                        title="Edit">
                                    <i class="mdi mdi-pencil-outline"></i> Edit
                                </button>

                                <form action="{{ route('permissions.destroy', $permission->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-sm btn-outline-danger permission-delete-btn"
                                            data-bs-toggle="tooltip"
                                            title="Delete">
                                        <i class="mdi mdi-delete-outline"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $permissions->links('pagination::bootstrap-5') }}
    </div>
</div>
