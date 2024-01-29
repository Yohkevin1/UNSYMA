@extends('form.form')

@section('title', 'Undangan Grup')

@section('content')
    <div class="invitation-container">
        <h2>Silakan bergabung dengan grup kami!</h2>
        <div class="group-links">
            <div class="group-link">
                <img src="{{ asset('img/WA.png') }}" alt="WhatsApp Logo">
                <p>WhatsApp Group</p>
                <a href="" target="_blank" class="join-btn">Join Group</a>
            </div>
            <div class="group-link">
                <img src="{{ asset('img/Line.png') }}" alt="Line Logo">
                <p>Line Group</p>
                <a href="" target="_blank" class="join-btn">Join Group</a>
            </div>
        </div>
    </div>

    <style>
        .invitation-container {
            text-align: center;
            padding: 20px;
        }

        .group-links {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .group-link {
            text-align: center;
            margin: 0 10px;
        }

        .group-link img {
            max-width: 100px;
            margin-bottom: 10px;
        }

        .join-btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .join-btn:hover {
            background-color: #0056b3;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            position: absolute;
            top: 0;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #333;
        }
    </style>

    <script>
        function showLineModal() {
            document.getElementById('lineModal').style.display = 'block';
        }

        function closeLineModal() {
            document.getElementById('lineModal').style.display = 'none';
        }
    </script>
@endsection

