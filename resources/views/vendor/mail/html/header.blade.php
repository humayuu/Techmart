@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <h1 style="color: #2d3748; font-size: 28px; font-weight: bold; margin: 0;">
                    Tech<span style="color: #3b82f6;">Mart</span>
                </h1>
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
