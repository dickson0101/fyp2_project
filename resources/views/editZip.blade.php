@extends('layout')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Edit Patient Report</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if(isset($pdfContent))
        <form method="post" action="{{ route('Patient_Report.update', ['reportId' => $report->id]) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Update description:</label>
                <div class="report-container relative w-full h-96 border border-gray-300 mb-4">
                    <textarea id="description" name="description" class="w-full h-full resize-none p-2 border-none font-serif text-lg whitespace-pre-wrap absolute top-0 left-0 bg-transparent z-10">{{ $pdfContent }}</textarea>
                    <canvas id="drawing-canvas" class="absolute top-0 left-0 z-0" width="700" height="384"></canvas>
                </div>
            </div>

            <div class="drawing-tools flex items-center space-x-4 mb-4">
                <button type="button" id="text-mode" class="px-4 py-2 bg-gray-200 rounded active">Text</button>
                <button type="button" id="draw-mode" class="px-4 py-2 bg-gray-200 rounded">Draw</button>
                <input type="range" id="pen-size" min="1" max="20" value="2" class="w-32">
                <span id="size-display" class="text-sm">2px</span>
                <button type="button" id="clear-canvas" class="px-4 py-2 bg-gray-200 rounded">Clear Drawing</button>
            </div>

            <div>
                <label for="new_attachments" class="block text-sm font-medium text-gray-700 mb-2">Add new files (PDF, DOC, DOCX, JPG, JPEG, PNG):</label>
                <input type="file" id="new_attachments" name="new_attachments[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="mt-1 block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100">
            </div>

            <div id="new-attachments-preview" class="mt-4 space-y-2"></div>

            <ul id="attachment-list" class="mt-4 space-y-2">
                @foreach($attachments as $attachment)
                    <li class="text-sm text-gray-600">
                        {{ $attachment['name'] }}
                        <button type="button" class="ml-2 text-red-600 hover:text-red-800" onclick="removeAttachment('{{ $attachment['name'] }}')">Remove</button>
                    </li>
                @endforeach
            </ul>

            <input type="hidden" name="removed_attachments" id="removed_attachments">

            <input type="hidden" name="temp_dir" value="{{ $tempDir }}">
            <input type="hidden" name="drawing" id="drawing-data">
            
            <div>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Report
                </button>
            </div>
        </form>
    @else
        <p class="text-red-600">Error: Unable to load report content. Please try again or contact support.</p>
    @endif
</div>

<script>
    document.getElementById('new_attachments').addEventListener('change', function(e) {
    var previewArea = document.getElementById('attachment-list');
    
    for (var i = 0; i < this.files.length; i++) {
        var file = this.files[i];
        var li = document.createElement('li');
        li.className = 'text-sm text-gray-600';
        li.innerHTML = file.name + 
            ' (' + (file.size / 1024).toFixed(2) + ' KB) ' +
            '<button type="button" class="ml-2 text-red-600 hover:text-red-800" onclick="removeNewAttachment(this, \'' + file.name + '\')">Remove</button>';
        previewArea.appendChild(li);
    }
});

function removeNewAttachment(button, fileName) {
    // Remove the item from the UI
    button.closest('li').remove();

    // Add to removed_attachments
    const removedAttachments = document.getElementById('removed_attachments');
    removedAttachments.value += fileName + ',';
}

function removeAttachment(fileName) {
    const listItem = event.target.closest('li');
    const removedAttachments = document.getElementById('removed_attachments');

    // Add the removed file name to the hidden input field
    if (removedAttachments.value) {
        removedAttachments.value += ',' + fileName;
    } else {
        removedAttachments.value = fileName;
    }

    // Remove the item from the list
    listItem.remove();
}

    // Drawing functionality
    const canvas = document.getElementById('drawing-canvas');
    const ctx = canvas.getContext('2d');
    const textarea = document.getElementById('description');
    let isDrawing = false;
    let currentMode = 'text';
    let currentSize = 2;

    // Load existing drawing if available
    const existingDrawing = @json($drawingData ?? '');
    if (existingDrawing) {
        const img = new Image();
        img.onload = function() {
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        }
        img.src = existingDrawing;
    }

    document.getElementById('text-mode').addEventListener('click', function() {
        currentMode = 'text';
        this.classList.add('active');
        document.getElementById('draw-mode').classList.remove('active');
        textarea.style.pointerEvents = 'auto';
        canvas.style.pointerEvents = 'none';
    });

    document.getElementById('draw-mode').addEventListener('click', function() {
        currentMode = 'draw';
        this.classList.add('active');
        document.getElementById('text-mode').classList.remove('active');
        textarea.style.pointerEvents = 'none';
        canvas.style.pointerEvents = 'auto';
    });

    document.getElementById('pen-size').addEventListener('input', function(e) {
        currentSize = e.target.value;
        document.getElementById('size-display').textContent = currentSize + 'px';
    });

    document.getElementById('clear-canvas').addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    function startDrawing(e) {
        if (currentMode !== 'draw') return;
        isDrawing = true;
        draw(e);
    }

    function draw(e) {
        if (!isDrawing || currentMode !== 'draw') return;
        
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        ctx.lineWidth = currentSize;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000000';
        
        ctx.lineTo(x, y);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(x, y);
    }

    function stopDrawing() {
        isDrawing = false;
        ctx.beginPath();
    }

    // Ensure canvas size matches its container
    function resizeCanvas() {
        const container = canvas.parentElement;
        canvas.width = container.clientWidth;
        canvas.height = container.clientHeight;
    }

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    document.querySelector('form').addEventListener('submit', function(e) {
        const drawingData = canvas.toDataURL('image/png');
        document.getElementById('drawing-data').value = drawingData;
    });
</script>
@endsection
