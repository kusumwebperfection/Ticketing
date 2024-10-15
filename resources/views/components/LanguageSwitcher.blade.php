<div class="dropdown">
  @php
  $selected = session('locale') ? session('locale') : 'us';
  @endphp
  <a href="#" class="btn bg-gradient-dark dropdown-toggle mb-0" data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
    <img src="{{ asset('assets//img/icons/flags/' . strtoupper($selected).'.png') }}" /> {{$selected}}
  </a>
  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
    @foreach (config('app.supported_locales') as $locale => $label)
    <li>
      <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('locale-form-{{ $locale }}').submit();">
        <img src="{{ asset('assets/img/icons/flags/' . strtoupper($locale).'.png') }}" />
        {{ $label }}
      </a>
      <form id="locale-form-{{ $locale }}" method="post" action="{{ route('locale.switch') }}">
        @csrf
        <input type="hidden" name="locale" value="{{ $locale }}">
      </form>
    </li>
    @endforeach
  </ul>
</div>