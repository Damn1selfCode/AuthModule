<!-- resources/views/partials/node.blade.php -->

{{-- @php
    dd($node); // Esta línea imprimirá el contenido de $node y detendrá la ejecución
@endphp --}}
</br>
</br>
@if ($node)
    <script>
        console.log('Node structure:', {!! json_encode($node) !!});
    </script>

    <li style="display:none">
        <div style="border: 1px solid #ccc; padding: 20px; margin: 5px;">
            <img src="{{ $node['image_url'] }}" alt="{{ $node['name'] }}"
                style="max-width: 100px; max-height: 100px; margin-right: 10px;">
            <span>{{ $node['name'] }}</span>
            {{-- <p>Código: {{ $node['plan_id'] }}</p> --}}
        </div>

        @if (!empty($node['children']))
            <ul>
                @foreach ($node['children'] as $child)
                    @include('red.partials.node', ['node' => $child])
                @endforeach
            </ul>
        @endif
    </li>
@endif
