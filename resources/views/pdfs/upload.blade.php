<!DOCTYPE html>
<html lang="en">
<head>
  <title>DEMO PDF</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
  <h2>DEMO PDF</h2>
  <form action="{{ route('upload.lock') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3 mt-3">
      <label for="pdf">Choose PDF to upload:</label>
      <input type="file" class="form-control" id="pdf" name="pdf" required>
    </div>
    <div class="row">
      <label>Rermissions:</label>
    </div>
    <div class="form-check mb-3">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" id="modify" name="permissions[]" value="modify" onclick="handleModifyCheckbox()"> Modify
      </label>
    </div>
    <div class="form-check mb-3" id="printCheckbox">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="permissions[]" value="print"> Print
      </label>
    </div>
    <div class="form-check mb-3" id="copyCheckbox">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="permissions[]" value="copy"> Copy
      </label>
    </div>
    <div class="mb-3" id="gr-password">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="owner_password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>

<script>
    function handleModifyCheckbox() {
        const modifyCheckbox = document.getElementById('modify');
        const printCheckbox = document.getElementById('printCheckbox');
        const copyCheckbox = document.getElementById('copyCheckbox');
        const passswordInput = document.getElementById('gr-password');

        if (modifyCheckbox.checked) {
            printCheckbox.querySelector('input').checked = true;
            printCheckbox.querySelector('input').disabled = true;
            copyCheckbox.querySelector('input').checked = true;
            copyCheckbox.querySelector('input').disabled = true;
            passswordInput.style.display = 'none';
        } else {
            printCheckbox.querySelector('input').checked = false;
            printCheckbox.querySelector('input').disabled = false;
            copyCheckbox.querySelector('input').checked = false;
            copyCheckbox.querySelector('input').disabled = false;
            passswordInput.style.display = 'block';
        }
    }
</script>

</body>
</html>
