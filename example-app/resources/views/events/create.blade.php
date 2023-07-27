@extends('layouts.main')

@section('title','Criar Evento')

@section('content')
<div id="event-create-container" class="col-md-6 offset-md-3">
  <h1>Crie seu Evento</h1>
  <form action="/events" method="POST" enctype="multipart/form-data">
  @csrf
    <div class="form-group mb-3">
      <label for="imagem">Imagem do evento:</label>
      <input type="file" id="image" name="image" class="form-control-file">
    </div>
    <div class="form-group mb-3">
      <label for="title">Evento:</label>
      <input type="text" name="title" id="title" class="form-control" placeholder="Nome do Evento">
    </div>
    <div class="form-group mb-3">
      <label for="title">Cidade:</label>
      <input type="text" name="city" id="city" class="form-control" placeholder="Local do Evento">
    </div>
    <div class="form-group mb-3">
      <label for="title">O evento é privado?</label>
      <select name="private" id="private" class="form-control">
        <option value="0">Não</option>
        <option value="1">Sim</option>
      </select>
    </div>
    <div class="form-group mb-3">
      <label for="title">Descrição:</label>
      <textarea name="desc" id="desc" class="form-control" placeholder="Detalhes do Evento"></textarea>
    </div>
    <input type="submit" class="btn btn-primary" value="Criar Evento">
  </form>
</div>
@endsection