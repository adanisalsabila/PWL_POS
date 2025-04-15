<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
</head>
<body>
    <h1>Profil</h1>

    @if (Auth::user()->photo)
        <img src="{{ asset('storage/photos/' . Auth::user()->photo) }}" alt="Foto Profil" width="150">
    @else
        <p>Tidak ada foto profil.</p>
    @endif

    <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photo">
        <button type="submit">Unggah Foto</button>
    </form>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>