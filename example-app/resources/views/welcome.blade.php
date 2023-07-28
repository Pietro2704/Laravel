@extends('layouts.main')

@section('title', 'Home')

@section('content')

<div class="col-md-12" id="search-container">
    <h1>Busque um evento</h1>
    <form action="#">
        <input type="text" id="search" name="search" class="form-control" placeholder="Procurar">
    </form>
</div>


<div id="events-container" class="col-md-12">

    <h2>Próximos Eventos</h2>
    <p class="subtitle">Veja os eventos dos próximos dias</p>

    @if(count($events)==0)
        <p>Não há eventos</p>
    @endif


    <div id="cards-container" class="row">

        @foreach($events as $event)
            <div class="card col-md-3">
                <img src="/img/events/{{$event->image}}" alt="{{$event->title}}">

                <div class="card-body">

                    @if($event->date != null)
                        <p class="card-date">@formatDate($event->date)</p>
                    @else
                        <p class="card-date">Em Breve</p>
                    @endif

                    <h5 class="card-title">{{$event->title}}</h5>
                    <p class="card-participants">X Participantes</p>
                    <a href="/events/{{$event->id}}" class="btn btn-primary">Saber Mais</a>
                </div>
            </div>
        @endforeach

    </div>
</div>

@endsection