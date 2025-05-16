<a href="{{ route('product-categories.edit', $product->id) }}" class="btn btn-info btn-sm">
    <i class="bi bi-pencil"></i>
</a>

<form id="destroy{{ $product->id }}" action="{{ route('product-categories.destroy', $product->id) }}" method="POST"
    class="d-inline" onsubmit="return confirm('Are you sure? It will delete the data permanently!')">
    @csrf
    @method('delete')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="bi bi-trash"></i>
    </button>
</form>
