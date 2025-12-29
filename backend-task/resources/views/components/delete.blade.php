@props(['delete_item_title'])

<form {{ $attributes->merge(['class' => 'unset delete-item']) }} method="POST" enctype="multipart/form-data">
    @csrf
    @method('DELETE')

    {{ $slot }}
</form>