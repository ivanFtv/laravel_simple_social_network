@component('mail::message')
# You created a new Post on {{ config('app.name') }}!
<br /><br />
@if (!empty($post))
    
  # Post details:<br />
  --------<br />
  Text: {{ $post->description }}<br />
  Posted at: {{ $post->created_at }}<br />

@endif

@component('mail::button', ['url' => 'http://localhost:8000/home'])
Go to DIGIBOOK
@endcomponent

Thanks,<br>
Staff {{ config('app.name') }}.
@endcomponent
