<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Image Editor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #canvasContainer {
            position: relative;
        }
        #textCanvas {
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <input type="file" id="fileInput" accept="image/*" capture="camera" class="form-control">
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Edit Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="canvasContainer">
                        <canvas id="imageCanvas"></canvas>
                    </div>
                    <div class="mt-3">
                        <input type="color" id="colorInput" class="form-control mt-2">
                        <button id="addTextButton" class="btn btn-primary mt-2">Add Text</button>
                        <button id="editTextButton" class="btn btn-secondary mt-2">Edit Text</button>
                        <button id="deleteTextButton" class="btn btn-danger mt-2">Delete Text</button>
                        <button id="cropButton" class="btn btn-secondary mt-2">Crop</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="saveButton" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let canvas, imageInstance, cropper, selectedText;
        const fileInput = document.getElementById('fileInput');
        const colorInput = document.getElementById('colorInput');
        const addTextButton = document.getElementById('addTextButton');
        const editTextButton = document.getElementById('editTextButton');
        const deleteTextButton = document.getElementById('deleteTextButton');
        const cropButton = document.getElementById('cropButton');
        const saveButton = document.getElementById('saveButton');
        const imageModal = $('#imageModal');
        const imageCanvas = document.getElementById('imageCanvas');

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (!file.type.startsWith('image/')) {
                alert('Please upload an image file.');
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                imageModal.modal('show');
                imageModal.on('shown.bs.modal', () => {
                    if (canvas) {
                        canvas.clear();
                    } else {
                        canvas = new fabric.Canvas('imageCanvas');
                        canvas.on('mouse:down', function(event) {
                            if (event.target && event.target.type === 'i-text') {
                                selectedText = event.target;
                                colorInput.value = selectedText.fill;
                            } else {
                                selectedText = null;
                                colorInput.value = '#000000';
                            }
                        });
                    }
                    fabric.Image.fromURL(e.target.result, (img) => {
                        imageInstance = img;
                        img.scaleToWidth(canvas.getWidth());
                        canvas.add(img);
                        canvas.sendToBack(img); // Đảm bảo hình ảnh nằm dưới văn bản
                        canvas.renderAll();
                    });
                });
            };
            reader.readAsDataURL(file);
        });

        addTextButton.addEventListener('click', () => {
            const text = new fabric.IText('Enter text here', {
                left: 50,
                top: 50,
                fontSize: 30,
                fill: colorInput.value
            });
            canvas.add(text);
            canvas.setActiveObject(text);
            text.enterEditing();
            text.hiddenTextarea.focus(); // Đảm bảo textarea ẩn được focus để người dùng có thể gõ ngay lập tức
            canvas.bringToFront(text); // Đảm bảo văn bản nằm trên hình ảnh
            canvas.renderAll();
        });

        editTextButton.addEventListener('click', () => {
            if (selectedText) {
                selectedText.fill = colorInput.value;
                canvas.renderAll();
            } else {
                alert('Please select a text to edit.');
            }
        });

        deleteTextButton.addEventListener('click', () => {
            if (selectedText) {
                canvas.remove(selectedText);
                selectedText = null;
                colorInput.value = '#000000';
                canvas.renderAll();
            } else {
                alert('Please select a text to delete.');
            }
        });

        cropButton.addEventListener('click', () => {
            if (cropper) {
                cropper.destroy();
            }
            const croppedDataUrl = canvas.toDataURL({
                format: 'png',
                quality: 1
            });

            const cropImage = new Image();
            cropImage.src = croppedDataUrl;
            cropImage.onload = () => {
                cropper = new Cropper(cropImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    ready() {
                        const cropperCanvas = cropper.getCanvasData();
                        canvas.setWidth(cropperCanvas.width);
                        canvas.setHeight(cropperCanvas.height);
                        canvas.clear();
                        fabric.Image.fromURL(croppedDataUrl, (img) => {
                            canvas.add(img);
                            canvas.sendToBack(img); // Đảm bảo hình ảnh nằm dưới văn bản
                            canvas.renderAll();
                        });
                    }
                });
                document.body.appendChild(cropImage);
            };
        });

        saveButton.addEventListener('click', () => {
            const finalDataUrl = canvas.toDataURL({
                format: 'png',
                quality: 1
            });

            fetch(finalDataUrl)
                .then(res => res.blob())
                .then(blob => {
                    const formData = new FormData();
                    formData.append('image', blob, 'image.png');

                    fetch('/upload', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        imageModal.modal('hide');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
        });

        imageModal.on('hidden.bs.modal', () => {
            if (canvas) {
                canvas.clear();
            }
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });
    </script>
</body>
</html>
