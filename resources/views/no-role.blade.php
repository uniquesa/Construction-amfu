@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out;
            max-width: 500px;
            width: 100%;
        }

        .card-header {
            background: #dc3545;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .card-body {
            text-align: center;
            padding: 30px;
        }

        .btn-primary {
            background-color: #2c5364;
            border: none;
        }

        .btn-primary:hover {
            background-color: #203a43;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-header">
                🚫 Pending Approval
            </div>
            <div class="card-body">
                <h3 class="text-danger">Sorry, you can't access your dashboard yet.</h3>
                <p class="mt-3">
                    Your account has been created successfully, but a manager needs to assign your role before you
                    can access the system.
                </p>
                <a href="{{ route('login') }}" class="btn btn-primary mt-3 px-4">
                    ⬅ Back to Login
                </a>
            </div>
        </div>
    </div>
@endsection
