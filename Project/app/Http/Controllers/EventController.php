<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index(){

        // Pode ter uma busca
        $busca = request('search');

        // Se busca existe:
        if($busca){ 

            // select * from events where title like %busca%
            $events = Event::where([

                ['title', 'like', '%' . $busca . '%']

            ])->get();

        }else{ // Senao tiver busca:

            // Mostra todos os eventos
            $events = Event::all();
        }

        // No final retorna pra view passando parâmetros
        return view('welcome',
            [
                'events' => $events,
                'search' => $busca
            ]);
    }

    public function create(){
        return view('events.create');
    }

    public function store(Request $request){ // Rota pelo metodo 'post', pega dados fornecidos

        // variavel evento é um novo evento no banco
        $event = new Event;

        // atributo 'title' do banco é o que foi fornecido pelo formulario com o id/name 'title'
        $event->title = $request->title;

        // atributo 'city' do banco é o que foi fornecido pelo formulario com o id/name 'city'
        $event->city = $request->city;

        // atributo 'private' do banco é o que foi fornecido pelo formulario com o id/name 'private'
        $event->private = $request->private;

        // atributo 'description' do banco é o que foi fornecido pelo formulario com o id/name 'description'
        $event->description = $request->description;

        // atributo 'items' do banco é o que foi fornecido pelo formulario com o id/name 'items'
        $event->items = $request->items;

        // atributo 'date' do banco é o que foi fornecido pelo formulario com o id/name 'date'
        $event->date = $request->date;

        $event->image='event_placeholder.jpg';


        // Upload file:
        // Verificação se o objeto $request contém um arquivo com o nome "image" e se esse arquivo é válido.
        if($request->hasFile('image') && $request->file('image')->isValid()){ 

            $requestImage = $request->image; 
            // Obtém o arquivo de upload do objeto $request e atribui à variável $requestImage.

            $extension = $requestImage->extension();
            // Obtém a extensão do arquivo de upload para uso posterior.

            $imgName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            // Gera um nome único para o arquivo usando a função md5, o nome original do arquivo e o timestamp atual.

            $requestImage->move(public_path('img/events'), $imgName);
            // Move para a pasta public/img/events/img_Name

            // atributo 'image' do banco é o nome criado para a mesma
            $event->image = $imgName;

        }

        $user = auth()->user();
        $event->user_id = $user->id;

        // Salvar informaçoes no banco
        $event->save();

        return redirect("/")->with('msg','Evento Criado com Sucesso!');
    }

    public function show($id){

        $user = auth()->user();
        $hasUserJoined = false;

        if($user){
            $userEvents = $user->eventAsParticipant->toArray();

            foreach($userEvents as $userEvent){
                if($userEvent['id'] == $id){
                    $hasUserJoined = true;
                }
            }
        }
        
        $event = Event::findOrFail($id);

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show',
        [
            'event' => $event,
            'eventOwner' => $eventOwner,
            'hasUserJoined' => $hasUserJoined
        ]);
    }

    public function dashboard(){
        $user = auth()->user();

        $events = $user->events;
        $eventAsParticipant = $user->eventAsParticipant;

        return view('events.dashboard',
        [
            'events' => $events,
            'eventAsParticipant' => $eventAsParticipant
        ]);
    }

    public function destroy($id){

        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento deletado com sucesso!');
        
    }

    public function edit($id){

        $user = auth()->user();

        $event = Event::findOrFail($id);

        if($user->id != $event->user_id){
            return redirect('/dashboard');
        }
        return view('events.edit',
        [
            'event' => $event
        ]);
    }

    public function update(Request $request){

        $dados = $request->all();

        if($request->hasFile('image') && $request->file('image')->isValid()){ 

            $requestImage = $request->image; 
            // Obtém o arquivo de upload do objeto $request e atribui à variável $requestImage.

            $extension = $requestImage->extension();
            // Obtém a extensão do arquivo de upload para uso posterior.

            $imgName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            // Gera um nome único para o arquivo usando a função md5, o nome original do arquivo e o timestamp atual.

            $requestImage->move(public_path('img/events'), $imgName);
            // Move para a pasta public/img/events/img_Name

            // atributo 'image' do banco é o nome criado para a mesma
            $dados['image'] = $imgName;

        }

        Event::findOrFail($request->id)->update($dados);

        return redirect('/dashboard')->with('msg', 'Evento atualizado com sucesso!');
    }

    public function joinEvent($id){
        $event = Event::FindOrFail($id);

        $user = auth()->user();
        $user->eventAsParticipant()->attach($id);

        return redirect('/')->with('msg', 'Sua presença está confirmada no evento '.$event->title);
    }

    public function leaveEvent($id){
        $event = Event::FindOrFail($id);

        $user = auth()->user();
        $user->eventAsParticipant()->detach($id);

        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso do evento '.$event->title);
    }
}
