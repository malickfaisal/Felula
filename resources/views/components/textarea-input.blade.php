@props(['disabled' => false])

<textarea id="textEditor" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'ckeditor border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>{{$slot}}</textarea>