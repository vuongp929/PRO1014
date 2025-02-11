@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Danh sách danh mục</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Slug</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($categories as $category)
    @if ($category && $category->parent_id == null)
        <tr class="table-primary">
            <td>{{ $category->id }}</td>
            <td><strong>{{ $category->name }}</strong></td>
            <td>{{ $category->slug }}</td>
            <td>
                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete({{ $category->id }}, true)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </td>
        </tr>

        @foreach ($category->children as $child)
            @if ($child) <!-- Check if child is not null -->
                <tr>
                    <td>{{ $child->id }}</td>
                    <td>— {{ $child->name }}</td>
                    <td>{{ $child->slug }}</td>
                    <td>
                        <a href="{{ route('category.edit', $child->id) }}" class="btn btn-warning">Chỉnh sửa</a>
                        <form action="{{ route('category.destroy', $child->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete({{ $child->id }}, false)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endif
        @endforeach
    @endif
@endforeach
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete(categoryId, isParent) {
            if (isParent) {
                return confirm("⚠ Khi xóa danh mục cha này, các danh mục con cũng sẽ bị xóa. Bạn có chắc chắn muốn tiếp tục?");
            } else {
                return confirm("Bạn có chắc muốn xóa danh mục này?");
            }
        }
    </script>
@endsection
