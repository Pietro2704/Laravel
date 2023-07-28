<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(){

        $events = Event::all();

        return view('welcome',
            [
                'events' => $events 
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

        // atributo 'desc' do banco é o que foi fornecido pelo formulario com o id/name 'desc'
        $event->desc = $request->desc;

        // atributo 'items' do banco é o que foi fornecido pelo formulario com o id/name 'items'
        $event->items = $request->items;


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

        // Salvar informaçoes no banco
        $event->save();

        return redirect("/")->with('msg','Evento Criado com Sucesso!');
    }

    public function show($id){
        
        $event = Event::findOrFail($id);

        return view('events.show',
        [
            'event' => $event
        ]);
    }
}
