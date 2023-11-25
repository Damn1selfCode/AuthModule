<!-- resources/views/partials/node.blade.php -->

{{-- @php
    dd($node); // Esta línea imprimirá el contenido de $node y detendrá la ejecución
@endphp --}}
</br>
</br>
@if ($node)
    <script>
        console.log(@json($node));
    </script>

    <li style="display:none; text-align: center !important;">

        <div style="border: 1px solid #ccc; padding: 10px; margin: 5px; text-align: center !important;">
            <img src="{{ $node['image_url'] }}" alt="{{ $node['name'] }}"
                style="max-width: 50px; max-height: 50px; margin-right: 10px; display: block; margin: 0 auto;">
            <span>{{ $node['name'] }}</span>
            <p>Código: {{ $node['code'] }}</p>
        </div>

        @if (!empty($node['children']))
            <ul style="text-align: center !important;">
                @foreach ($node['children'] as $child)
                    @include('red.partials.node', ['node' => $child])
                @endforeach
            </ul>
        @endif
    </li>
@endif
