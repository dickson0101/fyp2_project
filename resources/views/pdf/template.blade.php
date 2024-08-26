<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Courier', monospace;
            font-size: 14pt;
            line-height: 1.15;
        }
        h1 {
            font-family: 'Times New Roman', serif;
            font-size: 30px;
            color: #333;
        }
        .content {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .drawing {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Patient Report</h1>
    <pre class="content">{!! $content !!}</pre>
    @if(!empty($drawingData))
        <div class="drawing">
            <img src="{{ $drawingData }}" alt="Drawing" />
        </div>
    @endif
</body>
</html>