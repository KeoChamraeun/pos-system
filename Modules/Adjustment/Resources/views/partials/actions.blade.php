@can('edit_adjustments')
    <a href="{{ route('adjustments.edit', $data->id) }}" class="btn btn-info btn-sm">
        <i class="bi bi-pencil"></i>
    </a>
@endcan
@can('show_adjustments')
    <a href="{{ route('adjustments.show', $data->id) }}" class="btn btn-primary btn-sm">
        <i class="bi bi-eye"></i>
    </a>
@endcan
@can('delete_adjustments')
    <button id="delete" class="btn btn-danger btn-sm" onclick="
        event.preventDefault();
        if (confirm('{{ __('Are you sure? It will delete the data permanently!') }}')) {
        document.getElementById('destroy{{ $data->id }}').submit()
        }
        ">
        <i class="bi bi-trash"></i>
        <form id="destroy{{ $data->id }}" class="d-none" action="{{ route('adjustments.destroy', $data->id) }}" method="POST">
            @csrf
            @method('delete')
        </form>
    </button>
@endcan
