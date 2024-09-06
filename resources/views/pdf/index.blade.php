@extends('layout')
@section('content')
<head>
    <title>Write Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            background-color: ;
            padding: ;
            border-radius: ;
            box-shadow: 0 0  rgba(0,0,0,0.1);
            text-align: ;
        }
        h1 {
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        textarea {
            width: 700px;  
            height: 400px; 
            resize: none;  
            margin: 1rem 0;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: 'Times New Roman', Courier, monospace; 
            font-size: 20px;
            white-space: pre-wrap; 
        }
        .file-input {
            margin: 1rem 0;
            text-align: left;
            width: 100%;
        }
        .file-input label {
            display: block;
            margin-bottom: 0.5rem;
        }
        input[type="file"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 1rem 0;
            cursor: pointer;
            border-radius: 4px;
        }
        #file-list {
            list-style-type: none;
            padding: 0;
            margin-top: 1rem;
        }
        #file-list li {
            background-color: #f0f0f0;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .remove-file {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            cursor: pointer;
        }
        .report-container {
            position: relative;
            width: 700px;
            height: 400px;
            border: 1px solid #ddd;
            margin: 1rem 0;
        }
        #description {
            width: 100%;
            height: 100%;
            resize: none;
            padding: 0.5rem;
            border: none;
            font-family: 'Times New Roman', Courier, monospace;
            font-size: 20px;
            white-space: pre-wrap;
            position: absolute;
            top: 0;
            left: 0;
            background: transparent;
            z-index: 1;
        }
        #drawing-canvas {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 0;
        }
        .drawing-tools {
            margin-top: 0.5rem;
        }
        .drawing-tools button, .drawing-tools input {
            margin-right: 0.5rem;
            padding: 0.5rem;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }
        .drawing-tools button.active {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<div class="main-content">
    <div class="header">
        <div class="date-container">
            <p class="date-label">Today's Date</p>
            <p class="date-value">{{ now()->format('Y-m-d') }}</p>
        </div>
    </div>
    <br>
    <br>

<h1>Write Patient Report</h1>

<div class="card">
    <div class="card-header">Patient Info</div>
    <div class="card-body">
        <p><strong>Name:</strong> {{ $patient->name }}</p>
        <p><strong>Email:</strong> {{ $patient->email }}</p>
    </div>
</div>

<a href="{{ route('homeDoctor') }}">
                <button class="btn btn-light">← Back</button>
            </a>
<br>
<form method="post" action="{{ route('Patient_Report.pdf') }}" enctype="multipart/form-data">
    @csrf
    <label for="description">Your description:</label>
    <div class="report-container">
        <textarea id="description" name="description"></textarea>
        <canvas id="drawing-canvas" width="700" height="400"></canvas>
    </div>
    
    <div class="drawing-tools">
        <button type="button" id="text-mode" class="active">Text</button>
        <button type="button" id="draw-mode">Draw</button>
        <input type="range" id="pen-size" min="1" max="20" value="2">
        <span id="size-display">2px</span>
        <button type="button" id="clear-canvas">Clear Drawing</button>
    </div>

    <div>
        {!! $content !!}
    </div>
    @if($drawingData)
        <div>
            <img src="{{ $drawingData }}" alt="Drawing">
        </div>
    @endif

    <div class="file-input">
        <label for="attachments">Attach files (PDF, DOC, DOCX, JPG, JPEG, PNG):</label>
        <input type="file" id="attachments" name="attachments[]" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
    </div>
    <ul id="file-list"></ul>
    <input type="submit" value="Create PDF and ZIP">

    <a href="{{ route('medications.list') }}" class="btn btn-secondary" style="margin-top: 1rem;">Go to Medication List</a>

</form>
</div>
</body>

<script>
document.getElementById('attachments').addEventListener('change', function(e) {
    var fileList = document.getElementById('file-list');
    for (var i = 0; i < this.files.length; i++) {
        var li = document.createElement('li');
        li.innerHTML = this.files[i].name + 
            '<button type="button" class="remove-file" data-index="' + i + '">Remove</button>';
        fileList.appendChild(li);
    }
});

document.getElementById('file-list').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-file')) {
        var index = e.target.getAttribute('data-index');
        var fileInput = document.getElementById('attachments');
        var files = Array.from(fileInput.files);
        files.splice(index, 1);
        
        // Create a new FileList object (since FileList is read-only)
        var dataTransfer = new DataTransfer();
        files.forEach(file => { dataTransfer.items.add(file); });
        fileInput.files = dataTransfer.files;

        // Update the displayed list
        e.target.parentNode.remove();
    }
});

// Drawing functionality
const canvas = document.getElementById('drawing-canvas');
const ctx = canvas.getContext('2d');
const textarea = document.getElementById('description');
let isDrawing = false;
let currentMode = 'text';
let currentSize = 2;

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

// Ensure canvas size matches its display size
function resizeCanvas() {
    const rect = canvas.getBoundingClientRect();
    canvas.width = rect.width;
    canvas.height = rect.height;
}

window.addEventListener('resize', resizeCanvas);
resizeCanvas();

document.querySelector('form').addEventListener('submit', function(e) {
    const drawingData = canvas.toDataURL('image/png');
    const drawingInput = document.createElement('input');
    drawingInput.type = 'hidden';
    drawingInput.name = 'drawing';
    drawingInput.value = drawingData;
    this.appendChild(drawingInput);
});
</script>
@endsection
