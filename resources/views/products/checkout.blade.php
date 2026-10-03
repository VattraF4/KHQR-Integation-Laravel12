@extends('components.layouts.app')

@section('content')
    <style>
        .box {
            max-width: 420px;
            margin: 60px auto;
            padding: 25px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .price {
            font-size: 1.4rem;
            font-weight: bold;
            color: #0d6efd;
        }

        .count {
            font-size: 2rem;
            font-weight: bold;
            color: red;
        }

        .qr-box {
            margin: 20px 0;
            display: flex;
            justify-content: center;
        }

        .md5 {
            font-size: 13px;
            color: #6c757d;
            word-break: break-all;
        }

        #payment-status {
            font-weight: 600;
            margin-top: 10px;
            color: #0d6efd;
        }
    </style>

    <div class="box">
        <h2 class="title">Scan KHQR</h2>

        <p>
            <strong>{{ $product->name }}</strong><br>
            <span class="price">${{ number_format($product->price, 2) }}</span>
        </p>

        @if ($qr)
            <div class="qr-box">
                {!! QrCode::size(220)->generate($qr) !!}
            </div>
            <p class="md5">
                <strong>MD5:</strong> {{ $md5 }}
            </p>
            <p id="payment-status">Waiting for payment...</p>
        @else
            <div class="alert alert-danger">
                Failed to generate QR
            </div>
        @endif

        <div class="mt-3">
            <div id="countdown" class="count">120</div>
            <small>
                Expire in <span id="seconds">120</span>s
            </small>
        </div>

        <a href="{{ route('home') }}" class="btn btn-primary mt-3">
            Back
        </a>
    </div>

    <script>
        const md5Hash = "{{ $md5 }}";
        let timeLeft = 120;
        let isPolling = false;
        let isFinished = false;

        const countdownElement = document.getElementById('countdown');
        const secondsText = document.getElementById('seconds');
        const statusElement = document.getElementById('payment-status');

        // 1. Countdown timer (runs every 1 second)
        const timer = setInterval(() => {
            if (isFinished) return;

            timeLeft--;
            countdownElement.textContent = timeLeft;
            secondsText.textContent = timeLeft;

            // Trigger payment check every 3 seconds
            if (timeLeft % 3 === 0 && timeLeft > 0) {
                checkPaymentStatus();
            }

            // When time runs out
            if (timeLeft <= 0) {
                isFinished = true;
                clearInterval(timer);
                if (statusElement) {
                    statusElement.innerText = "QR code expired. Please refresh.";
                    statusElement.style.color = "red";
                }
                alert("QR code has expired.");
                window.location.href = "{{ route('home') }}";
            }
        }, 1000);

        // 2. Verification request
        function checkPaymentStatus() {
            if (isPolling || isFinished) return;
            isPolling = true;

            fetch("{{ route('verify.transaction') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ md5: md5Hash })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Bakong verification response:", data);

                // Handles direct Bakong response (responseCode === 0) or wrapped response
                const isPaid = data.responseCode === 0 
                            || data.status === 'paid' 
                            || (data.data && data.data.responseCode === 0);

                if (isPaid) {
                    isFinished = true;
                    clearInterval(timer);

                    if (statusElement) {
                        statusElement.innerText = "Payment Successful!";
                        statusElement.style.color = "green";
                    }

                    alert("Transaction successful!");
                    window.location.href = "{{ route('home') }}";
                }
            })
            .catch(error => {
                console.error("Error polling payment status:", error);
            })
            .finally(() => {
                isPolling = false;
            });
        }
    </script>
@endsection