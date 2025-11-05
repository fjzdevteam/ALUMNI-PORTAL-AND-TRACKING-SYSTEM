@props(['id', 'next' => null, 'autofocus' => false])

<input type="text" maxlength="1" name="otp[]" id="{{ $id }}"
    @if ($autofocus) autofocus @endif
    class="w-16 h-16 text-center border rounded-lg text-2xl font-semibold 
           focus:outline-none focus:ring-2 focus:ring-indigo-500"
    @if ($next) oninput="moveNext(this, '{{ $next }}')" @endif>
