@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Whoops! Something went wrong.</h4>
        <hr>
        {{-- <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p> --}}
        <ul class="mt-3 list-unstyled  list-inside text-sm text-red">
            <div class="alert alert-danger" role="alert">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                  @endforeach
              </div>
          
               
            </ul>
      </div>
@endif
