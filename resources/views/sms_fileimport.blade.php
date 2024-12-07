@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('sms.import.file') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Importar</button>
</form>

