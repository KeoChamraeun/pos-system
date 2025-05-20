<div class="d-flex">
    <a href="{{ route('product-categories.edit', $category->id) }}" class="btn btn-info btn-sm mr-2">
        <i class="bi bi-pencil"></i>
    </a>

    <form action="{{ route('product-categories.destroy', $category->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"
            onclick="return confirm('Are you sure? This will delete the category permanently!')">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</div>
