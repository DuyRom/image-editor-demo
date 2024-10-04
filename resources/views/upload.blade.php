<!DOCTYPE html>
<html>
<head>
    <title>Upload PDF</title>
</head>
<body>
    <form action="{{ route('upload.lock') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="pdf">Choose PDF to upload:</label>
        <input type="file" name="pdf" id="pdf" required>
        <button type="submit">Upload and Lock PDF</button>
    </form>
</body>
</html>
