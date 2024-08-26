<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Contract</title>
</head>
<body>
    <h1>Create Contract</h1>

    <form action="{{ route('create-contract') }}" method="post">
        @csrf
       
        <label for="name">Name:</label>
        <input type="text" name="name" placeholder='name'  required>

        <label for="age">Age:</label>
        <input type="text" value="20" name="age" required>

        <button type="submit">Create Contract</button>
    </form>
</body>
</html>