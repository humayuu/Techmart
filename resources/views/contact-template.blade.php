<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Message</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
            color: #111;
            padding: 48px 16px;
        }

        .card {
            max-width: 560px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Header */
        .card-header {
            padding: 28px 32px;
            border-bottom: 1px solid #e0e0e0;
        }

        .card-header h1 {
            font-size: 16px;
            font-weight: 700;
            color: #111;
            letter-spacing: 0.2px;
        }

        .card-header p {
            font-size: 12.5px;
            color: #888;
            margin-top: 4px;
        }

        /* Body */
        .card-body {
            padding: 28px 32px;
        }

        /* Row */
        .field {
            display: flex;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .field:last-of-type {
            border-bottom: none;
        }

        .field-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #aaa;
            min-width: 70px;
            padding-top: 1px;
        }

        .field-value {
            font-size: 14px;
            color: #222;
            line-height: 1.6;
        }

        .field-value a {
            color: #222;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        /* Message */
        .message-block {
            margin-top: 20px;
            padding: 18px 20px;
            background: #fafafa;
            border: 1px solid #e8e8e8;
            border-radius: 6px;
        }

        .message-block .field-label {
            margin-bottom: 10px;
            display: block;
        }

        .message-block p {
            font-size: 14px;
            color: #333;
            line-height: 1.8;
            white-space: pre-wrap;
        }

        .card-footer p {
            font-size: 11.5px;
            color: #bbb;
        }
    </style>
</head>

<body>

    <div class="card">

        {{-- Header --}}
        <div class="card-header">
            <h1>New Message</h1>
            <p>Received from your website contact form</p>
        </div>

        {{-- Fields --}}
        <div class="card-body">

            <div class="field">
                <span class="field-label">Name</span>
                <span class="field-value">{{ $user['name'] }}</span>
            </div>

            <div class="field">
                <span class="field-label">Email</span>
                <span class="field-value">
                    <a href="mailto:{{ $user['email'] }}">{{ $user['email'] }}</a>
                </span>
            </div>

            <div class="field">
                <span class="field-label">Subject</span>
                <span class="field-value">{{ $user['subject'] }}</span>
            </div>

            {{-- Message --}}
            <div class="message-block">
                <span class="field-label">Message</span>
                <p>{{ $user['message'] }}</p>
            </div>

        </div>
    </div>

</body>

</html>
