<!-- resources/views/word_viewer.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Viewer</title>
    <script src="https://cdn.ckeditor.com/4.17.0/standard/ckeditor.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <textarea id="editor" name="editor">{!! $htmlContent !!}</textarea>

    <script>
        // Thêm mã JavaScript sau CKEditor.replace

        CKEDITOR.replace('editor', {
            filebrowserUploadUrl: "{{ route('word.save') }}",
            filebrowserUploadMethod: 'form',
            filebrowserParams: function (param) {
                param._token = "{{ csrf_token() }}";
                return param;
            }
        });

        CKEDITOR.instances.editor.on('change', function () {
            var editorContent = CKEDITOR.instances.editor.getData();

            // Lưu nội dung khi thay đổi
            saveContent(editorContent);
        });

        function saveContent(content) {
            // Gửi nội dung lên server để lưu
            $.ajax({
                url: "{{ route('word.save') }}",
                method: 'POST',
                data: { content: content, _token: "{{ csrf_token() }}" },
                success: function (response) {
                    console.log(response.message);
                },
                error: function (error) {
                    console.error('Error saving word file:', error);
                }
            });
        }

    </script>

</body>
</html>
