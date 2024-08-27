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
                        <button id="drawButton" class="btn btn-primary mt-2">Draw</button>
                        <button id="eraseButton" class="btn btn-secondary mt-2">Erase</button>
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
        let canvas, imageInstance, cropper;
        const fileInput = document.getElementById('fileInput');
        const colorInput = document.getElementById('colorInput');
        const drawButton = document.getElementById('drawButton');
        const eraseButton = document.getElementById('eraseButton');
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
                    }
                    fabric.Image.fromURL(e.target.result, (img) => {
                        imageInstance = img;
                        img.scaleToWidth(canvas.getWidth());
                        canvas.add(img);
                        canvas.sendToBack(img); 
                        canvas.renderAll();
                    });
                });
            };
            reader.readAsDataURL(file);
        });

        drawButton.addEventListener('click', () => {
            canvas.isDrawingMode = true;
            canvas.freeDrawingBrush.color = colorInput.value;
            canvas.freeDrawingBrush.width = 5;
        });

        eraseButton.addEventListener('click', () => {
            canvas.isDrawingMode = false;
            canvas.selection = true;
            canvas.forEachObject((obj) => {
                if (obj !== imageInstance) {
                    canvas.remove(obj);
                }
            });
            canvas.renderAll();
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
                            canvas.sendToBack(img); 
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
