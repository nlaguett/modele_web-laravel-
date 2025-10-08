
{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <h1>{{ $item ? 'Modifier' : 'Créer' }} {{ $type }}</h1>--}}

{{--        @if ($errors->any())--}}
{{--            <div class="alert alert-danger">--}}
{{--                <ul>--}}
{{--                    @foreach ($errors->all() as $error)--}}
{{--                        <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        @if(session('success'))--}}
{{--            <div class="alert alert-success">{{ session('success') }}</div>--}}
{{--        @endif--}}

{{--        <form action="{{ $item ? route('gestion.update', [$type, $item->{$meta['id']}]) : route('gestion.store', $type) }}"--}}
{{--              method="POST">--}}
{{--            @csrf--}}
{{--            @if($item)--}}
{{--                @method('PUT')--}}
{{--            @endif--}}

{{--            --}}{{-- Boucle sur tous les champs définis dans $entitiesMeta --}}
{{--            @foreach($meta['fields'] as $field)--}}
{{--                <div class="form-group mb-3">--}}
{{--                    <label for="{{ $field }}">--}}
{{--                        {{ $meta['labels'][$field] ?? ucfirst($field) }}--}}
{{--                    </label>--}}

{{--                    @if(str_contains($field, 'Date'))--}}
{{--                        <input type="date"--}}
{{--                               class="form-control @error($field) is-invalid @enderror"--}}
{{--                               id="{{ $field }}"--}}
{{--                               name="{{ $field }}"--}}
{{--                               value="{{ old($field, $item->$field ?? '') }}">--}}

{{--                    @elseif(str_contains($field, 'Description') || str_contains($field, 'Observations'))--}}
{{--                        <textarea class="form-control @error($field) is-invalid @enderror"--}}
{{--                                  id="{{ $field }}"--}}
{{--                                  name="{{ $field }}"--}}
{{--                                  rows="4">{{ old($field, $item->$field ?? '') }}</textarea>--}}

{{--                    @elseif(str_contains($field, 'Email'))--}}
{{--                        <input type="email"--}}
{{--                               class="form-control @error($field) is-invalid @enderror"--}}
{{--                               id="{{ $field }}"--}}
{{--                               name="{{ $field }}"--}}
{{--                               value="{{ old($field, $item->$field ?? '') }}">--}}

{{--                    @elseif(str_contains($field, 'Prix') || str_contains($field, 'Quantite') || str_contains($field, 'Poids'))--}}
{{--                        <input type="number"--}}
{{--                               step="0.01"--}}
{{--                               class="form-control @error($field) is-invalid @enderror"--}}
{{--                               id="{{ $field }}"--}}
{{--                               name="{{ $field }}"--}}
{{--                               value="{{ old($field, $item->$field ?? '') }}">--}}

{{--                    @else--}}
{{--                        <input type="text"--}}
{{--                               class="form-control @error($field) is-invalid @enderror"--}}
{{--                               id="{{ $field }}"--}}
{{--                               name="{{ $field }}"--}}
{{--                               value="{{ old($field, $item->$field ?? '') }}">--}}
{{--                    @endif--}}

{{--                    @error($field)--}}
{{--                    <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                    @enderror--}}
{{--                </div>--}}
{{--            @endforeach--}}

{{--            <div class="form-group mt-3">--}}
{{--                <button type="submit" class="btn btn-primary">--}}
{{--                    {{ $item ? 'Modifier' : 'Créer' }}--}}
{{--                </button>--}}
{{--                <a href="{{ url()->previous() }}" class="btn btn-secondary">--}}
{{--                    Annuler--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--@endsection--}}
