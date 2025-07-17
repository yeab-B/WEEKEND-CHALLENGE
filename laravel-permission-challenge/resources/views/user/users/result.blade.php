<div class="card-body">
    <div class="table-responsive">
        <table class="table mt-3">
            <thead>
                <tr>
                    @php
                        $columns = [
                            'id' => 'No',
                            'name' => 'Name',
                            'email' => 'Email',
                            'created_at' => 'Added Date',
                            'updated_at' => 'Last Update'
                        ];
                    @endphp
                    @foreach ($columns as $column => $label)
                        <th>
                            <a href="{{ route('users.index', array_merge(request()->query(), ['sort' => $column, 'direction' => request('direction') == 'asc' && request('sort') == $column ? 'desc' : 'asc'])) }}">
                                {{ $label }}
                                @if (request('sort') == $column)
                                    <i class="fa fa-sort-{{ request('direction') == 'asc' ? 'asc' : 'desc' }}"></i>
                                @endif
                            </a>
                        </th>
                    @endforeach
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ $user->created_at->format('Y-m-d H:i:s') }}
                            <span class="badge rounded-pill bg-primary">{{ $user->created_at->diffForHumans() }}</span>
                        </td>
                        <td>
                            {{ $user->updated_at->format('Y-m-d H:i:s') }}
                            <span class="badge rounded-pill bg-primary">{{ $user->updated_at->diffForHumans() }}</span>
                        </td>
                        <td>
                            <ul class="list-unstyled hstack gap-1 mb-0">
                                @can('update user')
                                    <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                        <button data-id="{{ $user->id }}" class="btn btn-sm btn-soft-info user-edit-btn"><i class="mdi mdi-pencil-outline"></i></button>
                                    </li>
                                @endcan
                                @can('delete user')
                                    <li data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Archive">
                                        <form action="{{ route('users.archive', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-soft-danger user-archive-btn">
                                                <i class="mdi mdi-delete-outline"></i>
                                            </button>
                                        </form>
                                    </li>
                                @endcan
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pagination">
            {{ $users->appends(request()->query())->links('vendor.pagination.default') }}
        </div>
    </div>
</div>