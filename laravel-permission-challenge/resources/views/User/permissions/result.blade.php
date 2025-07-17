<div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover table-nowrap align-middle mb-0">
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
                        <th class="text-nowrap">
                            <a href="{{ route('permissions.index', array_merge(request()->query(), ['sort' => $column, 'direction' => request('direction') == 'asc' && request('sort') == $column ? 'desc' : 'asc'])) }}"
                               class="text-dark text-decoration-none">
                                {{ $label }}
                                @if (request('sort') == $column)
                                    <i class="mdi mdi-sort-{{ request('direction') == 'asc' ? 'ascending' : 'descending' }}"></i>
                                @else
                                    <i class="mdi mdi-sort"></i>
                                @endif
                            </a>
                        </th>
                    @endforeach
                    <th class="text-nowrap text-dark">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $key => $permission)
                    <tr>
                        <td class="text-muted">{{ ($permissions->currentPage() - 1) * $permissions->perPage() + $key + 1 }}</td>

                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar-xs">
                                        <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                            {{ substr($permission->name, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ $permission->name }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-muted">{{ $permission->created_at->format('Y-m-d H:i:s') }}</span>
                                <small class="text-muted">{{ $permission->created_at->diffForHumans() }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-muted">{{ $permission->updated_at->format('Y-m-d H:i:s') }}</span>
                                <small class="text-muted">{{ $permission->updated_at->diffForHumans() }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="hstack gap-2">
                                @can('update permission')
                                    <button data-id="{{ $permission->id }}"
                                            class="btn btn-sm btn-soft-info permission-edit-btn"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-title="Edit">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </button>
                                @endcan
                                @can('delete permission')
                                    <form action="{{ route('permissions.destroy', $permission->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-soft-danger permission-delete-btn"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-title="Delete">
                                            <i class="mdi mdi-delete-outline"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $permissions->appends(request()->query())->links('vendor.pagination.default') }}
        </div>
    </div>
</div>
