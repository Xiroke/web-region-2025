@props(['name', 'value' => ''])

<x-input
        :name="$name"
        :value="$value"
        type="date"
        {{$attributes->merge(['class' => $errors->has($name) ? 'input-error' : ''])}}
        onfocus="(this.type='date')"
        onblur="if(!this.value) this.type='text'"
        :type="$value ? 'date' : 'text'"
/>