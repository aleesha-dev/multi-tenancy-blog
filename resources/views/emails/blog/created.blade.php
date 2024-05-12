@component('mail::message')
# New Blog Created!

Your blog titled **{{ $blog->title }}** has been successfully created. 

@component('mail::button', ['url' => route('blogs.show', $blog)])
View Blog Post
@endcomponent

Thank you for contributing!

Best,<br>
{{ config('app.name') }}
@endcomponent
